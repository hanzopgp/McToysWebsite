<?php

namespace App\Tool\Interfaces;

interface AppInterface{

    /*=========================*/
    /*===== ENV VARIABLES =====*/
    /*=========================*/

    const PROJECT_BASE = "/McToys/tw3--annee-2020-2021--projet--groupe_50/public";
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


}