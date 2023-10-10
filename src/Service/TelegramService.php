<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class TelegramService
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getInitData(): ?array
    {
        $request = $this->requestStack->getCurrentRequest();
        $tgInitDataString = $request->query->get('tgInitData');

        if (!$tgInitDataString) {
                // TODO: Comment this before release
                // Mockup data for local tests
                $tgInitData = [];
                $tgInitData['chat_instance'] = -1322753467608872744;
                $tgInitData['chat_type'] = 'channel';
                $tgInitData['user'] = [
                    'id' => 234702445,
                    'first_name' => 'Pavel',
                    'last_name' => 'Durov',
                    'username' => 'durov',
                    'language_code' => 'en',
                    'is_premium' => false
                ];
                return $tgInitData;

            return [];
        }

        $tgInitDataString_decoded = urldecode($tgInitDataString);
        parse_str($tgInitDataString_decoded, $tgInitData);

        if(isset($tgInitData['user'])) {
            $tgInitData['user'] = json_decode($tgInitData['user'], true);
        }

        return $tgInitData;
    }
}
