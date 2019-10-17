<?php

namespace App\Form;

use App\Entity\Competences;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetencesType extends AppFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, $this->getConfig ("Compétence", "indiquez une nouvelle compétence"))
            ->add('picture', TextType::class, $this ->getConfig ("Logo", "indiquez l'URL de l'image"))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Competences::class,
        ]);
    }
}
