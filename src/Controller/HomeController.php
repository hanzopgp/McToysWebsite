<?php

namespace App\Controller;

use App\Router;

class HomeController extends MainController{

    public function __construct(Router $router){
        parent::__construct($router);
    }

    public function makeHomePage(){
        $this->view->makeHomePage();
    }
}