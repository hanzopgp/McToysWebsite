<?php

use App\Tool\Interfaces\AppInterface;

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo $this->router->getReturnHomeLink(); ?>style/style.css" rel="stylesheet"/>
        <link href="<?php echo $this->router->getReturnHomeLink(); ?>style/connexion.css" rel="stylesheet"/>
        <link href="<?php echo $this->router->getReturnHomeLink(); ?>style/accueil.css" rel="stylesheet"/>
        <link href="<?php echo $this->router->getReturnHomeLink(); ?>style/jouets.css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Signika&display=swap" rel="stylesheet"> <!--POLICE D'ECRITURE-->
        <script src="https://kit.fontawesome.com/50db597567.js" crossorigin="anonymous"></script> <!--ICONE NAVBAR -->
        <title><?php echo $this->title ?></title>
    </head>
    <body>
        <nav class="navbar">
            <div class="nav-title">
                <a href="<?php echo $this->router->getRoute("accueil"); ?>"><i class="fas fa-hamburger"></i> <?php echo AppInterface::WEB_NAME; ?></a>
            </div>
            <div class="nav-links">
                <ul>
                    <?php
                        if($this->router->isGranted("JOUET_SEARCH")){
                    ?>
                        <li class="item search-item">
                            <form action="<?php echo $this->router->getReturnHomeLink(); ?>" method="POST">
                                <input type="hidden" name="form" value="recherche"/>
                                <input type="text" name="rechercher" placeholder="Rechercher ..."/>
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </li>
                    <?php
                        }
                    ?>

                    <li class="item"><a href="<?php echo $this->router->getRoute("accueil"); ?>"><i class="fas fa-home"></i> Accueil</a></li>
                    <li class="item"><a href="<?php echo $this->router->getRoute("about"); ?>"><i class="fas fa-bookmark"></i> A propos</a></li>
                    <?php if(isset($_SESSION["user"])){
                    ?>
                        <li class="item">
                            <a href="<?php echo $this->router->getRoute("jouet/liste"); ?>"><i class="fas fa-car"></i> Jouets</a>
                            <ul class="nav-submenu">
                                <li class="submenu-item" onclick='document.location.href="<?php echo $this->router->getRoute("jouet/liste"); ?>"'><i class="fas fa-list"></i> Liste des jouets</li>
                                <li class="submenu-item" onclick='document.location.href="<?php echo $this->router->getRoute("jouet/nouveau"); ?>"'><i class="fas fa-plus-square"></i> Ajouter un jouet</li>
                            </ul>
                        </li>
                        <li class="item">
                            <a href="<?php echo $this->router->getRoute("connexion"); ?>"><i class="fas fa-user"></i> <?php echo $_SESSION["user"]->getUsername(); ?></a>
                            <ul class="nav-submenu">
                                <li class="submenu-item" onclick='document.location.href="<?php echo $this->router->getRoute("connexion"); ?>"'><i class="fas fa-door-open"></i> Se déconnecter</li>
                                <li class="submenu-item" onclick='document.location.href="<?php echo $this->router->getRoute("jouet/usertoys"); ?>"'><i class="fas fa-list"></i> Mes jouets</li>
                            </ul>
                        </li>
                    <?php
                    }else{
                        echo '<li class="item"><a href="'.$this->router->getRoute("jouet/liste").'"><i class="fas fa-car"></i> Jouets</a></li>';
                        echo '<li class="item"><a href="'.$this->router->getRoute("connexion").'"><i class="fas fa-user"></i> Connexion</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>