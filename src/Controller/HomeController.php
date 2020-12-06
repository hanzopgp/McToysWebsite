<?php

namespace App\Controller;

use App\Router;

class HomeController extends MainController{

        
    /**
     * __construct
     *
     * @param  Router $router - routeur
     * @return void
     */
    public function __construct(Router $router){
        parent::__construct($router);
    }
    
    /**
     * construit la vue de la page d'accueil
     *
     * @return void
     */
    public function makeHomePage(){
        $this->view->makeHomePage();
    }
}