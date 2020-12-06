<?php

namespace App\View;

use App\Entity\Jouet;
use App\Entity\JouetBuilder;
use App\Router;
use App\View\View;

class JouetView extends View{

        
    /**
     * Constructeur
     *
     * @param  mixed $router - routeur à utiliser pour les liens CSS et les liens vers les routes
     * @return void
     */
    public function __construct(Router $router){
        parent::__construct($router);
    }


    /**
     * Affiche la page d'ajout d'un jouet
     */
    public function showNouveauPage(JouetBuilder $builder = null){
        //Si on a un builder en argument, on affiche la page avec les formulaires rempli sinon elles sont vides
        if($builder != null){
            $this->content = $this->makeJouetCreationPage($builder);
            $this->render("Ajout d'un jouet");
        }else{
            $this->content = $this->makeJouetCreationPage();
            $this->render("Ajout d'un jouet");
        }
    }


    /**
     * Voir détail d'un jouet
     */
    public function showDetailPage(Jouet $jouet, array $commentaire=null){
        if($commentaire == null){
            $this->content = $this->makeJouetDetailPage($jouet);
        }else{
            $this->content = $this->makeJouetDetailPage($jouet, $commentaire);
        }
        $this->render("Detail du jouet");
    }

     /**
      * Voir la liste de jouet
      */
     public function showListePage(array $jouet, string $title = null){
        if($title != null){
            $this->content = $this->makeJouetListePage($jouet, $title);
        }else{
            $this->content = $this->makeJouetListePage($jouet);
        }
        $this->render("Liste de jouets");
    }

    /**
     * Modifier un jouet
     */
    public function showModifierPage(Jouet $jouet, JouetBuilder $builder = null){
        if($builder != null){
            $this->content = $this->makeJouetModifierPage($jouet, $builder);
            $this->render("Modification d'Objet");
        }else{
            $this->content = $this->makeJouetModifierPage($jouet);
            $this->render("Modification d'Objet");
        }
    }

    /**
     * On crée une page avec trois labels : nom, date et image.
     */ 
    public function makeJouetCreationPage(JouetBuilder $jouetbuild = null){
        // Si on a eu une erreur, on affiche où son les erreurs et on remet les anciennes valeur dans les labels 
        if($jouetbuild != null){
            $dataForm = $jouetbuild->getData();
            $error = $jouetbuild->getError();
            $content = 
            "<div class='dangerAlert'>".$error."</div>
            <div id='formAjout' class='card'>
            <h1 class='decoratedTitle'>Ajout d'un jouet</h1>
            <br> <form action='nouveau' method='POST' enctype='multipart/form-data'>
                <div class='form-item'>
                    <label for='nom'>Nom :</label>
                    <input type='text' id='nom' name='jouet_nom' value='".$dataForm['jouet_nom']."'>
                </div>
                 <div class='form-item'>
                    <label for='date'>Date :</label>
                    <input type='date' id='date' name='jouet_date' value='".$dataForm['jouet_date']."'>
                </div>    
                <div class='form-item'>
                    <label for='image'>Image :</label>
                    <input type='file' id='image' name='jouet_image'/>
                </div>
                <div class='form-item'>
                    <input type='hidden' name='form' value='ajout'/>
                    <button id='formButtonSubmit' type='submit'> Valider </button>
                </div>   
            </form></div>";
            return $content;
        }else{
            $content = '';
            // Si on a réussi à ajouter un jouet à la bd, on affiche un message 
            if(isset($_SESSION["successAdd"]) && $_SESSION["successAdd"] == 1){
                $content .= "<div class='successAlert'>Vous avez ajouter un jouet !</div>";
                $_SESSION["successAdd"] = 0;
            }
            //On affiche les labels vide 
            $content .= "
            <div id='formAjout' class='card'>
            <h1 class='decoratedTitle'>Ajout d'un jouet</h1>
            <br> <form action='nouveau' method='POST' enctype='multipart/form-data'>
                <div class='form-item'>
                    <label for='nom'>Nom :</label>
                    <input type='text' id='nom' name='jouet_nom'/>
                </div>
                <div class='form-item'>
                    <label for='date'>Date :</label>
                    <input type='date' id='date' name='jouet_date'/>
                </div>    
                <div class='form-item'>
                    <label for='image'>Image :</label>
                    <input type='file' id='image' name='jouet_image'/>
                </div>
                <div class='form-item'>
                    <input type='hidden' name='form' value='ajout'/>
                    <button id='formButtonSubmit' type='submit'> Valider </button>
                </div>   
            </form></div>";
            return $content;
        }
    }

    /**
     * Voir la fiche d'un jouet avec la liste des commentaires associés
     */
    public function makeJouetDetailPage(Jouet $jouet, array $commentaires = null){
        $content = '<div class="jouetDetail">'.
                        '<div class="jouetCard">'.
                            '<div class="card-image">
                                <img class="jouetImage" src="../../../upload/'.$jouet->getImage().'"/>
                            </div>'.
                            '<div class="card-desc">'.
                                '<div class="card-title">'.
                                    '<h1 class="decoratedTitle">'.$jouet->getNom().'</h1> Ajouté par '.$jouet->getUser()->getUsername().'<br>'.
                                '</div>'.
                                '<div class="card-content">'.
                                    '<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><br>'.
                                '</div>'.
                                
                                '<p> Date de l\'ajout du jouet : '.$jouet->getDate().'</p><br>'.
                            '</div>'.
                        '</div>'.
                        $this->makeSuccessAlert("Votre commentaire a été ajouté avec succès !").
                        '<div class="jouetComment">'.
                            $this->makeJouetCommentForm($jouet).
                            '<div class="comments">
                                <h3 class="decoratedTitle">Commentaires : </h3>';
        if($commentaires != null){
            foreach ($commentaires as $comment) {
                $content .= 
                    '<div class="card-comment">'.
                        '<div class="comment-title">'.
                            '<p>Ajouté par <strong>'.$comment->getAuteur()->getUsername().'</strong>  - le '.$comment->getDate().'</p>'.
                        '</div>'.
                        '<div class="comment-content">'.
                            '<p> '.$comment->getMessage().'</p><br>'.
                        '</div>'.                       
                    '</div>';
            }
        }else{
            $content.= "<br>Aucun commentaire n'a été enregistré par nos membres sur ce jouet...";
        }
        $content.= '</div></div></div>';
        return $content;
    }

    /**
     * Affiche la liste des jouets avec un titre optionnel
     */
    public function makeJouetListePage(array $jouets, string $title = null){
        if($title != null){
            $content = '<ul class="listeJouets">
                <li><h2 class="decoratedTitle">'.$title.'</h2><br></li>';
        }else{
            $content = '<ul class="listeJouets">
                <li><h2 class="decoratedTitle">Liste des jouets des membres :</h2><br></li>';
        }        
        if($jouets == null){
            $content.= "<li>Aucun jouet n'a été enregistré par nos membres ...</li>";
        }else{
            foreach ($jouets as $jouet) {
                $content .= '<li class="jouet-item">'.
                                '<div class="jouet-image">
                                    <img src="../../upload/'.$jouet->getImage().'" alt="Image du jouet '.$jouet->getNom().'"/>'.
                                '</div>
                                <div class="jouet-content">
                                    <h3 class="decoratedTitle">'.$jouet->getNom().'</h3><br>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>';
                                if($this->router->isGranted("JOUET_MODIF") && $this->router->isGranted("JOUET_DETAIL")){
                                    if($jouet->getUser()->getId() == $_SESSION["user"]->getId()){
                                        $content.=
                                        '<div class="jouet-actions">
                                            <a class="jouet-button" href="'.$this->router->getJouetUpdateURL($jouet->getId()).'">Modifier</a>
                                            <a class="jouet-button" href="'.$this->router->getJouetDetailURL($jouet->getId()).'">Consulter</a>
                                        </div>';
                                    }else{
                                        $content.=
                                        '<div class="jouet-actions">
                                            <a class="jouet-button" href="'.$this->router->getJouetDetailURL($jouet->getId()).'">Consulter</a>
                                        </div>';
                                    }

                                }  
                            $content.='<li>';
            }
        }

        $content .= '</ul>';
        return $content;
    }

    /**
     * Affiche la vue pour modifier un jouet
     */
    public function makeJouetModifierPage(Jouet $jouet, JouetBuilder $jouetbuild = null){
        $content = "";
        if($jouetbuild != null){
            $error = $jouetbuild->getError();
            $dataForm = $jouetbuild->getData();
            $content .= 
            "<div class='dangerAlert'>".$error."</div>
            <div id='formModif' class='card'>
            <center><h1 class='decoratedTitle'>Modification du jouet '".$jouet->getNom()."'</h1>
            <br> <form action='".$jouet->getId()."' method='POST' enctype='multipart/form-data'>
                <div class='form-item'>
                    <label for='nom'>Nouveau Nom :</label>
                    <input required type='text' name='jouet_nom' value='".$dataForm['jouet_nom']."'>
                </div>
                <div class='form-item'>
                    <label for='date'>Nouvelle Date :</label>
                    <input required type='date' name='jouet_date' value='".$dataForm['jouet_date']."'>
                </div>    
                <div class='form-item'>
                    <label for='image'>Nouvelle Image :</label>
                    <input type='file' name='jouet_image'>
                </div>
                <div class='form-item'>
                    <input type='hidden' name='id_jouet' value='".$jouet->getId()."'>
                </div>
                <div class='form-item'>
                    <input type='hidden' name='form' value='supprimer'/>
                    <button type='submit'> Supprimer le jouet </button>
                </div>  
                <div class='form-item'>
                    <input type='hidden' name='form' value='modifier'/>
                    <button id='formButtonSubmit' type='submit'>Enregistrer</button>
                </div>   
            </form></center></div>";
        }   
        else{
            $content .= 
            "<div id='formModif' class='card'>
            <center><h1 class='decoratedTitle'>Modification du jouet '".$jouet->getNom()."'</h1>
            <br> <form action='".$jouet->getId()."' method='POST' enctype='multipart/form-data'>
                <div class='form-item'>
                    <label for='nom'>Nouveau Nom :</label>
                    <input required type='text' name='jouet_nom' value='".$jouet->getNom()."'>
                </div>
                <div class='form-item'>
                    <label for='date'>Nouvelle Date :</label>
                    <input required type='date' name='jouet_date' value='".$jouet->getDate()."'>
                </div>    
                <div class='form-item'>
                    <label for='image'>Nouvelle Image :</label>
                    <input type='file' name='jouet_image'>
                </div>
                <div class='form-item'>
                    <input type='hidden' name='id_jouet' value='".$jouet->getId()."'>
                </div>
                <br><br>
                <input id='del' onclick='return confirm(\"Voulez vous vraiment supprimer ce jouet ? Vous supprimerez
                également ses commentaires !\");' type='checkbox' name='suppr'/>
                <label for='del'>Supprimer ce jouet</label>
                <div class='form-item'>
                    <input type='hidden' name='form' value='modifier'/>
                    <button id='formButtonSubmit' type='submit'>Enregistrer</button>
                </div>   
            </form></center></div>";
        }
        return $content;
    }

    /**
     * Formulaire pour commenter un jouet
     */
    public function makeJouetCommentForm(Jouet $jouet){
        $content =
            '<form action="'.$jouet->getId().'" method="POST">'.
                '<div class="form-item">'.
                    '<label for="commentaire">Votre commentaire</label>'.
                    '<textarea name="commentaire" rows="5" placeholder="Ajouter un commentaire..."></textarea>'.
                '</div>'.
                '<input type="hidden" name="id" value="'.$jouet->getId().'"/>'.
                '<input type="hidden" name="form" value="comment"/>'.
                '<div class="form-item">'.
                    '<button type="submit"> Valider </button>'.
                '</div>'.
            '</form>';
        return $content;
    }
}

?>
