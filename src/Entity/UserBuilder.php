<?php

namespace App\Entity;

class UserBuilder{

    private $data;
    private $error;

    public function __construct(array $data = null){
        if($data != null){
            $this->data = $data;
        }

    }

    public function createUser(int $id){
        if($this->isValid()){
            $data = $this->data;
            $user = new User($id, $data["nom"], $data["prenom"], $data["identifiant"], $data["mdp"], 0, array());
            return $user;
        }else{
            return $this->data;
        }
    }

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


    public function getData(){
        return $this->data;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function getError(){
        return $this->error;
    }

    public function setError($error){
        $this->error = $error;
    }

    public function addError(string $error){
        $this->error .= $error;
    }
}