<?php

namespace App\Controller;

use App\Router;
use App\View\View;
use App\Entity\User;
use App\Entity\UserBuilder;
use App\Storage\UserStorage;
use App\Storage\JouetStorage;
use App\Tool\Interfaces\AppInterface;

class SecurityController extends MainController{

    public function __construct(Router $router, View $view = null){
        if($view !=null){
            parent::__construct($router, $view);
        }else{
            parent::__construct($router);
        }
    }

    /**
     * Connecte un utilisateur et le redirige vers l'accueil ou affiche un message d'erreur
     * si il s'est trompé dans ses identifiants
     */
    public function makeConnectionPage(){
        if(isset($_SESSION['user'])){
            $this->view->showDeconnectionPage();
        }
        if(isset($_POST['identifiant']) && isset($_POST["password"])){
            $storage = new UserStorage();
            //SI storage retourne un utilisateur, alors on est connecté
            if($storage->getUserByCredentials($_POST['identifiant'], $_POST["password"]) instanceof User){
                $_SESSION["user"] = $storage->getUserByCredentials($_POST['identifiant'], $_POST["password"]);
                $jouetStorage = new JouetStorage();
                $_SESSION["user"]->setJouets($jouetStorage->getAllJouetsByUser($_SESSION["user"]->getId()));
                $_SESSION["userGrants"] = AppInterface::ROLE_USER;
                header("Location: ../");

            //SI storage retourne 1, l'utilisateur existe mais le mot de passe n'est pas bon
            }elseif($storage->getUserByCredentials($_POST['identifiant'], $_POST["password"]) == 1){
                $this->view->showConnectionPage(AppInterface::ERR_PSW);

            //SI storage retourne une autre valeur, soit 2, l'utilisateur n'existe pas en base de données.
            }else{
                $this->view->showConnectionPage(AppInterface::ERR_USER);
            }
        }else{
            $this->view->showConnectionPage();
        }
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function deconnectUser(){
        unset($_SESSION['user']);
        $_SESSION["userGrants"] = AppInterface::ROLE_VISITOR;
        $this->view->showConnectionPage();
    }

    /**
     * Inscrit un utilisateur et le redirige vers l'inscription avec un message de validation
     * ou le renvoie sur la page d'inscription avec ses différentes erreurs
     */
    public function makeInscriptionPage(array $data = null){
        if($data != null){
            if(isset($data["identifiant"]) && isset($data["nom"]) && isset($data["prenom"]) && isset($data["mdp"]) && isset($data["confirm_mdp"])){
                $builder = new UserBuilder($data);
                $storage = new UserStorage();
                $id = $storage->generateId("user");
                if($builder->createUser($id) instanceof User){
                    $storage->flush($builder->createUser($id));
                    $_SESSION["successRegistered"] = 1;
                    header("Location: inscription");
                }else{
                    $this->view->showInscriptionPage($builder);
                }
            }
        }else{
            $this->view->showInscriptionPage();
        }
    }

}