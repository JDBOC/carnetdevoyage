<?php

namespace App\Form;

use App\Entity\Etapes;
use App\Entity\Voyage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapesType extends AbstractType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etapes::class,
        ]);
    }
}
