<?php

namespace App\Entity;

use App\Entity\Jouet;

class JouetBuilder extends MainBuilder{

        
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
     * @param  mixed $id - id du jouet à créer
     * @param  mixed $image - nom de l'image du jouet à créer
     * @return void
     */
    public function createJouet(int $id, $image){
        $data = $this->data;
        if($this->isValid()){
            $jouet = new Jouet($id, $data["jouet_nom"], $_SESSION["user"], $data["jouet_date"], $image);
            return $jouet;
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
        if($data["jouet_nom"] == ""){
            $this->addError("Vous n'avez pas précisé le nom de votre jouet.<br>");
            if($data["jouet_date"] == ""){
                $this->addError("Vous n'avez pas précisé de date d'achat pour votre jouet. <br>");
            }
        }
        if($this->getError() != null){
            return false;
        }else{
            return true;
        }
    }
}