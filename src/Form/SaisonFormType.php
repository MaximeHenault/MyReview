<?php

namespace App\Form;

use App\Entity\Saison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaisonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', IntegerType::class, 
                [
                    'label' => 'Numéro de saison',
                    'required' => true
                ]
            )
            ->add('titre', TextType::class, 
                [
                    'label' => 'Titre',
                    'required' => true
                ]
            )
            ->add('nbEpisode', IntegerType::class, 
                [
                    'label' => 'Nombre d\'épisodes',
                    'required' => true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Saison::class,
        ]);
    }
}
