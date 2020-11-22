<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\CommentaireBuilder;
use App\Entity\Jouet;
use App\Entity\JouetBuilder;
use App\Router;
use App\Storage\CommentaireStorage;
use App\Storage\JouetStorage;
use App\Tool\Interfaces\AppInterface;
use App\View\View;

class JouetController extends MainController{

    public function __construct(Router $router, View $view = null){
        if($view !=null){
            parent::__construct($router, $view);
        }else{
            parent::__construct($router);
        }
    }

    /**
     * Créer un nouveau jouet ou traiter les données reçue
     */
    public function makeNouveauPage(array $data = null){
        if(isset($_SESSION["user"])){
            if($data != null){
                //Si on a du contenu dans le formulaire de date et du nom, on va créer un Jouet avec JouetBuilder
                //Puis on récupère la table dans la bd, et enfin on ajoute le jouet dans la base en changeant 
                //la valeur de successAdd pour pouvoir afficher un message pour confirmer l'ajout à la bd
                if(isset($data["jouet_nom"]) && isset($data["jouet_date"])&& isset($_SESSION["user"])){
                    $builder = new JouetBuilder($data);
                    $storage = new JouetStorage();
                    $id = $storage->generateId("jouet")+1;
                    $image = $_FILES["jouet_image"]["tmp_name"];
                    $name = uniqid().".".explode("/", $_FILES["jouet_image"]["type"])[1];
                    if(!(move_uploaded_file($image, "../upload/".$name))){
                        $image = null;
                    }       
                    if($builder->createJouet($id,$name) instanceof Jouet){
                        $storage->flush($builder->createJouet($id,$name));
                        $_SESSION["successAdd"] = 1;
                        header("Location: ../jouet/detail/".$id);
                    }else{
                        $this->view->showNouveauPage($builder);
                    }
                }else{
                    header("Location: ".$this->router->getJouetSaveURL());
                    $this->view->showNouveauPage();
                }
            }
            $this->view->showNouveauPage();
        }else{
            $this->view->showErrorPage(AppInterface::ERR_NOT_CONNECTED);
        }
    }

    /**
     * Afficher la fiche d'un jouet avec ses commentaires associés
     */
    public function makeDetailPage(int $id){
        if(isset($_SESSION['user'])){
            $storage = new JouetStorage();
            $commentaireStorage = new CommentaireStorage();
            if($storage->checkIfExist($id)){
                $this->view->showDetailPage($storage->getById($id), $commentaireStorage->getAllCommentairesByJouet($id));
            }else{
                $this->view->showErrorPage(AppInterface::ERR_404);
            }
        }else{
            $this->view->showErrorPage(AppInterface::ERR_NOT_CONNECTED);
        }
    }

    /**
     * Afficher la page de modification d'un jouet
     */
    public function makeModifierPage(int $id){
        if(isset($_SESSION['user'])){
            $storage = new JouetStorage();
            if($storage->checkIfExist($id)){
                if($_SESSION["user"]->getId() == (new JouetStorage())->getById($id)->getUser()->getId()){
                 $this->view->showModifierPage($storage->getById($id));
                }
                else{
                    $this->view->showErrorPage(AppInterface::ERR_NOT_YOUR_TOY);
                }
            }else{
                $this->view->showErrorPage(AppInterface::ERR_404);
            }
        }else{
            $this->view->showErrorPage(AppInterface::ERR_NOT_CONNECTED);
        }
    }

    /**
     * Modifie un jouet et redirige l'utilisateur vers la fiche du jouet modifié
     */
    public function modifierJouet(JouetBuilder $jouetbuild){
        $id = $jouetbuild->getData()["id_jouet"];
        $jouet = $jouetbuild->createJouet($id);
        if($jouet instanceof Jouet){
            $storage = new JouetStorage();
            $jouet = $storage->getById($id);
            $storage->update($jouet, $jouetbuild->getData());
            header("Location: ../../jouet/detail/".$jouet->getId());
        }
        else{
            $this->view->showModifierPage((new JouetStorage())->getById($id), $jouetbuild);       
         }  
    }

    /**
     * Supprime un jouet
     */
    public function supprimerJouet(JouetBuilder $jouetbuild){
        $storage = new JouetStorage();
        $id = $jouetbuild->getData()["id_jouet"];
        if($storage->checkIfExist($id)){
            if($_SESSION["user"]->getId() == (new JouetStorage())->getById($id)->getUser()->getId()){
                $storage = new JouetStorage();
                $storage->delete($id);
                header("Location: ../../");
            }
            else{
                $this->view->showErrorPage(AppInterface::ERR_NOT_YOUR_TOY);
            }
        }
        else{
            $this->view->showErrorPage(AppInterface::ERR_404);
        }
    }

    /**
     * Affiche tout les jouets de tout les membres
     */
    public function makeListePage(){
        $storage = new JouetStorage();
        $this->view->showListePage($storage->fetchAll());
    }

    /**
     * Affiche tout les jouets de l'utilisateur connecté
     */
    public function makeOwnListPage(){
        $storage = new JouetStorage();
        $this->view->showListePage($storage->fetchSearch($_SESSION["user"]->getId()), "Liste de tout vos jouets :");
    }

    /**
     * Commente un jouet et renvoie l'utilisateur vers la fiche du jouet qu'il a commenté
     * avec un message de validation
     */
    public function commenterJouet(CommentaireBuilder $commentairebuild, int $idJouet){
        $storage = new CommentaireStorage();
        $id = $storage->generateId("commentaire")+1;
        if($commentairebuild->createCommentaire($id) instanceof Commentaire){
            $storage->flush($commentairebuild->createCommentaire($id));
            $_SESSION["successAdd"] = 1;
            header("Location: ../../jouet/detail/".$idJouet);
        }
    }
}