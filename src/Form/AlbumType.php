<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Style;
use App\Entity\Artiste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', FileType::class, [
                'mapped'=>false,
                'required'=>false,
                'label'=>"Pochette de l'album",
                'attr'=>[
                    'accept'=>".jpg, .png"
                ],
                'row_attr'=>[
                    'class'=>"d-none"
                ],
                'constraints'=>[
                    new Image([
                        'maxSize'=>'200k',
                        'maxSizeMessage'=>"La taille maximum de l'image doit être de {{ limit }} ko",
                        'mimeTypes'=>[
                            'image/png',
                            'image/jpeg'
                        ]
                    ])
                ]
            ])
            ->add('image', HiddenType::class)
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
                // 'expanded' => true,
                'by_reference'=>false,
                'attr'=>[
                    'class'=>"selectStyles",
                ]
            ])
            ->add('morceaux', CollectionType::class, [
                'entry_type'=>MorceauType::class,
                'label'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
