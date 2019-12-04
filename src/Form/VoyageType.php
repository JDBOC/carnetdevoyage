<?php

namespace App\Form;

use App\Entity\Voyage;
use App\Form\ImageType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('lieu')
            ->add('description')
            ->add('depart', DateType::class, [
              'widget' => 'single_text'
            ])
            ->add('retour', DateType::class, [
              'widget' => 'single_text'
            ])

            ->add('coverImage')
          ->add ('images',
            CollectionType::class,
            [
              'entry_type' => ImageType::class,
              'allow_add' => true,
              'allow_delete' => true
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
          [
            'entry_type' => ImageType::class
          ]
        ]);
    }
}
