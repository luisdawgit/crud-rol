<?php

namespace App\Form;

use App\Entity\Personaje;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Clan;


class PersonajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('experiencia', NumberType::class, [
                'label' => 'Puntos de experiencia del personaje',
                'data' => 0,
            ])

            ->add(
                'nombre', TextType::class, [
                'label' => 'Nombre del personaje'
                ])

            ->add('clan', EntityType::class, [
                'class' => Clan::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Selecciona un clan',
                'label' => 'Clan',
                ])

            ->add('naturaleza', TextType::class,[
                    'label'=>'Naturaleza del personaje'
                ])

            ->add('conducta', TextType::class,[
                    'label'=>'Conducta del personaje'
                ])

            ->add('concepto', TextType::class,[
                    'label'=>'Concepto del personaje'
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personaje::class,
        ]);
    }
}