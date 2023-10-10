<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{

    /**
     * Main Controller that opens the Vue Frontend Build
     */
    #[Route('/app')]
    public function tgMiniApp()
    {
      $tmpl = file_get_contents('../public/miniapp/index.html');
      $response = new Response();
      $response->setContent($tmpl);
      return $response;
    }

    /**
     * Telegram endpoint route for the RateMateBot
     * It is simple as the bot itself has no logic,
     * his only purpose to let everyone know the link to the MiniApp
     */
    #[Route('/telegram-bot-endpoint')]
    public function handleUpdate(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        // Extract message from the content
        $message = $content['message'] ?? null;
        if ($message) {
            $chatId = $message['chat']['id'];
            $token = $_ENV["TELEGRAM_BOT_TOKEN"];

            $apiUrl = "https://api.telegram.org/bot{$token}/sendMessage";
            $postData = [
                'chat_id' => $chatId,
                'text' => "👋 Hey!\r\n\r\nTo check out Telegram community reviews and rate any group, channel, bot (or even a person soon), simply publish this link in any Telegram chat and click on it. Wherever it is published it opens an app to rate and review that chat!\r\n\r\nhttps://t.me/RateMateBot/rate\r\n\r\nIf you are a Channel Admin, you can publish it as a post and pin it. Let your community provide honest feedback and comments. And even if you won’t do this — they will be able to rate your place by publishing this link in channel comments!\r\n\r\nAlso you can click this link right now and rate this awesome @RateMateBot itself! As this link is published in this channel now - your review will be forever assigned to this Bot, will affect its average rating and will be available for all Telegram users."
                ];

            // Send message using any HTTP client. Here's a simple example using file_get_contents:
            file_get_contents($apiUrl . "?" . http_build_query($postData));
        }

        // Return a simple response to Telegram
        return new Response('OK', Response::HTTP_OK);
    }


    /**
     * Default controller to test is there everything ok with Symfony Routes
     */
    #[Route('/test')]
    public function getChat()
    {
        return $this->json([
            'success' => true,
            'message' => 'Congratulations!'
        ]);
    }
}
