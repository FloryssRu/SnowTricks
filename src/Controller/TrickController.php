<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Form\MessageType;
use App\Repository\TrickRepository;
use App\Services\HandlerPictures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickController extends AbstractController
{
    /**
     * @Route("/", name="app_trick_home", methods={"GET"})
     */
    public function index(TrickRepository $repo): Response
    {
        $tricks = $repo->findAll(); //dd($tricks[1]);
        return $this->render('trick/index.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/figure/creation", name="app_trick_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, HandlerPictures $handlerPictures): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();

            $handlerPictures->savePictures($request, $trick, $slugger);

            $trick->setSlug($slugger->slug($trick->getName()));

            $em->persist($trick);
            $em->flush();

            $this->addflash('success', 'La figure a bien été ajoutée.');

            return $this->redirectToRoute('app_trick_home');
        }

        return $this->render('trick/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/figure/modification/{slug<[0-9a-zA-Z\-]+>}", name="app_trick_update", methods={"GET", "POST"})
     */
    public function update(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, HandlerPictures $handlerPictures, TrickRepository $TrickRepo, string $slug): Response
    {
        $trick = $TrickRepo->findOneBy(['slug' => $slug]);

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();

            $handlerPictures->savePictures($request, $trick, $slugger);

            $trick->setSlug($slugger->slug($trick->getName()));

            $em->persist($trick);
            $em->flush();

            $this->addflash('success', 'La figure a bien été modifiée.');

            return $this->redirectToRoute('app_trick_home');
        }

        return $this->render('trick/update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/figure/delete/{id<[0-9]+>}", name="app_trick_delete", methods={"GET"})
     */
    public function delete(EntityManagerInterface $em, TrickRepository $TrickRepo, int $id): Response
    {
        $trick = $TrickRepo->find($id);

        $em->remove($trick);
        $em->flush();

        $this->addflash('success', 'Le trick a bien été supprimé.');

        return $this->redirectToRoute('app_trick_home');
    }

    /**
     * @Route("/figure/{slug<[0-9a-zA-Z\-]+>}", name="app_trick_show", methods={"GET", "POST"})
     */
    public function show(Request $request, EntityManagerInterface $em, TrickRepository $TrickRepo, string $slug): Response
    {
        $trick = $TrickRepo->findOneBy(['slug' => $slug]);

        $message = new Message();

        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();

            $message->setDateCreation(date("Y-m-d H:i:s"));

            //attribuer le message à l'utilisateur connecté
            $message->setUser("user");

            $message->setTrick($trick);

            $em->persist($message);
            $em->flush();

            $this->addflash('success', 'Votre message a bien été ajouté.');

            return $this->redirectToRoute('app_trick_home');
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }
}
