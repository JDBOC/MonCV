<?php

  namespace App\Form;

  use App\Entity\Experiences;
  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\DateType;
  use Symfony\Component\Form\Extension\Core\Type\TextareaType;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;

  class AppFormType extends AbstractType {


    /**
     * config de base d'un champ de formulaire
     * @param $label
     * @param $placeholder
     * @return array
     */
    protected function getConfig($label, $placeholder, $options = []){
      return array_merge_recursive ([
        'label' => $label,
        'attr' => [
          'placeholder' => $placeholder
        ]
      ], $options);
    }
  }