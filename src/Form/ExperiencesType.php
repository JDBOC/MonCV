<?php

namespace App\Form;

use App\Entity\Experiences;
use App\Form\AppFormType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExperiencesType extends AppFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', TextType::class, $this->getConfig ("", "société"))
            ->add('title', TextType::class, $this->getConfig ("", "poste occupé"))
            ->add('entree', DateType::class, $this->getConfig ("date d'entrée", "", ['widget' => 'single_text']))
            ->add('sortie', DateType::class, $this->getConfig ("date de fin", "", ['widget' => 'single_text', 'required' => false] ))
            ->add('descriptif', CKEditorType::class, $this->getConfig ("descriptif", "indiquez un résumé pour ce job "))
            ->add('lieu', TextType::class, $this->getConfig ("", "indiquez un lieu"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Experiences::class,
        ]);
    }
}
