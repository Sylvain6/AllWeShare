<?php
/**
 * Created by PhpStorm.
 * User: antoine
 * Date: 21/04/2019
 * Time: 14:28
 */

namespace App\Form;

use App\Entity\ProfilePicture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfilPictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('picture', FileType::class, array(
                'attr' => ['class' => 'inputfile', 'id' => 'file']
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfilePicture::class,
        ]);
    }
}

