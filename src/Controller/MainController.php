<?php

namespace App\Controller;

use App\View\View;
Use App\Router;

class MainController{

    protected $view;
    protected $user;
    protected $router;
    
    
    /**
     * __construct
     *
     * @param  mixed $router - router utile à la vue
     * @param  mixed $view - Vue du controleur
     * @return void
     */
    public function __construct(Router $router, View $view = null){
        $this->router = $router;
        if($view != null){
            $this->view = $view;
        }else{
            $this->view = new View($router);
        }
    }

        
    /**
     * Construit un message d'erreur
     *
     * @param  mixed $message - message à afficher
     * @param  mixed $logo - Logo optionnel à afficher
     * @return void
     */
    public function makeErrorPage(string $message, string $logo=null){
        if($logo != null){
            $this->view->showErrorPage($message, $logo);
        }else{
            $this->view->showErrorPage($message);
        }
        
    }
    
    /**
     * Construit la page "a propos"
     *
     * @return void
     */
    public function makeAboutPage(){
        $this->view->makeAboutPage();
    }

        
    /**
     * Retourne l'utilisateur actuellement connecté, si il existe
     *
     * @return void
     */
    public function getUser(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }else{
            return null;
        }
    }
}
