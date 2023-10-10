<?php

namespace App\Service;

use App\Entity\Chat;
use App\Repository\ChatRepository;
use Doctrine\ORM\EntityManagerInterface;

class ChatService
{
    private $chatRepository;
    private $entityManager;

    private $tgInitData;

    public function __construct(ChatRepository $chatRepository, EntityManagerInterface $entityManager, TelegramService $telegramService)
    {
        $this->chatRepository = $chatRepository;
        $this->entityManager = $entityManager;

        $this->tgInitData = $telegramService->getInitData();
    }

    /**
     * Get chat by ID
     *
     * @param int $id
     * @return Chat|null
     */
    public function get(int $id): ?Chat
    {
        // Find chat by ID
        $chat = $this->chatRepository->find($id);

        // Create new chat DB record if it doesn't exist
        if ($chat === null) {
            $chat = $this->create((int) $id);
        }

        return $chat;
    }

    /**
     * Create a new chat record with the specified ID
     *
     * @param int $id
     * @param string $type (optional; will be get from tgInitData if not specified)
     * @return Chat|null
     */
    public function create(int $id, string $type = null): Chat|null
    {
        $type = $type ?? $this->tgInitData['chat_type'] ?? null;
        if(!$type) return null; // prevent creation of new chat record if no type is specified
        $type = ucfirst($type);

        $chat = new Chat();
        $chat->setId($id);
        $chat->setType($type);
        $chat->setRating(0);
        $chat->setReviewsCount(0);

        $this->entityManager->persist($chat);
        $this->entityManager->flush();

        return $chat;
    }
}
