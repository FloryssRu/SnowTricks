<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Services\EmailSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private $emailSender;

    public function __construct(EmailSender $emailSender)
    {
        $this->emailSender = $emailSender;
    }

    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
        if ($this->getUser()) {
            $this->addFlash('fail', 'Vous êtes déjà connecté.');
            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->hashPassword($user, $form->get('plainPassword')->getData()));
            $em->persist($user);
            $em->flush();
            
            $this->emailSender->sendEmail($user, 'Veuillez confirmer votre adresse email', 'registration/confirmation_email.html.twig');

            $this->addFlash('success', "Bienvenue " . $user->getUserIdentifier() . " ! Un email de confirmation d'email vous a été envoyé.");
            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email/<token>", name="app_verify_email")
     */
    public function verifyUserEmail(string $token): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isCsrfTokenValid('verify_email_' . $this->getUser()->getId(), $token)) {
            $this->addFlash('error', "Votre email n'a pas pu être validé. Veuillez réessayer.");

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Votre adresse email a été vérifiée.');

        return $this->redirectToRoute('app_home');
    }
}
