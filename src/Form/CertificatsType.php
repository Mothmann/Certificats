<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Certificats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class CertificatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
            ])
            ->add('Valder',SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Certificats::class,
        ]);
    }
}
