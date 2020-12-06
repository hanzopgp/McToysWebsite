<?php

namespace App\Entity;

use App\Entity\Commentaire;
use App\Entity\MainBuilder;


class CommentaireBuilder extends MainBuilder{

    /**
     * Constructeur
     *
     * @param  mixed $data - data du builder
     * @return void
     */
    public function __construct(array $data = null){
        if($data != null){
            $this->data = $data;
        }
    }

        
    /**
     * on construit un objet Commentaire si la validation est passée
     *
     * @param  mixed $id - id du commentaire
     * @return void
     */
    public function createCommentaire(int $id){
        $data = $this->data;
        if($this->isValid()){
            $commentaire = new Commentaire($id, $data["commentaire"], date("Y-m-d H:i:s"), $_SESSION["user"], $data["id"]);
            return $commentaire;
        }else{
            return $data;
        }
    }

        
    /**
     * On vérifie les valeurs 
     *
     * @return void
     */
    public function isValid(){
        $data = $this -> getData();
        $error = "";
        $boolean = true;
        if($data["commentaire"]==null){
            $error .= "Il y a une erreur, il n'y a pas de commentaire. <br>";
            $boolean = false;
        }
        $this->setError($error);
        return $boolean;
    }
}