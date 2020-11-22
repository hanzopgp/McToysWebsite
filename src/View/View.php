<?php

namespace App\View;
use App\Router;
use App\Tool\Interfaces\AppInterface;

class View{

    protected $router;
    protected $title;
    protected $content;


    public function __construct(Router $router){
        $this->router = $router;
    }

    public function render(string $title = null){
        if($title != null){
            $this->title = AppInterface::WEB_NAME." - ".$title;
        }
        require_once("navbar.php");
        require_once("render.php");
    }

    public function showErrorPage(string $message, string $logo=null){
        if($logo != null){
            $this->content =
            '<div class="errorCard card"><h1><i class="'.$logo.'"></i>
            <h3>'.$message.'</h3></div>';
        }else{
            $this->content =
            '<div class="errorCard card"><h1><i class="fas fa-ban"></i>
            <h3>'.$message.'</h3></div>';
        }
        $this->render("Erreur");
    }

    public function makeSuccessAlert(string $message){
        if(isset($_SESSION["successAdd"]) && $_SESSION["successAdd"] == 1){
            unset($_SESSION["successAdd"]);
            return '<div class="successAlert">'.$message.'</div>'; 
        }else{
            return;
        }
    }

    public function makeHomePage(){
        if(isset($_SESSION['user'])){
            $this->content .= "<div class='gallery-menu'>
                                <a href=".$this->router->getRoute("jouet/liste").">
                                <div class='gallery-menu-option'>
                                    <div class='gallery-icon'><i class='fas fa-list'></i></div>
                                    <div class='gallery-text'>Liste de jouet</div>
                                </div>
                                </a>

                                <a href=".$this->router->getRoute("jouet/nouveau").">
                                <div class='gallery-menu-option'>
                                    <div class='gallery-icon'><i class='fas fa-plus-square'></i></div>
                                    <div class='gallery-text'>Ajouter un jouet</div>
                                </div>
                                </a>

                                <a href=".$this->router->getRoute("about").">
                                <div class='gallery-menu-option'>
                                    <div class='gallery-icon'><i class='fas fa-bookmark'></i></div>
                                    <div class='gallery-text'>À Propos</div>
                                </div>
                               </div>";
            $this->render("Accueil");
        }else{
            $this->content .= "<div class='welcome'>
                                <div class='text-welcome'>
                                    <h1>McToys, l'e-commerce du jouet</h1>
                                    <p id='titre'>Avec McToys, trouvez le jouet que vous recherchez, vendez votre collection de jouet à des prix pharaoniques.
                                        Venez vite découvrir les jouets ajoutés chaque jours par les autres collectionneurs.
                                        McToys est le spécialiste de la collection de jouet sur internet. Vous pourrez trouver tout type
                                        de jouet, et ce très rapidement grâce à notre outil de  recherche !
                                        Allez, inscrivez-vous pour trouver votre bonheur !</p>
                                </div>
                                <div class='button-welcome'>
                                    <a href=".$this->router->getRoute("inscription")." class='button-welcome-inscription'>Inscription</a>
                                    <a href=".$this->router->getRoute("connexion")." class='button-welcome-connexion'>Connexion</a>".
                                "</div>
                               </div>";            
            $this->render("Accueil");
        }
    }

    public function makeAboutPage(){
        $this->content = '
        <div id="aboutPage">
            <h1 class="decoratedTitle">A propos</h1>

            <br>
            <fieldset>
                Ce projet a été réalisé par :
                <ul>
                    <li>LECONTE Thomas (22008087)</li>
                    <li>LEPAGE Dylan (21804570)</li>
                    <li>ROBERT Adrien (21701370)</li>
                    <li>DURAND Enzo (21510242)</li>
                </ul>
            </fieldset>
            
            <br>
            <fieldset>
                Compléments choisis :
                <ul>
                    <li>Un jouet est représenté par une image</li>
                    <li>Un jouet peut recevoir des commentaires</li>
                    <li>Un outil de recherche de jouets</li>
                </ul>
            </fieldset>

            <br>
            <h2 class="decoratedTitle">Structure du projet : </h2>
            <p>Notre projet est construit sur le modèle MVCR, comme imposé par le sujet. En ce qui concerne les namespaces et le routeur, nous aurions
            pu faire comme en TP, mais nous avons voulu mettre en place de nouvelles solutions, déjà connues par l\'un des membres du groupe.</p>

            <br>
            <h3 class="decoratedTitle">Namespace</h3>
            <p>Notre projet a été construit autour du principe de namespace. Un namespace n\'est ni plus ni moins qu\'un package en Java. Seulement,
            pour fonctionner correctement, il lui faut un <strong>Autoloader</strong> (chargement automatique des fichiers). Celà permet d\'éviter de
            faire plusieurs "require()" ou "include()". L\'autoloader fonctionne grâce à la fonction "<strong>spl_autoload_register()</strong>" qui
            prend en paramètre le nom d\'une classe. Etant donné qu\'on utilise des namespace, nos noms de classes sont composés de nos namespace. Par
            exemple, pour charger la classe "User", PHP va envoyer la valeur "<strong>App\Entity\User</strong>" à cette fonction. Ainsi, on a juste à
            remplacer notre "App" par "src", et nos "\" par des "/". On obtient donc le lien de notre fichier, que l\'on appelle dans une fonction
            <strong>require("NotreLien")</strong> ...</p>
            
            <br>
            <h3 class="decoratedTitle">Routeur :</h3>
            <p>Le routeur fonctionne avec des liens de type
            <strong>/projet/public/jouet/2</strong>, faisable grâce à une réecriture d\'URL Apache (dans le fichier <strong>public/.htaccess</strong>).
            Le fonctionnement est simple : En reprenant l\'exemple suivant (<strong>/projet/public/jouet/2</strong>), on va dire à Apache que tout
            ce qui est après <strong>public/</strong> est un paramètre GET qui s\'appelle "<strong>url</strong>" (ici, notre paramètre "url" serait
            <strong>jouet/2</strong>). Ensuite, grâce à PHP on va découper le paramètre "$_GET["url"]" dans un tableau, grâce à la fonction
            <strong>explode()</strong> (le séparateur étant le "/" que l\'on rencontre plusieurs fois dans notre URL de base). Ensuite, pour diriger
            l\'utilisateur au bon endroit, on teste la longueur de notre tableau et les différents éléments à l\'intérieur de celui-ci ...</p>
            

            <br>
            <h3 class="decoratedTitle">Controller :</h3>
            <p>Nos contrôleurs héritent tous d\'un <strong>MainController</strong>, ainsi on évite d\'écrire plusieurs fois le même code. Ensuite, pour
            chaque partie de notre projet, on a un contrôleur associé. Par exemple, pour la gestion des jouets, un JouetController existe, et pour la
            connexion / inscription, une SecurityView existe.<br>


            <br>
            <h3 class="decoratedTitle">View :</h3>
            <p>Nos vues héritent toutes d\'une <strong>View</strong>, ainsi on évite d\'écrire plusieurs fois le même code. Ensuite, pour
            chaque partie de notre projet, on a une vue associée. Par exemple, pour la gestion des jouets, une classe JouetView existe, et pour la
            connexion / inscription, une SecurityView existe.<br>
            <strong>NB :</strong>Concernant les vues, nous utilisons l\'outil <a href="https://fontawesome.com/">FontAwesome</a>, <strong>après accord de
            Mr Jean-Marc Lecarpentier</strong>. C\'est un outil permettant d\'utiliser des icônes sous forme textuelle. Par exemple, on peut obtenir un
            superbe chien grâce à cet outil <i class="fas fa-dog"></i> ! Nous l\'utilisons pour notre barre de navigation, et pour les formulaires...</p>


            <br>
            <h3 class="decoratedTitle">Storage :</h3>
            <p>Nos storages intéragissent avec la base de donnée. Ils héritent tous d\'un <strong>MainStorage</strong>, ainsi on évite d\'écrire plusieurs fois
            le même code. Ensuite, pour chaque partie de notre projet, on a un storage associé. Par exemple, pour la gestion des jouets, un JouetStorage
            existe, et pour la connexion / inscription, un UserStorage existe.</p>


            <br><br>
            <h2 class="decoratedTitle">Installation du projet : </h2>
            <p>Après avoir glissé le projet dans le serveur web, il va falloir s\'assurer que celui-ci accepte la lecture de fichiers <strong>.htaccess</strong>
            et que la redirection d\'URL est activée, sans quoi le routeur ne fonctionnera pas.<br><strong>NB :</strong> Sur les serveurs de la fac, ces deux
            critères sont respectés, idem depuis un serveur web sous WAMP (Windows).<br>
            Si le serveur web fonctionne sur Linux depuis un ordinateur personnel, il faut donc modifier le fichier "<strong>/etc/apache2/apache2.conf</strong>" :
            <br>
            1 - <strong>sudo nano /etc/apache2/apache2.conf</strong><br>
            2 - Descendre le fichier jusqu\'à cet endroit : <br><img src="https://cdn.discordapp.com/attachments/768450234010304543/771016642205319199/unknown.png"
                alt="Image d\'exemple"/><br>
            3 - Dans la balise <strong>Directory /var/www</strong>, modifier la ligne <strong>Allow override None</strong> par  <strong>Allow override All</strong><br>
            4 - Sauvegarder le fichier, et executer la commande suivante : <strong>sudo a2enmod rewrite</strong>, et redémarrer Apache : <strong>sudo service apache2 
                restart</strong><br>
            5 - Modifier le fichier <strong>public/.htaccess</strong> :<br>
                Il faut renseigner le chemin qui servira de redirection à la ligne 8. Pour déterminer ce chemin, prenons cet exemple : J\'accède à mon projet via le lien
                <strong>http://localhost/licence3/projet/public/index.php</strong>. Le chemin de redirection sera donc <strong>/licence3/projet/public</strong>. Il faut
                renseigner ce chemin à la ligne 8 et 16 du projet (en prenant soin de garder "<strong>/index.php?url=$1</strong>" à la fin de la ligne 16).<br>
                Si malgré celà, le projet ne fonctionne pas, renseigner le chemin de redirection défini précédemment dans le fichier <strong>src/Tool/Interfaces/AppInterface
                .php</strong>, à la ligne 11.<br>
            Le projet est installé ! Il suffit d\'importer la base de données et ce sera tout. 
        </div>
        ';
        $this->render("A propos");
    }

}

?>