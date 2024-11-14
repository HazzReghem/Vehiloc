<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => "Nom de la voiture"])
            ->add('description')
            ->add('monthlyPrice')
            ->add('dailyPrice',  NumberType::class, ['label' => 'Prix journalier'])
            ->add('seatNumber', ChoiceType::class, [
                'label' => 'Nombre de places',
                'choices' => range(1, 9, 1),
                'choice_label' => function ($choice) {
                    return $choice;
                },
            ])
            ->add('manual', ChoiceType::class, [
                'label' => 'Boîte de vitesse',
                'choices' => [
                    'Manuelle' => true,
                    'Automatique' => false,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
