<?php

/**
 * Ce router a été inspiré de ce lien, même s'il a beaucoup évolué depuis.
 * Au final, c'est juste la redirection Apache qui a été réutilisé
 * 
 * Lien : https://www.taniarascia.com/the-simplest-php-router/
 */

namespace App;

use App\View\View;
use App\View\JouetView;
use App\View\SecurityView;
use App\Entity\JouetBuilder;
use App\Controller\HomeController;
use App\Controller\MainController;
use App\Entity\CommentaireBuilder;
use App\Controller\JouetController;
use App\Controller\SearchController;
use App\Tool\Interfaces\AppInterface;
use App\Controller\SecurityController;

class Router{

    private $baseLink;
    private $returnHomeLink;

    public function __construct(){
        if(getenv('BASE_PATH') == null){
            $this->baseLink = AppInterface::PROJECT_BASE;
        }else{
            $this->baseLink = getenv('BASE_PATH');
        }

        if(!isset($_SESSION["userGrants"])){
            $_SESSION["userGrants"] = AppInterface::ROLE_VISITOR;
        }
    }

    public function main(){
        //Par défaut, notre lien est nul.
        $link = "";

        //On déclare le mainController qui sera utile dans la partie GET mais aussi dans la partie POST
        //du routeur
        $mainController = new MainController($this);

        /**
         * Détermine le type de réponse du serveur, soit GET, soit POST lorsque l'on envoie un
         * formulaire POST
         */
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            /**
             * Quand on recoit l'URL "public/jouet/2" par exemple, on va diviser l'url dans
             * un tableau en divisant à chaque fois qu'on rencontre un "/"
             */
            if(isset($_GET["url"])){
                $link = explode("/", $_GET["url"]);
                $this->returnHomeLink = $this->makeReturnHomeLink($link);
                //pour éviter un bug du router, quand on envoit public/jouet/2/ on retire le dernier "/"
                //sinon le routeur l'interprète comme un nouveau paramètre et ne renverra rien en conséquence
                if($link[sizeof($link)-1] == ""){
                    unset($link[sizeof($link)-1]);
                }
            }
        }else{
            // Si on rentre dans cette condition, cela veut dire qu'on a envoyé un formulaire en POST
            if(isset($_POST["form"])){
                if($_POST["form"] == "connexion"){
                    $controller = new SecurityController($this, new SecurityView($this));
                    $controller->makeConnectionPage();
                }

                if($_POST["form"] == "deconnexion"){
                    $controller = new SecurityController($this, new SecurityView($this));
                    $controller->deconnectUser();
                    unset($_SESSION['user']);
                }

                if($_POST["form"] == "inscription"){
                    $controller = new SecurityController($this, new SecurityView($this));
                    $controller->makeInscriptionPage($_POST);
                }

                if($_POST["form"] == "recherche"){
                    $controller = new SearchController($this, new View($this));
                    $controller->searchJouet($_POST);
                } 

                if($_POST["form"] == "ajout"){
                    $controller = new JouetController($this, new JouetView($this));
                    $controller -> makeNouveauPage($_POST);
                }
                
                if($_POST["form"] == "modifier" && !isset($_POST["suppr"])){
                    $controller = new JouetController($this, new JouetView($this));
                    $jouetbuild = new JouetBuilder($_POST);
                    $controller->modifierJouet($jouetbuild);
                }


                if($_POST["form"] == "comment"){
                    $controller = new JouetController($this, new JouetView($this));
                    $commentairejouet = new CommentaireBuilder($_POST);
                    $controller->commenterJouet($commentairejouet, explode("/", $_GET["url"])[2]);
                }
                
                if($_POST["form"] == "modifier" && $_POST["suppr"] == "on"){
                    $controller = new JouetController($this, new JouetView($this));
                    $jouetbuild = new JouetBuilder($_POST);
                    $controller->supprimerJouet($jouetbuild);
                }
            }
        }

        /**
         * Si $_POST est vide, aucun formulaire n'a été envoyé et donc on peut afficher une des pages suivantes.
         * Si on ne teste pas cela, la page d'accueil s'affiche par dessus le formulaire qui est envoyé
         */
        if(sizeof($_POST) == 0){
            if($link == '' || isset($link[0]) && $link[0] == "accueil"){
                //Page d'accueil
                if($this->isGranted("ACCUEIL")){
                    $controller = new HomeController($this);
                    $controller->makeHomePage();
                }else{
                   $mainController->makeErrorPage(AppInterface::ERR_NOT_GRANTED); 
                }
            }elseif($link[0] == "connexion" && sizeof($link) == 1){
                //Page de connexion
                if($this->isGranted("CONNEXION")){
                    $controller = new SecurityController($this, new SecurityView($this));
                    $controller->makeConnectionPage();
                }else{
                    $mainController->makeErrorPage(AppInterface::ERR_NOT_GRANTED); 
                 }
            }elseif($link[0] == "inscription" && sizeof($link) == 1){
                //Page d'inscription
                if($this->isGranted("INSCRIPTION")){
                    $controller = new SecurityController($this, new SecurityView($this));
                    $controller->makeInscriptionPage();
                }else{
                    $mainController->makeErrorPage(AppInterface::ERR_NOT_GRANTED); 
                 }
            }elseif($link[0] == "about" && sizeof($link) == 1){
                //Page A propos
                if($this->isGranted("ABOUT")){
                    $mainController->makeAboutPage();
                }else{
                    $mainController->makeErrorPage(AppInterface::ERR_NOT_GRANTED); 
                }
            }elseif(sizeof($link) == 2 && $link[0] == "jouet" && $link[1] == "usertoys"){
                //Page Liste jouet
                if($this->isGranted("JOUET_OWNLIST")){
                    $controller = new JouetController($this, new JouetView($this));
                    $controller -> makeOwnListPage();
                }else{
                    $mainController->makeErrorPage(AppInterface::ERR_NOT_GRANTED); 
                }
            }elseif(sizeof($link) == 2 && $link[0] == "jouet" && $link[1] == "recherche"){
                //Page de résultat d'une recherche
                if($this->isGranted("JOUET_SEARCH")){
                    $controller = new SearchController($this, new View($this));
                    $controller->makeSearchResultPage();
                }else{
                    $mainController->makeErrorPage(AppInterface::ERR_NOT_GRANTED); 
                }
            }elseif(sizeof($link) == 2 && $link[0] == "jouet" && $link[1] == "liste"){
                //Page Liste jouet
                if($this->isGranted("JOUET_LISTE")){
                    $controller = new JouetController($this, new JouetView($this));
                    $controller -> makeListePage();
                }else{
                    $mainController->makeErrorPage(AppInterface::ERR_NOT_GRANTED); 
                }
            }elseif(sizeof($link) == 2 && $link[0] == "jouet" && $link[1] == "nouveau"){
                //Page Nouveau jouet
                if($this->isGranted("JOUET_NEW")){
                    $controller = new JouetController($this, new JouetView($this));
                    $controller -> makeNouveauPage();
                }else{
                    $mainController->makeErrorPage(AppInterface::ERR_NOT_GRANTED); 
                }
            }elseif(sizeof($link) == 3 && $link[0] == "jouet" && $link[1] == "detail"){
                //page détail jouet
                if($this->isGranted("JOUET_DETAIL")){
                    $controller = new JouetController($this, new JouetView($this));
                    $controller -> makeDetailPage($link[2]);
                }else{
                    $mainController->makeErrorPage(AppInterface::ERR_NOT_GRANTED); 
                }
            }elseif(sizeof($link) == 3 && $link[0] == "jouet" && $link[1] == "modifier"){
                //Page Modifier un jouet
                if($this->isGranted("JOUET_MODIF")){
                    $controller = new JouetController($this, new JouetView($this));
                    $controller -> makeModifierPage($link[2]);
                }else{
                    $mainController->makeErrorPage(AppInterface::ERR_NOT_GRANTED); 
                }
            }else{
                // Aucune page trouvée, erreur 404
                $mainController->makeErrorPage(AppInterface::ERR_404); 
            }
        }
    }


    /**
     * Méthode retournant un lien d'une route
     */
    public function getRoute(string $name, string $arg=null){
        if($arg == null){
            return $this->baseLink."/$name";
        }else{
            return $this->baseLink."/$name/$arg";
        }
        
    }

    
    public function getJouetSaveURL(){
        return $this->baseLink."/jouet/nouveau";
    }

    public function getJouetUpdateURL($id){
        return $this->baseLink."/jouet/modifier/" . $id;
    }

    public function getJouetDetailURL($id){
        return $this->baseLink."/jouet/detail/" . $id;
    }

    public function makeReturnHomeLink(array $link){
        switch (sizeof($link)){
            case 0:
                return "./";
            case 1:
                return "./";
            break;
            case 2:
                return "../";
            break;
            case 3:
                return "../../";
            break;
        }
    }

    public function getReturnHomeLink(){
        if($this->returnHomeLink == null){
            return "";
        }else{
            return $this->returnHomeLink;
        }
    }

    public function isGranted(string $grant){
        if(isset($_SESSION["userGrants"])){
            foreach($_SESSION["userGrants"] as $userGrant){
                if($userGrant == $grant){
                    return true;
                }else{
                    continue;
                }
                return false;
            }
        }
        return false;
    }
}

