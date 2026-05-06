<?php

namespace App\Form;

use App\Entity\Audiovisuel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class FilmFormType extends AbstractType
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
            ->add('duree', IntegerType::class, [
                'label' => 'Durée (minutes)',
                'required' => true
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audiovisuel::class,
        ]);
    }
}
