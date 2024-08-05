<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Commentaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $em): Response
    {
        $blogPosts = $em->getRepository(BlogPost::class)->findAll();
        $commentaires = $em->getRepository(Commentaire::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'blogPosts' => $blogPosts,
            'commentaires' => $commentaires,
        ]);
    }
}
