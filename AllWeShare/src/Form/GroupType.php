<?php

namespace App\Form;

use App\Entity\Group;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => ['class' => 'form-control']
            ))
            ->add( 'place', NumberType::class, array(
                'attr' => ['class' => 'form-control']
            ))
            ->add('username', EmailType::class, array(
                'attr' => ['class' => 'form-control']
            ))
            ->add('password', PasswordType::class,
                array('attr' => ['class' => 'form-control'])
                //, array(['class' => 'form-control'])
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
