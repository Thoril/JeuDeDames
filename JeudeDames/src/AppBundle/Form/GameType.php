<?php
/**
 * Created by PhpStorm.
 * User: Marion
 * Date: 29/05/2018
 * Time: 16:29
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option){

        $builder->add('name', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Game'
        ]);
    }

}