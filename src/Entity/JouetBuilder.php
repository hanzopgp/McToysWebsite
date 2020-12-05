<?php

namespace App\Entity;


    class JouetBuilder{

        private $data;
        private $error;

        function __construct($data, $error=null){
            $this->data = $data;
            $this->error = $error;
        }

        public function getData(){
            return $this->data;
        }

        public function getError(){
            return $this->error;
        }

        public function setError($error){
            $this->error=$error;
        }

        //On crée un objet de type jouet en vérifiant si on a bien toute les valeurs.
        public function createJouet(int $id, $image){
            $data = $this->data;
            if($this->isValid()){
                $jouet = new Jouet($id, $data["jouet_nom"], $_SESSION["user"], $data["jouet_date"], $image);
                return $jouet;
            }else{
                return $data;
            }
        }

        //On vérifie les valeurs 
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

        public function addError(string $error){
            $this->error.= $error;
        }
    }