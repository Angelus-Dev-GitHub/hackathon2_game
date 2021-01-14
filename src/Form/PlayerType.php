<?php

namespace App\Form;

use App\Entity\Picture;
use App\Entity\Player;
use App\Repository\PictureRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('picture', EntityType::class, [
                'class' => Picture::class,
                'query_builder' => function (PictureRepository $pictureRepository) {
                return $pictureRepository->createQueryBuilder('p')
                    ->where( 'p.player is NULL');
                },
                'choice_label' => 'name',
                'label' => 'Choisir un avatar',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
