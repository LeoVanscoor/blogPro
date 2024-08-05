<?php

namespace App\Form;

use App\Entity\BlogPost;
use App\Entity\Commentaire;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu')
            //->add('dateCreation', null, [
            //    'widget' => 'single_text',
            //])
            //->add('blogpost', EntityType::class, [
            //    'class' => BlogPost::class,
            //    'choice_label' => 'id',
            //])
            //->add('author', EntityType::class, [
            //    'class' => User::class,
            //    'choice_label' => 'id',
            //])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
