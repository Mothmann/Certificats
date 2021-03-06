<?php

namespace App\Form;

use App\Entity\Administrateur;
use App\Entity\Etudiant;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etudiant',EntityType::class, [
                'required' => false,
                'class' => Etudiant::class])
            ->add('administrateur',EntityType::class, [
                'required'  => false,
                'class' => Administrateur::class])
            ->add('modifier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'required' => 'false',
        ]);
    }
}
