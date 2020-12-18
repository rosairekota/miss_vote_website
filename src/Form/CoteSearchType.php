<?php
namespace App\Form;
use App\Service\CoteService;
use App\Entity\Search\CoteSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


/**
 * 
 */
class CoteSearchType extends AbstractType
{
     private $coteService;
    public function __construct(CoteService $coteService){
        $this->coteService=$coteService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cote',ChoiceType::class,[
               'choices' => $this->coteService->findCotes(),
               

                    
                    
               
            ])
            ->add('numberCotes',IntegerType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CoteSearch::class,
        ]);
    }
}