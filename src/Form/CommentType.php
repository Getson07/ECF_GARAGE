<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'mapped' => false,
                'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer une valeur svp']),
                ],
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'mapped' => false,
                'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer une valeur svp']),
                ],
                'label' => 'Nom de famille',
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre avis compte',
            ])
            ->add('rate', ChoiceType::class, [
                'label' => 'Notez nous',
                'choices' => [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                ],
                'expanded' => 'true', 
                'multiple' => false 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
