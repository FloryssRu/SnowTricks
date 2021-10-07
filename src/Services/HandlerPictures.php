<?php

namespace App\Services;

use App\Controller\TrickController;
use App\Entity\Trick;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

class HandlerPictures extends TrickController
{
    public function savePictures(Request $request, Trick $trick, SluggerInterface $slugger)
    {
        for ($i = 1; $i > 0; $i++) {

            if (isset($request->files->all()['trick']['picture'][$i]['picturefile'])) {
                
                $picturefile = $request->files->all()['trick']['picture'][$i]['picturefile'];

                $originalFilename = pathinfo($picturefile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picturefile->guessExtension();
        
                try {
                    $picturefile->move(
                        $this->getParameter('app.pictures.directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $trick->getPicture()->toArray()[$i-1]->setName($newFilename);

                unset($picturefile);
                
            } else {
                break;
            }
        }
    }
}