<?php

namespace App\Services;

use App\Controller\TrickController;
use App\Entity\Trick;
use App\Form\PicturesType;

class HandlerFormPictures extends TrickController
{
    public function createFormForeachPicture(Trick $trick)
    {
        $formsPictures = [];
        foreach ($trick->getPictures() as $picture) {
            $formsPictures = [$picture->getName() => $this->createForm(PicturesType::class, $picture, [
                'required' => false
            ])];
        }
        return $formsPictures;
    }

    public function createView(array $formsPictures)
    {
        $array = [];
        foreach ($formsPictures as $picturename => $form) {
            $array = [$picturename => $form->createView()];
        }
        return $array;
    }
}