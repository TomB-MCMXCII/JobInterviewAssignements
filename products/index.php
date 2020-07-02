<?php
 spl_autoload_register(function($className){
     if(file_exists($className . ".php")) {
        require_once $className . ".php";
     }
     else if(file_exists("Controllers/" . $className . ".php")) {
        require_once "Controllers/" . $className . ".php";
     }
 });

 new ProductListController();
?>