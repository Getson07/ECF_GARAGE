<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Model;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
                'expanded' => true,
                'required' => false,
            ])
            ->add('models', EntityType::class, [
                'label' => 'first Models',
                'class' => Model::class,
                'choice_label' => 'name',
                'group_by' => 'brand',
                'multiple' => true,
                'expanded' => true,
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
            ->add('gearbox', ChoiceType::class, [
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
                'constraints' => [ new Positive(null, 'Vous devez entrer un nombre positif')],
                'label' => '',
                'attr' => ['placeholder' => 'Min Price'],
                'required' => false,
            ])
            ->add('maxPrice', IntegerType::class, [
                'constraints' => [ new Positive(null, 'Vous devez entrer un nombre positif')],
                'label' => '',
                'attr' => ['placeholder' => 'Max Price'],
                'constraints' => [new Positive()],
                'required' => false,
            ])
            ->add('minYear', IntegerType::class, [
                'constraints' => [ new Positive(null, 'Vous devez entrer un nombre positif')],
                'label' => '',
                'attr' => ['placeholder' => 'Min Year'],
                'constraints' => [new Positive()],
                'required' => false,
            ])
            ->add('maxYear', IntegerType::class, [
                'constraints' => [ new Positive(null, 'Vous devez entrer un nombre positif')],
                'label' => '',
                'attr' => ['placeholder' => 'Max Year'],
                'constraints' => [new Positive()],
                'required' => false,
            ])
        ;
        $builder->get('brands')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event){
                $form = $event->getForm();
                $form->getParent()->add('models', EntityType::class, [
                    'label' => $form->getData(),
                    'class' => Model::class,
                    'choice_label' => 'name',
                    'choices' => count($form->getData()) == 1 ? $form->getData()->first()->getModels() : $this->getModels($form),
                                //  call_user_func_array('array_merge', array($form->getData()->map(function(?Brand $brand){
                                //     return $brand instanceof Brand ? $brand->getModels()->toArray() : ["throw new Exception('Pas une marque')"];
                                // }))),
                    // 'choices' => array_map(function($brand){
                    //     return $brand->getModels();
                    // },$form->getData()->getValues()),
                    // 'choices' => $form->getData()->getModels(),
                    'multiple' => true,
                    'expanded' => true,
                ]);
                // $form->getParent()->add('manyBrands', TextType::class, [
                //     'attr' => ['value' => $form->getData()],
                // ]);

            }
        );
    }
    private function getModels($form):Collection
    {
        // throw new Exception('Marques reçues'.(implode(',',$form->getData()->getValues()) == '' ? 'Vide' : 'nonvide'));
        throw new Exception('Marques reçues'.(implode(',',$form->getData()->first())));
        $models2d = $form->getData()->map(function($brand){
            throw new Exception('Non de la marque'.$brand);
            ($brand instanceof Brand) ? $brand->getModels() : throw new Exception('Pas une marque');
        });
        $models1d = new ArrayCollection();
        // dd($models1d);
        // $models1d = $models2d->map(function($models){
        //     $models->map(function($model){
        //         $model;
        //     });
        // });
        throw new Exception('Pas un ensemble de marques '.(implode(',',$models2d->getValues()) == '' ? 'Vide' : 'nonvide'));
        $models2d = $models2d->getValues();
        for ($i = 0; $i < count($models2d); $i++) {
            // if (! $models instanceof Collection) throw new Exception('Pas un ensemble de marques');
            // foreach ($models->toArray() as $key => $model) {
            //     if(!$model instanceof Model) throw new Exception('Pas un modèle');
            //     $models1d->add($model);
            // }
            dd($models1d);
        }

        return $models1d;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
