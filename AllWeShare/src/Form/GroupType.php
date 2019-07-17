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
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'modal-label']
            ))
            ->add('place', NumberType::class, array(
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'modal-label']
            ))
            ->add('username', EmailType::class, array(
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'modal-label']
            ))
            ->add('password', PasswordType::class, array(
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'modal-label']
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
