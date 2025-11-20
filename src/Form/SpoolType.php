<?php

namespace App\Form;

use App\Entity\Spool;
use App\Entity\SpoolBrand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SpoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('color', ColorType::class, [
                'label' => 'Spool Color',
            ])
            ->add('spoolBrand', EntityType::class, [
                'class' => SpoolBrand::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a brand',
                'label' => 'Brand',
            ])
            ->add('grams')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Spool::class,
        ]);
    }
}
