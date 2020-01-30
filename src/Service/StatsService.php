<?php

  namespace App\Service;





  use Doctrine\Persistence\ObjectManager;

  class StatsService {

    private $manager;

    public function __construct(ObjectManager $manager)
    {
      $this->manager = $manager;
    }

    public function getCompetencesCount() {
      return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Competences c')-> getSingleScalarResult();
    }

    public function getExperiencesCount() {
      return $this->manager->createQuery('SELECT COUNT(e) FROM App\Entity\Experiences e')-> getSingleScalarResult();
    }

    public function getFormationsCount() {
      return $this->manager->createQuery('SELECT COUNT(f) FROM App\Entity\Formations f')->getSingleScalarResult();
    }



    public function getStats()
    {
      $competences = $this->getCompetencesCount ();
      $experiences = $this->getExperiencesCount ();
      $formations = $this->getFormationsCount ();


      return compact ('competences', 'experiences', 'formations');
    }


  }