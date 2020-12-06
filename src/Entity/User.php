<?php

namespace App\Entity;

use App\Entity\Entity;

class User implements Entity{

    private $id;
    private $nom;
    private $prenom;
    private $username;
    private $password;
    private $role;
    private $jouets;

        
    /**
     * Constructeur
     *
     * @param  mixed $pId - id de l'utilisateur
     * @param  mixed $pNom - nom de l'utilisateur
     * @param  mixed $pPrenom - prénom de l'utilisateur
     * @param  mixed $pUsername - pseudo de l'utilisateur
     * @param  mixed $pPassword - mot de passe de l'utilisateur
     * @param  mixed $pRole - role de l'utilisateur
     * @param  mixed $pJouets - Collection de jouets associés à l'utilisateur
     * @return void
     */
    public function __construct(int $pId, string $pNom, string $pPrenom, string $pUsername, string $pPassword, int $pRole, array $pJouets){
        $this->id = $pId;
        $this->nom = $pNom;
        $this->prenom = $pPrenom;
        $this->username = $pUsername;
        $this->password = $pPassword;
        $this->role = $pRole;
        $this->jouets = $pJouets;
    }

    /**
     * Getter de la propriété id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter de la propriété id
     *
     */ 
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Getter de la propriété nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Setter de la propriété nom
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Getter de la propriété prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Setter de la propriété prenom
     *
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * Getter de la propriété username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Setter de la propriété username
     *
     */ 
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Getter de la propriété password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Setter de la propriété password
     *
     */ 
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Getter de la propriété role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Setter de la propriété role
     *
     */ 
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Getter de la propriété jouets
     */ 
    public function getJouets()
    {
        return $this->jouets;
    }

    /**
     * Setter de la propriété jouets
     *
     */ 
    public function setJouets($jouets)
    {
        $this->jouets = $jouets;
    }
}