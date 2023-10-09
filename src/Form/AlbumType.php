<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Style;
use App\Entity\Artiste;
use App\Repository\StyleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', TextType::class, [
                'attr'=>[
                    "placeholder"=>"Saisir le chemin de l'image"
                ]
            ])
            ->add('nom', TextType::class, [
                'label'=>"Nom de l'album",
                'required'=>false,
                'attr'=>[
                    "placeholder"=>"Saisir le nom de l'album"
                ]
            ])
            ->add('date', IntegerType::class, [
                'label'=>"Année de l'album",
                'required'=>false,
                'attr'=>[
                    "placeholder"=>"Saisir l'année de sortie de l'album"
                ]
            ])
            ->add('artiste', EntityType::class, [
                'class' => Artiste::class,
                'choice_label'=>'nom',
                'label' => "Nom de l'artiste",
                'required'=>false
            ])
            ->add('styles', EntityType::class, [
                'class' => Style::class,
                'choice_label'=>'nom',
                'label' => "Style(s)",
                'required'=>false,
                'multiple' => true,
                'expanded' => true,
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
            'data_class' => Album::class,
        ]);
    }
}
