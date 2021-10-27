<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PicturesType;
use App\Services\HandlerAccount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/account")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("", name="app_account", methods={"GET", "POST"})
     */
    public function index(Request $request, HandlerAccount $handlerAccount, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(PicturesType::class, $user, [
            'data_class' => User::class,
            'label_picture' => "Changer d'image"
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $picturename = $handlerAccount->userUpdatePicture($this->getUser(), $request->files->all()['pictures']['picturefile'], $slugger);

            $user->setPictureName($picturename);

            $em->persist($user);
            $em->flush();

            $this->addflash('success', 'Votre image a bien été modifiée.');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/index.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
