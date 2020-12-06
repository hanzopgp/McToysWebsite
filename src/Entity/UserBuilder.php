<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\MainBuilder;

class UserBuilder extends MainBuilder{

    /**
     * Constructeur
     *
     * @param  mixed $data - data du builder
     * @return void
     */
    public function __construct(array $data = null){
        if($data != null){
            parent::__construct($data);
        }
    }

        
    /**
     * On crée un objet de type jouet en vérifiant si on a bien toute les valeurs.
     *
     * @param  mixed $id - id de l'utilisateur à créer
     * @return void
     */
    public function createUser(int $id){
        if($this->isValid()){
            $data = $this->data;
            $user = new User($id, $data["nom"], $data["prenom"], $data["identifiant"], $data["mdp"], 0, array());
            return $user;
        }else{
            return $this->data;
        }
    }

        
    /**
     * on vérifie les valeurs
     *
     * @return void
     */
    public function isValid(){
        $data = $this->data;
        if(strlen($data["nom"]) < 2){
            $this->addError("Le nom doit être supérieur ou égal à 2 caractères !<br>");
            if(strlen($data["prenom"]) < 2){
                $this->addError("Le prénom doit être supérieur ou égal à 2 caractères !<br>");
                if(strlen($data["identifiant"]) < 2){
                    $this->addError("L'identifiant doit être supérieur ou égal à 2 caractères !<br>");
                    if(strlen($data["mdp"]) < 2){
                        $this->addError("Le mot de passe doit être supérieur ou égal à 2 caractères !<br>");
                        if(strlen($data["confirm_mdp"]) < 2){
                            $this->addError("Le mot de passe doit être supérieur ou égal à 2 caractères !<br>");
                            if($data["mdp"] != $data["confirm_mdp"]){
                                $this->addError("Les deux mots de passes ne sont pas identiques !<br>");
                            }
                        }
                    }
                }
            }
        }
        if($this->error != null){
            return false;
        }else{
            return true;
        }
    }
}