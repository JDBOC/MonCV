<?php

  namespace App\Form;

  use App\Entity\Contact;
  use App\Entity\Experiences;
  use App\Form\AppFormType;

  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\DateType;
  use Symfony\Component\Form\Extension\Core\Type\EmailType;
  use Symfony\Component\Form\Extension\Core\Type\TextareaType;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;

  class ContactType extends AppFormType
  {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
        ->add ('firstname', TextType::class)
      ->add ('lastname', TextType::class)
      ->add ('phone', TextType::class)
      ->add ('email', EmailType::class)
        ->add ('message', TextareaType::class)
      ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
        'data_class' => Contact::class,
      ]);
    }
  }
