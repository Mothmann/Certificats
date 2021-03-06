<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Filiere;
use App\Entity\User;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code_apogee', TextType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('cne', TextType::class)
            ->add('cin', TextType::class)
            ->add('date_naissance',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('ville_naissance',TextType::class)
            ->add('pays_naissance', TextType::class)
            ->add('sexe', TextType::class)
            ->add('addresse', TextType::class)
            ->add('annee_1ere_inscription_universite',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('annee_1ere_inscription_enseignement_superieur',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('annee_1ere_inscription_universite_marocaine',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('code_bac', TextType::class)
            ->add('serie_bac', TextType::class)
            ->add('filiere', EntityType::class, [
                'class' => Filiere::class
            ])
            ->add('ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class, User::class
        ]);
    }
}
