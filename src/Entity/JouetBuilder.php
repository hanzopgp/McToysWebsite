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
        public function createJouet(int $id, $image=null){
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
            $error = "";
            $boolean = true;
            if($data["jouet_nom"]==null){
                $error .= "Il y a une erreur, il n'y a pas de nom. <br>";
                $boolean = false;
            }
            if($data["jouet_date"]==null){
                $error .= "Il y a une erreur, il n'y a pas de date.";
                $boolean = false;
            }

            $this->setError($error);
            return $boolean;
        }
    }