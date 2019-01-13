<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                'attr' => array('class' => 'large-12 columns')))
            ->add('lastname', TextType::class, array(
                'attr' => array('class' => 'large-12 columns')))
            ->add('email', EmailType::class, array(
        'attr' => array('class' => 'large-12 columns')))
            ->add('pwd', PasswordType::class, array(
                'attr' => array('class' => 'large-12 columns')))
            ->add('address', TextType::class, array(
                'attr' => array('class' => 'large-12 columns')))
            ->add('city', TextType::class, array(
                'attr' => array('class' => 'large-12 columns')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
