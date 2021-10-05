<?php

namespace App\Controller;

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
     * @Route("/", name="app_trick_home")
     */
    public function index(TrickRepository $repo): Response
    {
        $tricks = $repo->findAll();
        return $this->render('trick/index.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/figure/creation")
     */
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, HandlerPictures $handlerPictures): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            $handlerPictures->savePictures($imageFile);

            
            $trick = $form->getData();dd($trick);
            $em->persist($trick);
            $em->flush();

            return $this->redirectToRoute('app_trick_index');
        }

        return $this->render('trick/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
