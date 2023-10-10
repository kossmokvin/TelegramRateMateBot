<?php
namespace App\Controller;

use App\Service\ChatService;
use App\Service\UserService;
use App\Service\ReviewService;
use App\Service\TelegramService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    private $reviewService;
    private $chatService;
    private $userService;
    private $telegramService;

    private $tgInitData;
    private $chatId;
    private $chatType;
    private $userId;

    public function __construct(ReviewService $reviewService, ChatService $chatService, UserService $userService, TelegramService $telegramService)
    {
        // Supportive custom services with useful util methods
        // See https://symfony.com/doc/current/service_container.html for more info
        $this->reviewService = $reviewService;
        $this->chatService = $chatService;
        $this->userService = $userService;
        $this->telegramService = $telegramService;

        // We get Chat ID from Telegram InitData instead of request params
        // to prevent unauthorized access to any other user's chat
        // In this case we are sure that will deal with reviews of opened channel only
        $this->tgInitData = $telegramService->getInitData();
        $this->chatId = $this->tgInitData["chat_instance"];
        $this->userId = $this->tgInitData["user"]['id'];
    }


    #[Route('/api/addReview', methods: ['GET'])]
    public function addReview(Request $request)
    {
        // Using chatId from the Telegram InitData to filter reviews
        // And avoid unauthorized access to any other user's reviews
        // that might be possible if we use request chatId param
        $chatId = (int) $this->chatId;
        $userId = (int) $this->userId;


        $rating = $request->query->getInt('rating'); // Default empty string if not provided
        $comment = $request->query->getString('comment', "");  // Default empty string if not provided
        $chat = $this->chatService->get($chatId);
        $author = $this->userService->get($userId);
        $anonymous = $request->query->getBoolean('anonymous', false);

        if (!$rating ||!$chat ||!$author) {
            return $this->json(['error' => 'Missing required parameters to add a review'], 400);
        }

        $review = $this->reviewService->create([
            'rating' => $rating,
            'comment' => $comment,
            'author' => $author,
            'chat' => $chat,
            'anonymous' => $anonymous
        ]);

        // Return action status and review Instance converted to safe array
        // Check src/Entity/Review.php for more info
        return $this->json(['success' => true, 'review' => $review->toArray()]);
    }


    #[Route('/api/getReviews', methods: ['GET'])]
    public function getReviews(Request $request)
    {
        // Using chatId from the Telegram InitData to filter reviews
        // And avoid unauthorized access to any other user's reviews
        // that might be possible if we use request chatId param
        $chatId = (int) $this->chatId;
        $userId = (int) $this->userId;

        // Fetch page and perPage values from the query string of Request
        $page = (int) $request->query->get('page', 1); // Default to 1 if not provided
        $perPage = (int) $request->query->get('perPage', 20); // Default to 20 if not provided

        // Fetch the reviews page data using the service's getPage method
        // which returns an array of Review instances and total count of chat reviews
        $pageData = $this->reviewService->getPage($chatId, $page, $perPage);

        // Return the review of current user in separate field
        // to make it easier to display it in the template
        // but make this request only for page 1, avoiding performance issues
        $userReview = $page === 1 ? $this->reviewService->getUserReview($userId, $chatId) : null;


        // Convert the array of Review entities to an array of associative arrays
        $reviews = array_map(function($review) {
            return $review->toArray();
        }, $pageData["reviews"]);

        // Return the reviews and total count in JSON format
        return $this->json([
            'success' => true,
            'chatId' => $chatId,
            'reviews' => $reviews,
            'userReview' => $userReview ? $userReview->toArray() : null,
            'isLastPage' => $pageData["isLastPage"],
            'total' => $pageData["total"]
        ]);
    }


}
