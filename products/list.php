<?php

if(!isset($_GET["f"])){
    index();
}
else if(isset($_GET["sku"])){
    var_dump($_GET["sku"]);
}
else if($_GET["f"] = "massDelete"){
    massDelete();
}

function index(){
    require_once "Views/listView.php";
}
function massDelete(){
    echo "mass delete";
}

?> 