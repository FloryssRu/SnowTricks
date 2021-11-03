<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use App\Repository\TrickRepository;
use App\Services\HandlerPictures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use DateTime;

class TrickController extends AbstractController
{
    public $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="app_home", methods={"GET"})
     */
    public function index(TrickRepository $repo): Response
    {
        $tricks = $repo->findAll();
        return $this->render('trick/index.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/figure/creation", name="app_trick_create", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */
    public function create(Request $request, SluggerInterface $slugger, HandlerPictures $handlerPictures): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handlerPictures->savePictures($request->files->all()['trick']['pictures'], $trick, $slugger);

            $trick->setSlug($slugger->slug($trick->getName()));

            $this->em->persist($trick);
            $this->em->flush();

            $this->addflash('success', 'La figure a bien été ajoutée.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('trick/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/figure/modification/{slug<[0-9a-zA-Z\-]+>}", name="app_trick_update", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */
    public function update(Request $request, SluggerInterface $slugger, HandlerPictures $handlerPictures, Trick $trick): Response
    {
        $form = $this->createForm(TrickType::class, $trick, [
            'required_pictures' => false,
            'name_autofocus' => false
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictures = $handlerPictures->deleteEmptyPictures($request->files->all()['trick']['pictures']);
            $handlerPictures->savePictures($pictures, $trick, $slugger);

            $trick->setSlug($slugger->slug($trick->getName()));
            $trick->setModifiedAt(new DateTime());

            $this->em->flush();

            $this->addflash('success', 'La figure a bien été modifiée.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('trick/update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/figure/delete/{id<[0-9]+>}", name="app_trick_delete", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Trick $trick): Response
    {
        if ($this->isCsrfTokenValid('trick_delete_' . $trick->getId(), $request->request->get('csrf_token'))) {
            $this->em->remove($trick);
            $this->em->flush();
        }

        $this->addflash('success', 'Le trick a bien été supprimé.');

        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/figure/{slug<[0-9a-zA-Z\-]+>}", name="app_trick_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Trick $trick, MessageRepository $messageRepo): Response
    {
        $message = new Message();

        $form = $this->createForm(MessageType::class, $message);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setUser($this->getUser());

            $message->setTrick($trick);

            $this->em->persist($message);
            $this->em->flush();

            $this->addflash('success', 'Votre message a bien été ajouté.');

            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()]);
        }

        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $messageRepo->getMessagePaginator($trick, $offset);

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
            'messages' => $paginator,
            'previous' => $offset - MessageRepository::MESSAGES_PER_PAGE,
            'next' => min(count($paginator), $offset + MessageRepository::MESSAGES_PER_PAGE)
        ]);
    }
}