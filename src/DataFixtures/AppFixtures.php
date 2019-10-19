<?php

  namespace App\DataFixtures;

  use App\Entity\Role;
  use Faker\Factory;
  use App\Entity\Competences;
  use App\Entity\Coordonates;
  use App\Entity\Experiences;
  use App\Entity\Formations;
  use App\Entity\User;
  use Doctrine\Bundle\FixturesBundle\Fixture;
  use Doctrine\Common\Persistence\ObjectManager;
  use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


  class AppFixtures extends Fixture
  {
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
      $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
      $faker = Factory::create ( 'FR-fr' );


      //GESTION ADMINISTRATEUR
      $adminRole = new Role();
      $adminRole->setTitle ( 'ROLE_ADMIN' );
      $manager->persist ( $adminRole );

      $adminUser = new User();
      $adminUser  ->setFirstname ( 'Jean Daniel' )
                  ->setLastname ( 'Boccara' )
                  ->setEmail ( 'jdboccara@mailo.com' )
                  ->setHash ( $this->encoder->encodePassword ( $adminUser , 'confirmation' ) )
                  ->setPicture ('https://media.licdn.com/dms/image/C5103AQHftIGR4eua3Q/profile-displayphoto-shrink_200_200/0?e=1576713600&v=beta&t=19jki1GOWdSvKZaTPCLoNzaEobbaXTemQPxgkg8D9f0')
                  ->setAge (41)
                  ->setTitle ('Développeur Web')
                  ->addUserRole($adminRole)
                  ;

      $manager->persist ($adminUser);
      //GESTION UTILISATEUR

      $user = new User();

      $hash = $this->encoder->encodePassword ( $user , 'password' );

      $user->setFirstname ( 'Jean Daniel' )
        ->setLastname ( 'Boccara' )
        ->setAge ( '41' )
        ->setTitle ( 'Développeur Web Junior' )
        ->setHash ( $hash )
        ->setEmail ( 'jdboccara@mailo.com' );


      $manager->persist ( $user );




      //COORDONNEES

      $coordonate = new Coordonates();

      $coordonate->setUser ( $user )
        ->setAdresse ( 'Lyon' )
        ->setPhone ( '07 69 733 533' )
        ->setMail ( 'jdboccara@mailo.com' )
        ->setLinkdin ( 'https://www.linkedin.com/in/jdboccara/' )
        ->setGithub ( 'https://github.com/JDBOC' );

      $manager->persist ( $coordonate );

      //FIXTURES EXPERIENCES
      for ($i = 1; $i <= 6; $i++) {
        $experience = new Experiences();

        $startDate = $faker->dateTimeBetween ( '-20 years' );
        $endDate = $faker->dateTimeBetween ( '-2 years' );
        $experience->setCompany ( $faker->company )
          ->setTitle ( $faker->jobTitle )
          ->setEntree ( $startDate )
          ->setSortie ( $endDate )
          ->setDescriptif ( $faker->paragraph )
          ->setUser ( $user )
          ->setLieu ( $faker->city );

        $manager->persist ( $experience );
      }

      //FIXTURES formations
      for ($i = 1; $i <= 6; $i++) {
        $formation = new Formations();

        $formation->setTitle ( $faker->jobTitle )
          ->setYear ( $faker->date ( 'd-m-Y' ) )
          ->setLieu ( $faker->country )
          ->setUser ( $user );
        $manager->persist ( $formation );
      }

      //FIXTURES COMPETENCES


      $competences = ['PHP' , 'Javascript' , 'HTML5' , 'CSS3' , 'Github' , 'Agile'];

        for ($j = 1; $j <= 6; $j++) {
          $value = $faker->randomElement ( $competences );
          $competence = new Competences();
          $competence->setTitre ( $value );
          $competence->setUser ( $user );
          $manager->persist ( $competence );
        }

      $manager->flush ();
    }
  }
