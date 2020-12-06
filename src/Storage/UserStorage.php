<?php

namespace App\Storage;

use PDO;
use App\Entity\User;
use App\Entity\Entity;
use App\Entity\UserBuilder;
use App\Storage\MainStorage;
use App\Storage\StorageInterface;

class UserStorage extends MainStorage implements StorageInterface{
    
    /**
     * Constructeur
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    
    /**
     * Avoir un utilisateur en fonction de son id
     *
     * @param  mixed $id - id de l'utilisateur à récupérer
     * @return void
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
     *
     * @param  mixed $user - Utilisateur à ajouter
     * @return void
     */
    public function flush(Entity $user){
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

    
    /**
     * Avoir un utilisateur en fonction de son identifiant et de son mdp
     *
     * @param  mixed $login - login envoyé par le formulaire
     * @param  mixed $mdp - mot de passe envoyé par le formulaire
     * @return void
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
     *
     * @param  mixed $login - pseudo à vérifier
     * @return void
     */
    public function checkUserExists(string $login){
        $stmt = $this->getDatabase()->prepare("SELECT COUNT(id) FROM user WHERE username = ?");
        $stmt->bindParam(1, $login);
        if ($stmt->execute()) {
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return (int)$response["COUNT(id)"];
    }


    public function update(Entity $user, array $data){

    }

    public function delete($user){

    }

    public function generate($data){

    }

}