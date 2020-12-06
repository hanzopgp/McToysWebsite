<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Entity;

  class Commentaire implements Entity{

    private $id;
    private $jouet;
    private $auteur;
    private $message;
    private $date;

        
    /**
     * Constructeur
     *
     * @param  mixed $id - id du commentaire
     * @param  mixed $message - message contenu dans le commentaire
     * @param  mixed $date - date du commentaire
     * @param  mixed $auteur - auteur du commentaire
     * @param  mixed $jouet - jouet associé au commentaire
     * @return void
     */
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
