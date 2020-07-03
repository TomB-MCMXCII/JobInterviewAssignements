<?php

if(!isset($_GET["f"])){
    index();
}
else if($_GET["f"] = "massDelete"){
    massDelete();
}

function index(){
    require_once "Views/listView.html";
}
function massDelete(){
    echo "mass delete";
}

?> 