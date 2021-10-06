<?php

namespace App\Services;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class HandlerPictures
{
    public function savePictures(FormInterface $form, SluggerInterface $slugger)
    {
        //pour chaque picture ajoutée
        foreach ($form->getData()->getPicture()->toArray() as $attribute => $picture) {
            dd($picture);

            //on récupère l'image
            $imageFile = $form->get('picture')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('app.image.directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
    
                $unite->setImageFilename($newFilename);
            }

        }
    }
}