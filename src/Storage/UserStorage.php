<?php

namespace App\Storage;

use PDO;
use App\Entity\User;
use App\Entity\UserBuilder;
use App\Storage\MainStorage;
use App\Storage\StorageInterface;

class UserStorage extends MainStorage implements StorageInterface{
    
    public function __construct(){
        parent::__construct();
    }

    /**
     * Avoir un utilisateur en fonction de son id
     */
    public function getById(int $id){
        $stmt = $this->getDatabase()->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $answer = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = new User($answer["id"], $answer["nom"], $answer["prenom"], $answer["username"], $answer["mdp"], $answer["role"], array());
        return $user;
    }

    public function fetchAll(){    
    }

    /**
     * Ajoute un utilisateur à la base de données
     */
    public function flush($user){
        if($user instanceof User){
            $stmt = $this->getDatabase()->prepare("INSERT INTO user (nom, prenom, username, mdp, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $nom);
            $stmt->bindParam(2, $prenom);
            $stmt->bindParam(3, $username);
            $stmt->bindParam(4, $password);
            $stmt->bindParam(5, $role);
            $nom = $user->getNom();
            $prenom = $user->getPrenom();
            $username = $user->getUsername();
            $password = password_hash($user->getPassword(), PASSWORD_BCRYPT);
            $role = $user->getRole();
            $stmt->execute();
        }
    }

    /**
     * Avoir un utilisateur en fonction de son identifiant et de son mdp
     */
    public function getUserByCredentials(string $login, string $mdp){
        //si l'utilisateur existe
        if($this->checkUserExists($login) == 1){
            
            //on recupère le mdp correspondant au login
            $stmt = $this->getDatabase()->prepare("SELECT mdp FROM user WHERE username = ?");
            $stmt->bindParam(1, $login);
            $stmt->execute();
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
            $dbPassword = $response["mdp"];
            //si le mot de passe rentré correspond au mot de passe en base, on récupère l'utilisateur entier
            if(password_verify($mdp, $dbPassword)){
                $stmt = $this->getDatabase()->prepare("SELECT * FROM user WHERE username = ?");
                $stmt->bindParam(1, $login);
                if ($stmt->execute()){
                    $response = $stmt->fetch();
                    $data = array("id"=>$response["id"],
                                  "nom"=>$response["nom"],
                                  "prenom"=>$response["prenom"],
                                  "identifiant"=>$response["username"],
                                  "mdp"=>$response["mdp"],
                                  "confirm_mdp"=>$response["mdp"]);
                    $builder = new UserBuilder($data);
                    $user = $builder->createUser($data["id"]);
                    return $user;
                }
            }else{
                return 1;
            }
        }else{
            return 2;
        }
    }

    /**
     * Tester si un utilisateur existe dans la base de données
     */
    public function checkUserExists(string $login){
        $stmt = $this->getDatabase()->prepare("SELECT COUNT(id) FROM user WHERE username = ?");
        $stmt->bindParam(1, $login);
        if ($stmt->execute()) {
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return (int)$response["COUNT(id)"];
    }


    public function update($user, $data){

    }

    public function delete($user){

    }

    public function generate($data){

    }

}