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
