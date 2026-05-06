<?php

namespace App\Form;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

class NoteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', HiddenType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(
                        message: 'Choisis une note entre 1 et 5.',
                    ),
                    new Range(
                        min: 1,
                        max: 5,
                        notInRangeMessage: 'La note doit etre comprise entre 1 et 5 avec des pas de 0.5.',
                    ),
                    new Regex(
                        pattern: '/^(?:[1-4](?:\\.5)?|5(?:\\.0)?)$/',
                        message: 'La note doit etre comprise entre 1 et 5 avec des pas de 0.5.',
                    ),
                ],
            ])
            ->add('commentaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
