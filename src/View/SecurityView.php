<?php

namespace App\View;

use App\Entity\UserBuilder;
use App\Router;

class SecurityView extends View{

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
     * Affiche la page d'inscription
     *
     * @param  mixed $builder - builder optionnel permettant d'afficher les éventuelles erreurs
     * @return void
     */
    public function showInscriptionPage(UserBuilder $builder = null){
        if($builder != null){
            $this->content = $this->makeInscriptionForm($builder);
            $this->render("Inscription");
        }else{
            $this->content = $this->makeInscriptionForm();
            $this->render("Inscription");
        }
        
    }
    
    /**
     * Affiche la page de connexion à l'utilisateur
     *
     * @param  mixed $error - Erreur optionnelle à afficher
     * @return void
     */
    public function showConnectionPage(string $error = null){
        if($error != null){
            $this->content = '<div class="dangerAlert">'.$error.'</div>';
        }
        $this->content .= '
        <div id="formConnexion" class="card">
            <h1>McToys</h1>
            <h2>Connectez-vous pour accéder à McToys</h2>';
        $this->content .= $this->makeConnectionForm();
        $this->content .= '
            <h4>Vous ne possédez pas encore de compte?</h4>
            <h5><a href="'.$this->router->getRoute("inscription").'">Inscrivez vous</a></h5>
        </div>
        ';
        $this->render("Connexion");
    }

    
    /**
     * Affiche la page de déconnexion
     *
     * @return void
     */
    public function showDeconnectionPage(){
        $this->content = '<div id="formDeconnexion" class="card">
                            <h1 class="decoratedTitle">Déconnexion</h1>
                                <h3 class="decoratedMessage">Voulez vous vous déconnecter ' . $_SESSION["user"]->getUsername() . ' ? </h3>';
        $this->content .= $this->makeDeconnectionForm();
        $this->content .= "</div>";
        $this->render("Deconnexion");
    }
    
    /**
     * Construit le formulaire d'inscription
     *
     * @param  mixed $builder - builder optionnel pour retourner les valeurs invalides à l'utilisateur
     * @return void
     */
    public function makeInscriptionForm(UserBuilder $builder = null){
        if($builder != null){
            $dataForm = $builder->getData();
            $error = $builder->getError();
            return '
            <div class="dangerAlert">'.$error.'</div>
            <div id="formInscription" class="card">
                <h1 class="decoratedTitle">Inscription</h1>
                <form action="inscription" method="POST">
                    <div class="form-item">
                        <label for="identifiant">Identifiant</label>
                        <input type="text" name="identifiant" id="identifiant" placeholder="Votre identifiant" value="'.$dataForm["identifiant"].'"/><br>
                    </div>
    
                    <div class="form-item">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" id="nom" placeholder="Votre nom" value="'.$dataForm["nom"].'"/><br>
                    </div>
    
                    <div class="form-item">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" id="prenom" placeholder="Votre prénom" value="'.$dataForm["prenom"].'"/><br>
                    </div>
    
                    <div class="form-item">
                        <label for="mdp">Mot de passe</label>
                        <input type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" value="'.$dataForm["mdp"].'"/><br>
                    </div>
    
                    <div class="form-item">
                        <label for="confirm_mdp">Confirmez votre mot de passe</label>
                        <input type="password" name="confirm_mdp" id="confirm_mdp" placeholder="Confirmation" value="'.$dataForm["confirm_mdp"].'"/><br>
                    </div>
                    <input type="hidden" name="form" value="inscription"/>
                    
                    <button id="inscription-button" type="submit">Confirmer</button>
                </form>
            </div>
            ';
        }else{
            $content = '';
            if(isset($_SESSION["successRegistered"]) && $_SESSION["successRegistered"] == 1){
                $content .= "<div class='successAlert'>Vous faites maintenant partie des membres de notre communauté, féliciations !</div>";
                $_SESSION["successRegistered"] = 0;
            }
            $content.= '
            <div id="formInscription" class="card">
                <h1 class="decoratedTitle">Inscription</h1>
                <form action="inscription" method="POST">
                    <div class="form-item">
                        <label for="identifiant">Identifiant</label>
                        <input required type="text" name="identifiant" id="identifiant" placeholder="Votre identifiant"/><br>
                    </div>
    
                    <div class="form-item">
                        <label for="nom">Nom</label>
                        <input required type="text" name="nom" id="nom" placeholder="Votre nom"/><br>
                    </div>
    
                    <div class="form-item">
                        <label for="prenom">Prénom</label>
                        <input required type="text" name="prenom" id="prenom" placeholder="Votre prénom"/><br>
                    </div>
    
                    <div class="form-item">
                        <label for="mdp">Mot de passe</label>
                        <input required type="password" name="mdp" id="mdp" placeholder="Votre mot de passe"/><br>
                    </div>
    
                    <div class="form-item">
                        <label for="confirm_mdp">Confirmez votre mot de passe</label>
                        <input required type="password" name="confirm_mdp" id="confirm_mdp" placeholder="Confirmation"/><br>
                    </div>
                    <input type="hidden" name="form" value="inscription"/>
                    
                    <button id="formButtonSubmit" type="submit">Confirmer</button>
                </form>
            </div>
            ';
            return $content;
        }

    }
    
    /**
     * Construit le formulaire de connexion
     *
     * @return void
     */
    public function makeConnectionForm(){
        return '
            <form action="connexion" method="post">
                <div class="form-item-connexion">
                    <label for="identifiant">Identifiant</label>
                    <input required type="text" id="identifiant" name="identifiant" placeholder="Identifiant"/>
                </div>
                <div class="form-item-connexion">
                    <label for="password">Mot de passe</label>
                    <input required type="password" id="password" name="password" placeholder="Mot de passe"/>
                </div>
                <div class="form-item-connexion">
                    <input type="hidden" name="form" value="connexion"/>
                    <button type="submit" id="formButtonSubmitConnection">Se connecter</button>
                </div>
            </form>
        ';          
    }
    
    /**
     * Construit le formulaire de déconnexion
     *
     * @return void
     */
    public function makeDeconnectionForm(){
        return '
            <form action="deconnexion" method="post">
                <input type="hidden" name="form" value="deconnexion"/>
                <button id="formButtonSubmit" type="submit"> Me déconnecter </button>
            </form>
        ';
        
    }
}