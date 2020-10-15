<?php

namespace App\Form;

use App\Entity\Search\ThemeSearch;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ThemeSearchType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',EntityType::class,[
                'label'     =>false,
                'multiple'  =>false,
                'required'  => false,
                'class'     => Theme::class,
                'choice_label'=>'titre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ThemeSearch::class,
            'methods'   =>'GET',
        ]);
    }
    public function getBlockPrefix()
    {
        return false;
    }

}
