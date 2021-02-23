<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code_apogee')
            ->add('nom')
            ->add('prenom')
            ->add('cne')
            ->add('cin')
            ->add('date_naissance')
            ->add('ville_naissance')
            ->add('pays_naissance')
            ->add('sexe')
            ->add('addresse')
            ->add('annee_1ere_inscription_universite')
            ->add('annee_1ere_inscription_enseignement_superieur')
            ->add('annee_1ere_inscription_universite_marocaine')
            ->add('code_bac')
            ->add('serie_bac')
            ->add('filiere')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
