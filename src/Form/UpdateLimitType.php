<?php

namespace App\Form;

use App\Entity\Limit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateLimitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
     $builder
            ->add('att_scolarite',TextType::class)
            ->add('conv_stage',TextType::class)
            ->add('rel_note',TextType::class)
            ->add('user', EntityType::class, [
                'class' => User::class,
            ])
            ->add('ajouter', SubmitType::class)
        ;
    }

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => Limit::class,
        'required' => 'false',
    ]);
}
}
