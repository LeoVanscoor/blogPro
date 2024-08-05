<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Commentaire;
use App\Form\BlogPost1Type;
use App\Form\CommentaireType;
use App\Repository\BlogPostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog/post')]
class BlogPostController extends AbstractController
{
    #[Route('/', name: 'app_blog_post_index', methods: ['GET'])]
    public function index(BlogPostRepository $blogPostRepository): Response
    {
        return $this->render('blog_post/index.html.twig', [
            'blog_posts' => $blogPostRepository->findAll(),
        ]);
    }

    #[Route('blog/post/new', name: 'app_blog_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $blogPost = new BlogPost();
        $form = $this->createForm(BlogPost1Type::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogPost->setLastUpdated(new DateTime());
            $blogPost->setAuthor($security->getUser());
            $entityManager->persist($blogPost);
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog_post/new.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blog_post_show')]
    public function show(BlogPost $blogPost, Request $request, EntityManagerInterface $em): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setBlogpost($blogPost);
            $commentaire->setDateCreation(new \DateTime());
            $commentaire->setAuthor($this->getUser());

            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('app_blog_post_show', ['id' => $blogPost->getId()]);
        }

        return $this->render('blog_post/show.html.twig', [
            'blog_post' => $blogPost,
            'commentForm' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_blog_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BlogPost $blogPost, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogPost1Type::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogPost->setLastUpdated(new DateTime());
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog_post/edit.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blog_post_delete', methods: ['POST'])]
    public function delete(Request $request, BlogPost $blogPost, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $blogPost->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($blogPost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
