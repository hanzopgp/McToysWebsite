<?php

namespace App\Storage;

use \PDO;
use \Exception;
use App\Tool\Interfaces\AppInterface;

class MainStorage{

    protected $database;

    public function __construct(){
        $json = json_decode(file_get_contents(AppInterface::DB_LINK), true);
        try
        {
          $this->database = new PDO('mysql:host='.$json["host"].';dbname='.$json["dbname"].';charset=utf8', $json["username"], $json["password"]);
          $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }

    /**
     * Getter de l'attribu db
     */
    public function getDatabase(){
        return $this->database;
    }

    /**
     * Génère un id pour une table
     */
    public function generateId(string $table){
        $request = "SELECT MAX(id) FROM $table";
        $tmp = $this->getDatabase()->prepare($request);
        if ($tmp->execute()) {
            $response = $tmp->fetch();
        }

        return (int)$response[0];
    }
}