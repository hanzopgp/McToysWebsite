<?php

namespace App\Storage;

use PDO;
use App\Entity\Entity;
use App\Entity\Commentaire;
use App\Storage\MainStorage;
use App\Storage\UserStorage;
use App\Storage\StorageInterface;

class CommentaireStorage extends MainStorage implements StorageInterface{
    
        
    /**
     * Constructeur
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    
    /**
     * Avoir un commentaire en fonction de son id
     *
     * @param  mixed $id - id du commentaire à récupérer
     * @return void
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
     *
     * @param  mixed $commentaire - Commentaire à ajouter
     * @return void
     */
    public function flush(Entity $commentaire){
        $message = $commentaire->getMessage();
        $date = $commentaire->getDate();
        $auteur = $commentaire->getAuteur()->getId();
        $jouet = $commentaire->getJouet();
        $stmt = $this->getDatabase()->prepare("INSERT INTO commentaire (id, message, date, auteur, jouet) VALUES (null, ?, ?, ?, ?)");
        $stmt->bindParam(1, $message);
        $stmt->bindParam(2, $date);
        $stmt->bindParam(3, $auteur);
        $stmt->bindParam(4, $jouet);
        $stmt->execute();
    }

    public function update(Entity $commentaire, array $data){
    }

    
    /**
     * Avoir tout les commentaires associés à un jouet
     *
     * @param  mixed $jouetId - id du jouet à cibler
     * @return void
     */
    public function getAllCommentairesByJouet(int $jouetId){
        $jouetStorage = new JouetStorage();
        $jouet = $jouetStorage->getById($jouetId);
        $stmt = $this->getDatabase()->prepare("SELECT * FROM commentaire WHERE jouet = ? ORDER BY date DESC");
        $stmt->bindParam(1, $jouetId);
        $stmt->execute();
        $answer = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $commentaire = array();
        $userStorage = new UserStorage();
        foreach($answer as $result){
            array_push($commentaire, new Commentaire($result["id"], $result["message"], $result["date"], $userStorage->getById(intval($result["auteur"])), $result["jouet"]));
        }
        return $commentaire;
    }

    public function delete($id){
    }

    public function deleteByIdJouet(int $idJouet){
        $stmt = $this->getDatabase()->prepare("DELETE FROM commentaire WHERE jouet = ?");
        $stmt->bindParam(1, $idJouet);
        $stmt->execute();
    }
    
    public function generate($data){

    }

}