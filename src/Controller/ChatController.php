<?php
namespace App\Controller;

use App\Service\ChatService;
use App\Service\TelegramService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    private $chatService;
    private $telegramService;

    private $tgInitData;
    private $id;
    private $type;

    public function __construct(ChatService $chatService, TelegramService $telegramService)
    {
        // Supportive custom services with useful util methods
        // See https://symfony.com/doc/current/service_container.html for more info
        $this->chatService = $chatService;
        $this->telegramService = $telegramService;

        // We fetch Chat ID from Telegram InitData instead of request params
        // to prevent unauthorized access to any other user's chat
        $this->tgInitData = $telegramService->getInitData();
        $this->id = $this->tgInitData["chat_instance"];
    }


    #[Route('/api/getChat', methods: ['GET'])]
    public function getChat()
    {
        // Fetch Chat from DB if exists
        $chat = $this->chatService->get((int) $this->id);

        // Return chat Instance converted to safe array
        // Check src/Entity/Chat.php for more info
        return $this->json($chat->toArray());
    }
}
