<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Exception;

/**
 * Validate the initData received via the Mini App
 * More info: https://core.telegram.org/bots/webapps#validating-data-received-via-the-mini-app
 */
class TelegramValidationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $path = $request->getPathInfo();
        $initData = $request->query->get('tgInitData');

        // Skip validation if the request for path outside the scope of validation
        if (strpos($path, $_ENV['TELEGRAM_VALIDATION_PATH_PREFIX']) !== 0) {
            return;
        }

        try {
            $isValid = $initData && $this->validate($initData);
            if (!$isValid) {
                $event->setResponse(new JsonResponse(['error' => 'Invalid initData provided']));
            }
        } catch (Exception $e) {
            $event->setResponse(new JsonResponse(['error' => $e->getMessage()]));
        }

        return;
    }

    private function validate(string $initData): bool
    {
        parse_str($initData, $params);

        if (!isset($params['hash'], $params['auth_date'])) {
            throw new Exception('Invalid initData provided');
        }

        // For the logic of this application we require chat_instance and chat_type
        // But it is not required for the all the applications
        // So you can remove this condition if you don't need it
        if (!isset($params['chat_instance'], $params['chat_type'])) {
            throw new Exception('Chat instance info is not provided');
        }

        $appHash = $params['hash'] ;
        $auth_date = $params['auth_date'];

        $dataForHashing = $this->buildDataForHashing($params);

        $botToken = $_ENV['TELEGRAM_BOT_TOKEN'];
        $secret_key = hash_hmac( 'sha256', $botToken, "WebAppData", TRUE );
        $hash = bin2hex( hash_hmac( 'sha256', $dataForHashing, $secret_key, TRUE ) );

        // Verify the auth_date to prevent outdated data usage
        // Assuming data older than specified ENV value is outdated
        $currentTimestamp = time();
        if (abs($currentTimestamp - $params['auth_date']) > $_ENV['TELEGRAM_VALIDATION_REQUEST_EXPIRATION']) {
            throw new Exception('Outdated request. Please reload and try again');
        }

        return $params['hash'] === $hash;
    }

    private function buildDataForHashing(array $params): string
    {
        unset($params['hash']);
        ksort($params);

        $checkStrings = [];
        foreach ($params as $key => $value) {
            $checkStrings[] = sprintf('%s=%s', $key, $value);
        }

        return implode("\n", $checkStrings);
    }
}
