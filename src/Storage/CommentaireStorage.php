<?php

namespace App\Storage;

use App\Entity\Commentaire;
use PDO;
use App\Storage\MainStorage;
use App\Storage\UserStorage;
use App\Storage\StorageInterface;

class CommentaireStorage extends MainStorage implements StorageInterface{
    
    public function __construct(){
        parent::__construct();
    }

    /**
     * Avoir un commentaire en fonction de son id
     */
    public function getById(int $id){
        $stmt = $this->getDatabase()->prepare("SELECT * FROM commentaire WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $answer = $stmt->fetch(PDO::FETCH_ASSOC);
        $userStorage = new UserStorage();
        $jouetStorage = new JouetStorage();
        return new Commentaire($answer["id"], $answer["commentaire"], $answer["date"],$userStorage->getById($answer["user"]), $jouetStorage->getJouetById($answer["jouet"])->getId());
    }

    public function fetchAll(){
    }

    /**
     * Ajouter un commentaire à la base de données
     */
    public function flush($commentaire){
        if($commentaire instanceof Commentaire){
            $stmt = $this->getDatabase()->prepare("INSERT INTO commentaire (id, message, date, auteur, jouet) VALUES (null, ?, ?, ?, ?)");
            $stmt->bindParam(1, $message);
            $stmt->bindParam(2, $date);
            $stmt->bindParam(3, $auteur);
            $stmt->bindParam(4, $jouet);
            $message = $commentaire->getMessage();
            $auteur = $commentaire->getAuteur()->getId();
            $jouet = $commentaire->getJouet();
            $date = $commentaire->getDate();
            $stmt->execute();
        }
    }

    public function update($commentaire, $data){
    }

    /**
     * Avoir tout les commentaires associés à un jouet
     */
    public function getAllCommentairesByJouet(int $jouetId){
        $jouetStorage = new JouetStorage();
        $jouet = $jouetStorage->getById($jouetId);
        $stmt = $this->getDatabase()->prepare("SELECT * FROM commentaire WHERE jouet = ? ORDER BY date DESC");
        $stmt->bindParam(1, $jouetId);
        $stmt->execute();
        $answer = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $commentaire = array();
        foreach($answer as $result){
            array_push($commentaire, new Commentaire($result["id"], $result["message"], $result["date"], $jouet->getUser(), $result["jouet"]));
        }
        return $commentaire;
    }

    public function delete($id){
    }
    
    public function generate($data){

    }

}