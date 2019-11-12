<?php

  namespace App\Form;

  use App\Entity\Portfolio;
  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\CollectionType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;

  class PortfolioType extends AbstractType
  {
    public function buildForm(FormBuilderInterface $builder , array $options)
    {
      $builder
        ->add ( 'titre' )
        ->add ( 'description' )
        ->add ( 'techs' )
        ->add ( 'images' , CollectionType::class , [
          'entry_type' => ImagesType::class,
          'allow_add' => true
        ] );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults ( [
        'data_class' => Portfolio::class ,
      ] );
    }
  }
