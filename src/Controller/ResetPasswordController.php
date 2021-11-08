<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\UserRepository;
use App\Services\HandlerResetPassword;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @Route("/reset-password"), methods={"GET"})
 */
class ResetPasswordController extends AbstractController
{
    private $UserRepo;
    private $em;
    private $session;

    public function __construct(UserRepository $UserRepo, EntityManagerInterface $em, Session $session, CsrfTokenManagerInterface $csrfManager)
    {
        $this->UserRepo = $UserRepo;
        $this->em = $em;
        $this->session = $session;
        $this->csrfManager = $csrfManager;
    }

    /**
     * Display & process form to request a password reset.
     * @Route("", name="app_forgot_password_request", methods={"GET", "POST"})
     */
    public function request(Request $request, MailerInterface $mailer, HandlerResetPassword $handlerResetPassword): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $handlerResetPassword->findEmailByUserName($form->get('username')->getData(), $this->UserRepo);

            return $this->processSendingPasswordResetEmail(
                $email,
                $mailer
            );
        }

        return $this->render('reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     * @Route("/reset/{token}", name="app_reset_password", methods={"GET", "POST"})
     */
    public function reset(Request $request, UserPasswordHasherInterface $passwordEncoder, HandlerResetPassword $handlerResetPassword, string $token = null): Response
    {
        if ($token !== $this->session->get('resetToken')) {
            $this->session->set('resetToken', $token);
            return $this->redirectToRoute('app_reset_password');
        }

        $token = $this->session->get('resetToken');

        if (null === $token) {
            throw $this->createNotFoundException("Aucun token de réinitialisation de mot de passe trouvé dans la session ou dans l'URL.");
        }

        try {
            $user = $handlerResetPassword->validateTokenAndFetchUser($token);
        } catch (Exception $e) {
            $this->addFlash('error', 'Il y a eu un problème avec votre requête.');

            return $this->redirectToRoute('app_forgot_password_request');
        }

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $passwordEncoder->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);
            $this->em->flush();
            $this->session->clear();
            $this->addFlash('success', 'Votre mot de passe a bien été changé.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

    private function processSendingPasswordResetEmail(string $email, MailerInterface $mailer): RedirectResponse
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'email' => $email,
        ]);

        $token = $this->csrfManager->getToken('reset_password');

        $email = (new TemplatedEmail())
            ->from(new Address('noreply@snowtricks.com', 'Snowtricks'))
            ->to($user->getEmail())
            ->subject('Votre demande de réinitialisation de mot de passe')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'token' => $token
            ])
        ;

        $mailer->send($email);

        $user->setToken($token);
        $this->em->persist($user);
        $this->em->flush();

        $this->session->set('resetToken', $token);

        return $this->render('reset_password/check_email.html.twig', [
            'resetToken' => $token
        ]);
    }
}
