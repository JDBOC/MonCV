<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AppFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, $this->getConfig ("Nom", "Indiquez ici votre nom"))
            ->add('firstname', TextType::class, $this->getConfig ("Prénom", "Indiquez ici votre prénom"))

            ->add('title', TextType::class, $this->getConfig ("Titre", "indiquez ici votre poste"))

            ->add('hash', PasswordType::class, $this->getConfig ("Mot de passe", "Indiquez votre mot de passe"))
          ->add ('confirmPassword', PasswordType::class, $this->getConfig ("Confirmation", "Veuillez confirmer votre mot de passe"))
            ->add('email', EmailType::class, $this->getConfig ("Email", "Votre adresse email"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
