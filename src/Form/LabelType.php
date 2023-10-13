<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LabelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label'=>"Nom de l'artiste",
                'attr'=>[
                    "placeholder"=>"Saisir le nom de l'artiste"
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr'=>[
                    "placeholder"=>"Saisir la description de l'artiste"
                ]
            ])
            ->add('annee', IntegerType::class, [
                'attr'=>[
                    "placeholder"=>"Saisir le lien du site web de l'artiste"
                ]
            ])
            ->add('logo', TextType::class, [
                'attr'=>[
                    "placeholder"=>"Saisir le chemin du logo"
                ]
            ])
            ->add('type', ChoiceType::class, [
                "choices"=>[
                    "Majeur"=>0,
                    "Indépendant"=>1
                ]
            ])
            ->add('albums', EntityType::class, [
                'class' => Album::class,
                'choice_label'=>'nom',
                'label' => "Album(s) associées",
                'required'=>false,
                'multiple' => true,
                // 'expanded' => true,
                'by_reference'=>false,
                'attr'=>[
                    'class'=>"selectStyles",
                ]
            ])
            //->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Label::class,
        ]);
    }
}
