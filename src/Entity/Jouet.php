<?php

namespace App\Entity;

use App\Entity\User;

  class Jouet{

    private $id;
    private $nom;
    private $user;
    private $image;
    private $date;

    function __construct(int $id, string $nom, User $user, string $date, string $image = null){
      $this->nom = $nom;
      $this->user = $user;
      $this->image = $image;
      $this->date = $date;
      $this->id = $id;
    }

    public function getId(){
      return $this->id;
    }

    public function getNom(){
      return $this->nom;
    }

    public function getUser(){
      return $this->user;
    }

    public function getImage(){
      return $this->image;
    }

    public function getDate(){
        return $this->date;
    }
  }
 ?>
