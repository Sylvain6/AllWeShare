<?php

namespace App\Form;

use App\Entity\Report;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class,
                [   'choices' => [
                    'Injurious Remarks' => 'Injurious Remarks',
                    'Post/Comment Inappropriate' => 'Post/Comment Inappropriate',
                    'Undesirable Content' => 'Undesirable Content',
                    'Other Things' => 'Other Things'
                    ],
                    'attr' => ['class' => 'custom-select'],
                ])
            ->add('description', TextareaType::class,
                ['attr' => ['class' =>'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' => Report::class,
        ]);
    }
}
