<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Entity;

  class Jouet implements Entity{

    private $id;
    private $nom;
    private $user;
    private $image;
    private $date;
    
    /**
     * Constructeur
     *
     * @param  mixed $id - id du jouet
     * @param  mixed $nom - nom du jouet
     * @param  mixed $user - utilisateur associé au jouet
     * @param  mixed $date - date d'achat du jouet
     * @param  mixed $image - image du jouet
     * @return void
     */
    function __construct(int $id, string $nom, User $user, string $date, string $image = null){
      $this->nom = $nom;
      $this->user = $user;
      $this->image = $image;
      $this->date = $date;
      $this->id = $id;
    }

    

    /**
     * Getter de id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter de id
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Getter de nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Setter de nom
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Getter de user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Setter de user
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Getter de image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Setter de image
     */ 
    public function setImage(string $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Getter de date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Setter de date
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
  }
 ?>
