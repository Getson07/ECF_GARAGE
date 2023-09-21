<?php

namespace App\Form;

use App\Entity\CarCaracteristic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarCaracteristicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('year_of_launch')
            ->add('origin')
            ->add('technichal_control')
            ->add('first_hand')
            ->add('energy')
            ->add('gearbox')
            ->add('color')
            ->add('number_of_doors')
            ->add('number_of_seats')
            ->add('length')
            ->add('trunk_volume')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarCaracteristic::class,
        ]);
    }
}
