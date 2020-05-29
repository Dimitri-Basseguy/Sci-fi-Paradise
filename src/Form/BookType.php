<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('summary', TextareaType::class)
            // ->add('score')
            ->add('style')
            ->add('cover', CoverType::class)
            // ->add('users')
        ;
    }

    // public function buildForm(FormBuilderInterface $builder, array $options)
    // {
    //     $builder
    //         ->add('title', TextType::class, [
    //             'attr' => ['class' => 'form-control'],
    //             'label' => 'Titre',
    //         ])
    //         ->add('author', TextType::class, [
    //             'attr' => ['class' => 'form-control'],
    //             'label' => 'Auteur',
    //             // 'label_attr': {'style' => 'margin-bottom: 0px;margin-top: 1rem;'},
    //         ])
    //         // ->add('date', DateTimeType::class, [
    //         //     'attr' => ['class' => 'form-control'],
    //         //     'label' => 'Date de publication',
    //         //     'required' => FALSE,tu
    //         //     'widget' => 'single_text',
    //         //     'format' => 'MM/dd/yyyy',
    //         //     'html5' => FALSE,
    //         //   ])
    //         ->add('summary', TextareaType::class, [
    //             'attr' => [
    //                 'class' => 'form-control',
    //             ],
    //             'label' => 'Résumé du livre',
    //         ])
    //         // ->add('score')
    //         ->add('style', TextType::class, [
    //             'attr' => ['class' => 'form-control'],
    //             'label' => 'Style du livre',
    //         ])
    //         ->add('cover', CoverType::class, [
    //             'label' => 'Couverture',
    //         ])
    //         // ->add('users')
    //     ;
    // }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
