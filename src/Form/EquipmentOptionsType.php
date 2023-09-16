<?php

namespace App\Form;

use App\Entity\EquipmentOptions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('exterior_and_chassis')
            ->add('interior')
            ->add('security')
            ->add('security_lock')
        ;
        $builder->get('exterior_and_chassis')->addModelTransformer(new CallbackTransformer(
            function($roleAsArray){
                if(count($roleAsArray)) return implode($roleAsArray);
            },
            fn ($rolesAsString) => [$rolesAsString]
    ));
        $builder->get('interior')->addModelTransformer(new CallbackTransformer(
            function($roleAsArray){
                if(count($roleAsArray)) return implode($roleAsArray);
            },
            fn ($rolesAsString) => [$rolesAsString]
    ));
    $builder->get('security')->addModelTransformer(new CallbackTransformer(
        function($roleAsArray){
            if(count($roleAsArray)) return implode($roleAsArray);
        },
        fn ($rolesAsString) => [$rolesAsString]
    ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EquipmentOptions::class,
        ]);
    }
}
