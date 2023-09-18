<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brands', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ])
            ->add('model', EntityType::class, [
                'class' => Model::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ])
            ->add('energy', ChoiceType::class, [
                'label' => 'Energie', 
                'choices' => [
                    'Essence' => 'Essence',
                    'Diesel' => 'Diesel',
                    'Electrique' => 'Electrique',
                    'Hybride' => 'Hybride',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('geabox', ChoiceType::class, [
                'label' => 'Boîte de vitesse', 
                'choices' => [
                    'Automatique' => 'Automatique',
                    'Manuelle' => 'Manuelle',
                ],
                'multiple' => false,
                'expanded' => true,
                'required' => false,
            ])
            ->add('minPrice', IntegerType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Min Price'],
                'required' => false,
            ])
            ->add('maxPrice', IntegerType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Max Price'],
                'constraints' => [new Positive()],
                'required' => false,
            ])
            ->add('minYear', IntegerType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Min Year'],
                'constraints' => [new Positive()],
                'required' => false,
            ])
            ->add('maxYear', IntegerType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Max Year'],
                'constraints' => [new Positive()],
                'required' => false,
            ])
            ->add('minMeter', IntegerType::class, [
                'label' => null,
                'attr' => ['placeholder' => 'Min Meter'],
                'constraints' => [new Positive()],
                'required' => false,
            ])
            ->add('maxMeter', IntegerType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Max Meter'],
                'constraints' => [new Positive()],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
