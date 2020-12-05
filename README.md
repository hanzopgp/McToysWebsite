# McToysWebsite  

## Table des matières

1. [Auteurs](#projet-conçu-par-)
2. [Utilisation](#utilisation-)
3. [Liens utiles](#liens-utiles-)

## Projet conçu par : 

- Durand Enzo : 21510242
- Leconte Thomas : 22008087
- Robert Adrien : 21701370
- Lepage Dylan : 21804570

## Utilisation :
>Après avoir glissé le projet dans le serveur web, il va falloir s\'assurer que celui-ci accepte la lecture de fichiers  .htaccess 
>et que la redirection d\'URL est activée, sans quoi le routeur ne fonctionnera pas.   NB :  Sur les serveurs de la fac, ces deux
>critères sont respectés, idem depuis un serveur web sous WAMP (Windows).  
>Si le serveur web fonctionne sur Linux depuis un ordinateur personnel, il faut donc modifier le fichier " /etc/apache2/apache2.conf " :
>-1 -  sudo nano /etc/apache2/apache2.conf
>-2 - Descendre le fichier jusqu\'à cet endroit : https://cdn.discordapp.com/attachments/768450234010304543/771016642205319199/unknown.png
>-3 - Dans la balise  <Directory /var/www> , modifier la ligne  Allow override None  par   Allow override All   
>-4 - Sauvegarder le fichier, et executer la commande suivante :  sudo a2enmod rewrite , et redémarrer Apache :  sudo service apache2 
>   restart
>-5 - Modifier le fichier  public/.htaccess  :  
>    Il faut renseigner le chemin qui servira de redirection à la ligne 8. Pour déterminer ce chemin, prenons cet exemple : J\'accède à mon projet via le lien
>    http://localhost/licence3/projet/public/index.php . Le chemin de redirection sera donc  /licence3/projet/public . Il faut
>    renseigner ce chemin à la ligne 8 et 16 du projet (en prenant soin de garder " /index.php?url=$1 " à la fin de la ligne 16).  
>    Si malgré celà, le projet ne fonctionne pas, renseigner le chemin de redirection défini précédemment dans le fichier  src/Tool/Interfaces/AppInterface
>    .php , à la ligne 11.  
    
>**Le projet est installé ! Il suffit d\'importer la base de données et ce sera tout.**   

## Liens utiles :

- https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller
- https://www.geeksforgeeks.org/maximum-size-rectangle-binary-sub-matrix-1s/
