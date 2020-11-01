<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('postnom')
            ->add('prenom')
            ->add('adresse')
            ->add('email')
            ->add('origine')
            ->add('telephone')
            ->add('imageFile', FileType::class, [
                'label'     => 'Choisir l\'image',
                'required'  => false
            ])
            ->add('motdepasse')
            ->add('sexe')
            ->add('dateNaissance')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
