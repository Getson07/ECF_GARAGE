<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Model;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['placeholder' => 'FIAT 500 II 1.4 16V 100 LOUNGE']
            ])
            ->add('imageFiles', FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'required' => false,
            ])
            ->add('serie', TextType::class, [
                'label' => 'Numéro de série',
                'required' => false,
                'mapped' => false,
            ])
            ->add('price')
            ->add('fiscal_power')
            ->add('engine_power')
            ->add('euro_standard')
            ->add('crit_air')
            ->add('combined_consumption')
            ->add('co2_emission')
            ->add('model', EntityType::class, [
                'class' => Model::class,
                'choice_label' => 'name',
                'group_by' => 'brand'
            ])
            ->add('characteristics', CarCaracteristicType::class)
            ->add('equipmentOptions', EquipmentOptionsType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
