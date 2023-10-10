<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
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
