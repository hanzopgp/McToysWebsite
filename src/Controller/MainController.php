<?php

namespace App\Controller;

use App\View\View;
Use App\Router;

class MainController{

    protected $view;
    protected $user;
    protected $router;
    

    public function __construct(Router $router, View $view = null){
        $this->router = $router;
        if($view != null){
            $this->view = $view;
        }else{
            $this->view = new View($router);
        }
    }

    public function makeErrorPage(string $message, string $logo=null){
        if($logo != null){
            $this->view->showErrorPage($message, $logo);
        }else{
            $this->view->showErrorPage($message);
        }
        
    }

    public function makeAboutPage(){
        $this->view->makeAboutPage();
    }

    public function getUser(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }else{
            return null;
        }
    }
}
