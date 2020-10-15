<?php

namespace App\Form;

use App\Entity\Votant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VotantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('adresse')
            ->add('telephone')
            ->add('motdepass',PasswordType::class,['label'=>'Mot de passe'])
            //->add('photoName')
            ->add('category',ChoiceType::class,[
                'label'     =>'Categorie',
                'multiple'  =>false,
                'required'  => false,
                'choices'=>$this->getChoices()

                
            ])
            ->add('sexe')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Votant::class,
        ]);
    }
      private function getChoices()
    {
        
        $final_choces = ['VotantNormal'=>'Vontant simple'];
       
        return $final_choces;
    }
}
