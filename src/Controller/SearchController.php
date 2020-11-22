<?php

namespace App\Controller;

use App\Router;
use App\View\View;
use App\View\JouetView;
use App\Storage\JouetStorage;

class SearchController extends MainController{

    public function __construct(Router $router, View $view = null){
        if($view !=null){
            parent::__construct($router, $view);
        }else{
            parent::__construct($router);
        }
    }
    
    /**
     * Recherche les jouets correspondant à la demande et redirige l'utilisateur vers le résultat
     */
    public function searchJouet(array $data){
        $storage = new JouetStorage();
        $_SESSION["feedback"] = $storage->search($data["rechercher"]);
        header("Location: jouet/recherche");
    }

    /**
     * Affiche la liste des résultats envoyés en session
     */
    public function makeSearchResultPage(){
        if(isset($_SESSION["feedback"])){
            $jouetView = new JouetView($this->router);
            $jouetView->showListePage($_SESSION["feedback"], "Résultat de votre recherche :");
        }else{
            $this->view->showErrorPage(AppInterface::ERR_404);
        }
    }
}