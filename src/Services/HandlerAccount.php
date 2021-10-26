<?php

namespace App\Services;

use App\Controller\AccountController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class HandlerAccount extends AccountController
{
    public function userUpdatePicture(User $user, $picturefile, SluggerInterface $slugger)
    {
        if ($user->getPictureName() !== NULL) {
            unlink("img-users/" . $user->getPictureName());
            $user->setPictureName(NULL);
        }

        $originalFilename = pathinfo($picturefile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$picturefile->guessExtension();

        try {
            $picturefile->move(
                $this->getParameter('app.user.directory'),
                $newFilename
            );
        } catch (FileException $e) {
            $this->addFlash('fail', "L'image ne s'est pas enregistrée.");
        }

        return $newFilename;
    }
}