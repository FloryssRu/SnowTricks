<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/", name="app_trick_home")]
     */
    public function index(TrickRepository $repo): Response
    {
        $tricks = $repo->findAll();
        return $this->render('trick/index.html.twig', [
            'tricks' => $tricks
        ]);
    }
}
