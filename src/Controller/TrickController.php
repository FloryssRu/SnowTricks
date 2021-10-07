<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Form\TrickType;
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
     * @Route("/figure/{slug<[0-9a-zA-Z\-]+>}", name="app_trick_show", methods={"GET"})
     */
    public function show(TrickRepository $TrickRepo, string $slug): Response
    {
        $trick = $TrickRepo->findOneBy(['slug' => $slug]);

        $form = $this->createForm(MessageType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();

            $handlerPictures->savePictures($request, $trick, $slugger);

            $trick->setSlug($slugger->slug($trick->getName()));

            $em->persist($trick);
            $em->flush();

            $this->addflash('success', 'Votre message a bien été ajouté.');

            return $this->redirectToRoute('app_trick_home');
        }

        
        return $this->render('trick/show.html.twig', [
            'trick' => $trick
        ]);
    }
}
