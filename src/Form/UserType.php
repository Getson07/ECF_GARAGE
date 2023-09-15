<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Employé' =>'ROLE_EMPLOYE',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'first_name' => 'first',
                'second_name' => 'second',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom', 
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille'
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'HOMME' => 'Homme',
                    'FEMME' => 'Femme'
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('date_of_birth', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'choice',
                'years' => range(date('Y')-10, date('Y')-120, -1),
            ])
        ;
        $builder->get('roles')->addModelTransformer(new CallbackTransformer(
                fn ($rolesAsArray) => count($rolesAsArray) ? $rolesAsArray[0]: null,
                fn ($rolesAsString) => [$rolesAsString]
        ));
        // $builder->get('gender')->addModelTransformer(new CallbackTransformer(
        //         fn ($rolesAsArray) => count($rolesAsArray) ? $rolesAsArray[0]: null,
        //         fn ($rolesAsString) => [$rolesAsString]
        // ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
