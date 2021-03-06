<?php

namespace App\Storage;

use PDO;
use App\Entity\Jouet;
use App\Entity\Entity;
use App\Storage\MainStorage;
use App\Storage\UserStorage;
use App\Storage\StorageInterface;

class JouetStorage extends MainStorage implements StorageInterface{
    
    /**
     * Constructeur
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    
    /**
     * Avoir un jouet de la base de données en fonction de son id
     *
     * @param  mixed $id - id du jouet à récupérer
     * @return void
     */
    public function getById(int $id){
        $stmt = $this->getDatabase()->prepare("SELECT * FROM jouet WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $answer = $stmt->fetch(PDO::FETCH_ASSOC);
        $userStorage = new UserStorage();
        return new Jouet($answer["id"], $answer["nom"], $userStorage->getById($answer["user"]), $answer["date"], $answer["image"]);
    }

    
    /**
     * Tester si un jouet existe dans la base de données
     *
     * @param  mixed $id - id du jouet à vérifier
     * @return void
     */
    public function checkIfExist(int $id){
        $stmt = $this->getDatabase()->prepare("SELECT COUNT(id) FROM jouet WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $answer = $stmt->fetch(PDO::FETCH_ASSOC);
        if($answer["COUNT(id)"] == '1'){
            return true;
        }else{
            return false;
        }
    }

    
    /**
     * Avoir la liste de tout les jouets de la base de données
     *
     * @return void
     */
    public function fetchAll(){
        $stmt = $this->getDatabase()->prepare("SELECT * FROM jouet");
        $stmt->execute();
        $answer = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = array();
        $storage = new UserStorage();
        foreach($answer as $data){
            $newJouet = new Jouet($data["id"], $data["nom"], $storage->getById(intval($data["user"])), $data["date"], $data["image"]);
            array_push($list, $newJouet);
        }
        return $list;
    }

    
    /**
     * Avoir tout les jouets dont le nom ressemble à $name
     *
     * @param  mixed $name - nom à rechercher
     * @return void
     */
    public function search(string $name){
        $stmt = $this->getDatabase()->prepare("SELECT * FROM jouet WHERE nom LIKE ?");
        $stmt->bindParam(1, $search);
        $search = "%".$name."%";
        $stmt->execute();
        $answer = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = array();
        $storage = new UserStorage();
        foreach($answer as $data){
            $newJouet = new Jouet($data["id"], $data["nom"], $storage->getById(intval($data["user"])), $data["date"], $data["image"]);
            array_push($list, $newJouet);
        }
        return $list;
    }

    
    
    /**
     * Ajouter un jouet à la base de données
     *
     * @param  mixed $jouet
     * @return void
     */
    public function flush(Entity $jouet){
        $stmt = $this->getDatabase()->prepare("INSERT INTO jouet (id, nom, image, user, date) VALUES (null, ?, ?, ?, ?)");
        $stmt->bindParam(1, $nom);
        $stmt->bindParam(2, $image);
        $stmt->bindParam(3, $id_user);
        $stmt->bindParam(4, $date);
        $nom = $jouet->getNom();
        $id_user = $jouet->getUser()->getId();
        $image = $jouet->getImage();
        $date = $jouet->getDate();
        $stmt->execute();
    }

    
    /**
     * Modifier un jouet dans la base de données
     *
     * @param  mixed $jouet - jouet à modifier
     * @param  mixed $data - data du jouet modifié
     * @return void
     */
    public function update(Entity $jouet, array $data){
        $id = $jouet->getId();
        $newName = $data["jouet_nom"];
        $newDate = $data["jouet_date"];
        $newImage = $jouet->getImage();
        if($jouet instanceof Jouet){
            $stmt = $this->getDatabase()->prepare("UPDATE jouet SET nom = ?, 
                                                                    image = ?, 
                                                                    date = ?  WHERE id = ?");
            $stmt->bindParam(1, $newName);
            $stmt->bindParam(2, $newImage);
            $stmt->bindParam(3, $newDate);
            $stmt->bindParam(4, $id);
            $stmt->execute();
        }
    }

    
    /**
     * Supprimer un jouet de la base de données
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id){
        $stmt = $this->getDatabase()->prepare("DELETE FROM jouet WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }
    
    
    /**
     * Avoir tout les jouets associés à un utilisateur
     *
     * @param  mixed $idUser - id de l'utilisateur ciblé
     * @return void
     */
    public function getAllJouetsByUser(int $idUser){
        $stmt = $this->getDatabase()->prepare("SELECT * FROM jouet WHERE user = ?");
        $stmt->bindParam(1, $idUser);
        $stmt->execute();
        $answer = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $jouets = array();
        $userStorage = new UserStorage();
        foreach($answer as $result){
            if(isset($_SESSION["user"]) && $_SESSION["user"]->getId() == intval($result["user"])){
                array_push($jouets, new Jouet(intval($result["id"]), $result["nom"], $_SESSION["user"], $result["date"], $result["image"]));
            }else{
                array_push($jouets, new Jouet(intval($result["id"]), $result["nom"], $userStorage->getById($result["user"]), $result["date"], $result["image"]));
            }
            
        }
        return $jouets;
    }
}