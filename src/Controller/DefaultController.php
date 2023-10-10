<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{

    #[Route('/miniapp')]
    public function frontpage()
    {
      $tmpl = file_get_contents('../public/miniapp/index.html');
      $response = new Response();
      $response->setContent($tmpl);
      return $response;
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
