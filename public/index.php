<?php
//on appelle l'autoloader pour nos namespaces et on initialise la session
require_once('../src/autoloader.php');
session_start();

//Fonction de debug
function dv($var){
    die(var_dump($var));
}

use App\Router;

$router = new Router();
$router->main();
?>