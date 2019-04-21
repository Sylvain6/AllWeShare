<?php

namespace App\Form;

use App\Entity\ProfilePicture;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            /*->add('picture', ProfilPictureType::class, array(
                'attr' => ['class' => 'inputfile', 'id' => 'file']
            ))*/
            ->add('pseudo', TextType::class, array(
                'attr' => ['class' => 'form-control']
            ))
            ->add('firstname', TextType::class, array(
                'attr' => ['class' => 'form-control']
            ))
            ->add('lastname', TextType::class, array(
                'attr' => ['class' => 'form-control']
            ))
//            ->add('email', EmailType::class, array(
//                'attr' => ['class' => 'form-control', 'disabled' => 'disabled']
//            ))
            ->add('address', TextType::class, array(
                'attr' => ['class' => 'form-control']
            ))
            ->add('city', TextType::class, array(
                'attr' => ['class' => 'form-control']
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
