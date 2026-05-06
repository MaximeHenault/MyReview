<?php

namespace App\Form;

use App\Entity\Audiovisuel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;

class SerieAnimeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'required' => true
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => true
            ])
            ->add('realisateur', TextType::class, [
                'label' => 'Réalisateur',
                'required' => true
            ])
            ->add('dateCreation', DateType::class, [
                'label' => 'Date de création',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('affiche', FileType::class, [
                'label' => 'Affiche',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'accept' => '.jpg,.jpeg,.png,image/jpeg,image/png',
                ],
                'constraints' => [
                    new Assert\NotNull(message: 'Merci de selectionner une affiche.'),
                ],
            ])
            ->add('saisons', CollectionType::class, [
                'entry_type' => SaisonFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audiovisuel::class,
        ]);
    }
}
