<?php

namespace App\Controller;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Adresse email'])
            ->add('message', TextareaType::class, ['label' => 'Message'])
            ->add('send', SubmitType::class, ['label' => 'Envoyer'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
                ->from($data['email'])
                ->to('vanscoorleo@gmail.com')
                ->subject('Formulaire de contact')
                ->text("Name: {$data['name']}\nEmail: {$data['email']}\nMessage: {$data['message']}");

                try {
                    $mailer->send($email);
                    $this->addFlash('success', 'Email sent successfully!');
                } catch (TransportExceptionInterface $e) {
                    $this->addFlash('error', 'Transport error while sending email: ' . $e->getMessage());
                } catch (LogicException $e) {
                    $this->addFlash('error', 'Logic error while sending email: ' . $e->getMessage());
                } catch (\Exception $e) {
                    $this->addFlash('error', 'An unexpected error occurred: ' . $e->getMessage());
                }
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView()
        ]);
    }
}
