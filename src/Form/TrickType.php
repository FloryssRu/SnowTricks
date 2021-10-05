<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Picture;
use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('picture', FileType::class, [
                'label' => "Images de la figure",
                'mapped' => false,
                'required' => true,
                'multiple' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Importez une image .jpg ou .png'
                    ])
                ]
            ])
            ->add('tagsVideo', TextareaType::class, [
                'label' => 'Balise(s) <embed> de vidéos en ligne'
            ])
            ->add('relatedGroup', ChoiceType::class, [
                'choices' => $groups
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