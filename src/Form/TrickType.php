<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $group = new Group();
        $groups = ['le meilleur groupe' => $group];
        
        $builder
            ->add('name', TextType::class, [
                'attr' => ['autofocus' => true],
                'label' => 'Nom de la figure'
            ])
            ->add('description', TextareaType::class)
            ->add('picture', CollectionType::class, [
                'entry_type' => PicturesType::class,
                'label' => "Images de la figure",
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('tagsVideo', TextareaType::class, [
                'label' => 'Balise(s) <embed> de vidéos en ligne'
            ])
            ->add('relatedGroup', EntityType::class, [
                'class' => Group::class,
                'choice_label' => 'name',
                'label' => 'Groupe'
            ])
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}