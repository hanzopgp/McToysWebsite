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
        if(strlen($data["nom"]) > 0){
            if(strlen($data["prenom"]) > 0){
                if(strlen($data["identifiant"]) > 0){
                    if(strlen($data["mdp"]) > 0){
                        if(strlen($data["confirm_mdp"]) > 0){
                            if($data["mdp"] == $data["confirm_mdp"]){
                                return true;
                            }else{
                                $this->error .= "Les deux mots de passes ne sont pas identiques !<br>";
                            }
                        }else{
                            $this->error.= "Le mot de passe doit être supérieur ou égal à 2 caractères !<br>";
                        }
                    }else{
                        $this->error.= "Le mot de passe doit être supérieur ou égal à 2 caractères !<br>";
                    }
                }else{
                    $this->error.= "L'identifiant doit être supérieur ou égal à 2 caractères !<br>";
                }
            }else{
                $this->error.= "Le prénom doit être supérieur ou égal à 2 caractères !<br>";
            }
        }else{
            $this->error.= "Le nom doit être supérieur ou égal à 2 caractères !<br>";
        }
        return false;
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
}