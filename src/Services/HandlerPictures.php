<?php

namespace App\Services;

use App\Controller\TrickController;
use App\Entity\Trick;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class HandlerPictures extends TrickController
{
    public function savePictures(array $pictures, Trick $trick, SluggerInterface $slugger)
    { 
        for ($i = 0; $i > -1; $i++) {

            if (isset($pictures[$i]['picturefile'])) {
                
                $picturefile = $pictures[$i]['picturefile'];

                if ($picturefile !== 'picture_already_exists') {

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
                    $trick->getPictures()->toArray()[$i]->setName($newFilename);

                    unset($picturefile);
                }

            } else {
                break;
            }
        }
    }

    public function deleteEmptyPictures(array $pictures)
    {
        $newPictures = [];
        foreach ($pictures as $picture) {
            if ($picture['picturefile'] === NULL) {
                $picture['picturefile'] = 'picture_already_exists';
            }
            $newPictures[]['picturefile'] = $picture['picturefile'];
        }
        return $newPictures;
    }
}