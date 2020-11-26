<?php

namespace App\Form;

use App\Entity\Candidat;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('imageFile',FileType::class,['label'=>'Chosir l\'image'])
            ->add('content')
            ->add('createAt')
            ->add('posted')
            ->add('updatedAt')
            ->add('category')
            ->add('user',EntityType::class,[
                'label' =>false,
                'choice_label'  =>'username',
                'class'        =>User::class
            ])
            ->add('candidat',EntityType::class,[
                'label'=>false,
                'choice_label'  =>'nom',
                'class'        =>Candidat::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
    
}
