<?php

namespace App\EventSubscriber;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ReviewSubscriber implements EventSubscriberInterface
{
    public function getSubscribedEvents(): array
    {
        return [
            'postPersist' => 'postPersist',
            'postUpdate' => 'postUpdate',
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof Review) {
            $this->updateChat($entity, $args);
        }
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof Review) {
            $this->updateChat($entity, $args);
        }
    }

    private function updateChat(Review $review, LifecycleEventArgs $args): void
    {
        $chat = $review->getChat();
        $chatId = $chat->getId();

        $em = $args->getEntityManager();
        $reviewsRepository = $em->getRepository(Review::class);
        $reviewsCount = $reviewsRepository->countByChat($chatId);
        $averageRating = $reviewsCount > 0 ? $reviewsRepository->getChatAverageRating($chatId) : 5;

        $chat->setReviewsCount($reviewsCount);
        $chat->setRating($averageRating);

        $em->persist($chat);
        $em->flush();
    }

}
