<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    //fonction gettrickdata() retourne un tableau de données
    //fonction à appeler dans load où on fera juste un foreach

    public function load(ObjectManager $manager): void
    {
        //, SluggerInterface $slugger
        // ---------------------- User

        $user = new User();
        $user
            ->setUsername('Toto')
            ->setEmail('floryss.devweb+10@gmail.com')
            ->setPassword($hasher->encodePassword('secret', null))
            ->setIsVerified(true)
        ;
        $manager->persist($user);

        // ---------------------- Groups

        $group1 = new Group();
        $group1->setName('Groupe super cool'); // à changer

        // ---------------------- 1

        $pictureTrick1 = new Picture();
        $trick1 = new Trick();

        $pictureTrick1
            ->setName('') // à remplir
            ->setTrick($trick1) // vérifier si ça marche bien
        ;

        $trick1
            ->setName('') // à remplir
            ->setSlug($slugger->slug($trick1->getName()))
            ->setDescription('') // à remplir
            ->addPicture($pictureTrick1) //à changer
            ->setTagsVideo('') // à remplir
            ->setRelatedGroup($group1) // à changer
        ;

        // ---------------------- 2

        $pictureTrick2 = new Picture();
        $trick2 = new Trick();

        $pictureTrick2
            ->setName('') // à remplir
            ->setTrick($trick2) // vérifier si ça marche bien
        ;

        $trick2
            ->setName('') // à remplir
            ->setSlug($slugger->slug($trick1->getName()))
            ->setDescription('') // à remplir
            ->addPicture($pictureTrick1) //à changer
            ->setTagsVideo('') // à remplir
            ->setRelatedGroup($group1) // à changer
        ;

        // ---------------------- 3

        $pictureTrick3 = new Picture();
        $trick3 = new Trick();

        $pictureTrick3
            ->setName('') // à remplir
            ->setTrick($trick3) // vérifier si ça marche bien
        ;

        $trick3
            ->setName('') // à remplir
            ->setSlug($slugger->slug($trick1->getName()))
            ->setDescription('') // à remplir
            ->addPicture($pictureTrick1) //à changer
            ->setTagsVideo('') // à remplir
            ->setRelatedGroup($group1) // à changer
        ;

        // ---------------------- 4

        $pictureTrick4 = new Picture();
        $trick4 = new Trick();

        $pictureTrick4
            ->setName('') // à remplir
            ->setTrick($trick4) // vérifier si ça marche bien
        ;

        $trick4
            ->setName('') // à remplir
            ->setSlug($slugger->slug($trick1->getName()))
            ->setDescription('') // à remplir
            ->addPicture($pictureTrick1) //à changer
            ->setTagsVideo('') // à remplir
            ->setRelatedGroup($group1) // à changer
        ;

        // ---------------------- 5

        $pictureTrick5 = new Picture();
        $trick5 = new Trick();

        $pictureTrick5
            ->setName('') // à remplir
            ->setTrick($trick5) // vérifier si ça marche bien
        ;

        $trick5
            ->setName('') // à remplir
            ->setSlug($slugger->slug($trick1->getName()))
            ->setDescription('') // à remplir
            ->addPicture($pictureTrick1) //à changer
            ->setTagsVideo('') // à remplir
            ->setRelatedGroup($group1) // à changer
        ;

        // ---------------------- 6

        $pictureTrick6 = new Picture();
        $trick6 = new Trick();

        $pictureTrick6
            ->setName('') // à remplir
            ->setTrick($trick6) // vérifier si ça marche bien
        ;

        $trick6
            ->setName('') // à remplir
            ->setSlug($slugger->slug($trick1->getName()))
            ->setDescription('') // à remplir
            ->addPicture($pictureTrick1) //à changer
            ->setTagsVideo('') // à remplir
            ->setRelatedGroup($group1) // à changer
        ;

        // ---------------------- 7

        $pictureTrick7 = new Picture();
        $trick7 = new Trick();

        $pictureTrick7
            ->setName('') // à remplir
            ->setTrick($trick7) // vérifier si ça marche bien
        ;

        $trick7
            ->setName('') // à remplir
            ->setSlug($slugger->slug($trick1->getName()))
            ->setDescription('') // à remplir
            ->addPicture($pictureTrick1) //à changer
            ->setTagsVideo('') // à remplir
            ->setRelatedGroup($group1) // à changer
        ;

        // ---------------------- 8

        $pictureTrick8 = new Picture();
        $trick8 = new Trick();

        $pictureTrick8
            ->setName('') // à remplir
            ->setTrick($trick8) // vérifier si ça marche bien
        ;

        $trick8
            ->setName('') // à remplir
            ->setSlug($slugger->slug($trick1->getName()))
            ->setDescription('') // à remplir
            ->addPicture($pictureTrick1) //à changer
            ->setTagsVideo('') // à remplir
            ->setRelatedGroup($group1) // à changer
        ;

        // ---------------------- 9

        $pictureTrick9 = new Picture();
        $trick9 = new Trick();

        $pictureTrick9
            ->setName('') // à remplir
            ->setTrick($trick9) // vérifier si ça marche bien
        ;

        $trick9
            ->setName('') // à remplir
            ->setSlug($slugger->slug($trick1->getName()))
            ->setDescription('') // à remplir
            ->addPicture($pictureTrick1) //à changer
            ->setTagsVideo('') // à remplir
            ->setRelatedGroup($group1) // à changer
        ;

        // ---------------------- 10

        $pictureTrick10 = new Picture();
        $trick10 = new Trick();

        $pictureTrick10
            ->setName('') // à remplir
            ->setTrick($trick10) // vérifier si ça marche bien
        ;

        $trick10
            ->setName('') // à remplir
            ->setSlug($slugger->slug($trick1->getName()))
            ->setDescription('') // à remplir
            ->addPicture($pictureTrick1) //à changer
            ->setTagsVideo('') // à remplir
            ->setRelatedGroup($group1) // à changer
        ;

        $manager->flush();
    }
}
