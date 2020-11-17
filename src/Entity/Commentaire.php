<?php

namespace App\Entity;

use App\Entity\User;

  class Commentaire{

    private $id;
    private $jouet;
    private $auteur;
    private $message;
    private $date;

    function __construct(int $id, string $message, string $date, User $auteur, int $jouet){
      $this->jouet = $jouet;
      $this->auteur = $auteur;
      $this->message = $message;
      $this->date = $date;
      $this->id = $id;
    }

    public function getId(){
      return $this->id;
    }

    public function getAuteur(){
      return $this->auteur;
    }

    public function getJouet(){
      return $this->jouet;
    }

    public function getMessage(){
      return $this->message;
    }

    public function getDate(){
        return $this->date;
    }
  }
 ?>
