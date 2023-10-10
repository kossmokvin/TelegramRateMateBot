<?php

namespace App\Service;

use App\Entity\Chat;
use App\Entity\Review;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;

class ReviewService
{
    private $reviewRepository;
    private $entityManager;

    private $tgInitData;

    public function __construct(ReviewRepository $reviewRepository, EntityManagerInterface $entityManager, TelegramService $telegramService)
    {
        $this->reviewRepository = $reviewRepository;
        $this->entityManager = $entityManager;

        $this->tgInitData = $telegramService->getInitData();
    }

    /**
     * Create a new review.
     *
     * @param array $params {
     *     @type int $rating
     *     @type string $comment
     *     @type Chat $chat
     *     @type User $author
     *     @type bool $anonymous (optional)
     * }
     * @return Review|null
     */
    public function create(array $params): ?Review
    {
        // Incoming parameters
        $rating    = $params['rating'];
        $comment   = mb_substr($params['comment'], 0, 300);
        $chat      = $params['chat'];
        $author    = $params['author'];
        $anonymous = $params['anonymous'] ?? false;

        // Rating validation
        if ($rating < 1) $rating = 1;
        if ($rating > 5) $rating = 5;

        // anonymous validation
        // make it not anonymous if user is not premium
        if(empty($this->tgInitData['user']['is_premium'])) {
            $anonymous = false;
        }

        // Preparing current datetime object
        // in format required by Entity
        date_default_timezone_set('UTC');
        $now = new \DateTimeImmutable('now');

        // Check if there is already a review for this chat and user
        // If so - we are going to update it instead of creating a new one
        // as the user can review the same chat only once
        $userId = (int) $this->tgInitData['user']['id'];
        $chatId = (int) $this->tgInitData['chat_instance'];
        $review = $this->getUserReview($userId, $chatId);

        if(!$review) { // Create new if it doesn't exist'
            $review = new Review(); // Create new review instance

            // Set fields that has sense to set while creating only
            $review->setChat($chat);
            $review->setCreatedAt($now);
        } else { // Update existing if it exists
            // Set fields that has sense to set while creating only
            $review->setUpdatedAt($now);
        }

        // Set fields that has sense to set while both creating and updating
        $review->setRating($rating);
        $review->setComment($comment);
        $review->setAuthor($author);
        $review->setChat($chat);
        $review->setAnonymous($anonymous);

        // Trigger DB changes
        $this->entityManager->persist($review);
        $this->entityManager->flush();

        return $review;
    }

    /**
     * Get a paginated list of reviews filtered by chat
     *
     * @param int $chatId
     * @param int $page
     * @param int $perPage
     * @return array {
     *     @type array $reviews {
     *         @type Review $review
     *     }
     *     @type int $total
     *     @type int $chatId
     *     @type int $page
     *     @type int $perPage
     *     @type bool $isLastPage
     * }
     */
    public function getPage(int $chatId, int $page, int $perPage): array
    {
        // Calculate the offset for the query
        $offset = ($page - 1) * $perPage;

        // Use the review repository to fetch the paginated reviews filtered by chatId
        // where findBy is a classical Docrtine ORM method
        // which is present in ServiceEntityRepository (parent class of ReviewRepository)
        $reviews = $this->reviewRepository->findBy(
            ['chat' => $chatId],
            ['id' => 'DESC'],
            $perPage,
            $offset
        );

        // Iterate through each review and apply the additional logic
        foreach ($reviews as $review) {
            // If the review author's ID is 123, mark the review as "mine"
            if ($review->getAuthor()->getId() === 123) {
                $review->setIsMine(true);
            }

            // If the review is anonymous, set its author to null
            if ($review->isAnonymous()) {
                $review->setAuthor(null);
            }
        }

        // Fetch the total count of reviews for the given chat
        $totalCount = $this->reviewRepository->countByChat($chatId);

        // Calculate if requested page is the last page in the list
        $isLastPage = $page * $perPage >= $totalCount;

        return [
          'reviews'    => $reviews,
          'total'      => $totalCount,
          'page'       => $page,
          'perPage'    => $perPage,
          'chatId'     => $chatId,
          'isLastPage' => $isLastPage
        ];

    }

    /**
     * Get the first review written by a specific user.
     *
     * @param int $userId
     * @return Review|null
     */
    public function getUserReview(int $userId, int $chatId): ?Review
    {
        return $this->reviewRepository->findOneBy([
            'author' => $userId,
            'chat' => $chatId
        ]);
    }

}
