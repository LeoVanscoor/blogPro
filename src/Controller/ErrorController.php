<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ErrorController extends AbstractController
{
    #[Route('/access-denied', name: 'access_denied')]
    public function index(): Response
    {
        $this->addFlash('error', 'Vous n\'avez pas accès à cette partie du site.');
        return $this->redirectToRoute('app_home');
    }
}
