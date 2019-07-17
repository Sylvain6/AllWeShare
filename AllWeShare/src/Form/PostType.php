<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\GroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PostType extends AbstractType
{
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'attr' => ['class' => 'form-control',
                'onkeyup' => 'reportToGroup(this.value)', 'value' => '']
            ))
            ->add('description', TextareaType::class, array(
                'attr' => ['class' => 'form-control', 'value' => ''],
                'label_attr' => ['class' => 'modal-label']
            ))
            ->add('organization', GroupType::class, array('label_attr' => ['class' => 'organization_title']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'groups' => null,
        ]);
    }
}
