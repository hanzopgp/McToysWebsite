<?php

//Vidéo source : https://www.youtube.com/watch?v=DimHSKuoyUo

/**
 * Fonction permettant de faire le mapping entre les namespace et les liens
 * physiques de chaque classe du projet
 */
spl_autoload_register(function($classname){
    // exemple d'une valeur de classname = App\Controller\MainController;
    if($classname == "App\Tool\Interfaces\AppInterface"){
        require("../src/Tool/Interfaces/AppInterface.php");
    }else{
        $classname = str_replace("App", "src", $classname);
        $classname = str_replace("\\", "/", $classname);
        require("../".$classname.".php");
    }
});