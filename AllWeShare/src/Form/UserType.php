<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\IsTrue;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, array(
                'attr' => ['class' => 'form-control']
            ))
            /*->add('lastname', TextType::class, array(
                'attr' => ['class' => 'form-control']
            ))*/
            ->add('email', EmailType::class, array(
                'attr' => ['class' => 'form-control']
            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password', 'attr' => ['class' => 'form-control']),
                'second_options' => array('label' => 'Repeat Password', 'attr' => ['class' => 'form-control']),

            ))
            /*->add('address', TextType::class, array(
                'attr' => ['class' => 'form-control']
            ))
            ->add('city', TextType::class, array(
                'attr' => ['class' => 'form-control']
            ))*/
            ->add('termsAccepted', CheckboxType::class, array(
                'mapped' => false,
                'constraints' => new IsTrue(),
                'attr' => ['class' => 'form-check-input m-ipt'],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
