<?php

namespace App\Entity;


    class CommentaireBuilder{

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

        public function createCommentaire(int $id){
            $data = $this->data;
            if($this->isValid()){
                $commentaire = new Commentaire($id, $data["commentaire"], date("Y-m-d H:i:s"), $_SESSION["user"], $data["id"]);
                return $commentaire;
            }else{
                return $data;
            }
        }

        //On vérifie les valeurs 
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