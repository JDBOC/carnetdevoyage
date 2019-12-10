<?php

namespace App\Form;

use App\Entity\Etapes;
use App\Entity\Voyage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapesType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('lieu')
            ->add('date', DateType::class, [
              'widget' => 'single_text'
            ])
            ->add('auteur')
            ->add('description')
            ->add ('voyage', EntityType::class, [
              'class' => Voyage::class,
              'choice_label' => 'lieu'

            ])
            ->add ('image', CollectionType::class, [
              'entry_type' => ImageType::class,
              'allow_add' => true,
              'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etapes::class,

        ]);
    }
}
