<?php

namespace App\Tool\Interfaces;

interface AppInterface{

    /*=========================*/
    /*===== ENV VARIABLES =====*/
    /*=========================*/

    const PROJECT_BASE = "/projet-inf5c-2020/public";
    const DB_LINK = "../config/bdd.json";


    /*=========================*/
    /*==== WEBSITE ENV VAR ====*/
    /*=========================*/

    const WEB_NAME = "McToys";

    /*------ROLE GRANTS-------*/

    const ROLE_VISITOR = [
        "ACCUEIL",
        "CONNEXION",
        "INSCRIPTION",
        "ABOUT",
        "JOUET_LISTE",
    ];

    const ROLE_USER = [
        "ACCUEIL",
        "CONNEXION",
        "INSCRIPTION",
        "ABOUT",
        "JOUET_NEW",
        "JOUET_LISTE",
        "JOUET_OWNLIST",
        "JOUET_SEARCH_BAR",
        "JOUET_RECHERCHE",
        "JOUET_DETAIL",
        "JOUET_MODIF",
        "JOUET_SUPPR",
        "JOUET_COMMENT",
        "JOUET_SEARCH"
    ];


    /*----ERRORS MESSAGES-----*/
    const ERR_PSW = "Le mot de passe que vous avez entré est incorrect. Veuillez réessayer...";
    const ERR_USER = "Ce compte n'existe pas. Veuillez vérifier vos identifiants et réessayer...";
    const ERR_NOT_GRANTED = "Vous n'avez pas la permission d'accéder à cette page !<br>Veuillez contacter
    votre administrateur pour plus d'informations.";
    const ERR_NOT_CONNECTED = "Vous devez être connecté pour accéder à cette page !";
    const ERR_404 = "Erreur 404 ! Veuillez réessayer.";
    const ERR_NOT_YOUR_TOY = "Vous ne pouvez modifier que des objets qui vous appartiennent !";

}