<?php
require_once('Models/Product.php');
require_once('Models/Book.php');
require_once('Models/CompactDisc.php');
require_once('Models/Furniture.php');

if(!isset($_GET["f"])){
    index();
}
else if($_GET["f"] == "massDelete" && isset($_POST)){
    $data = $_POST;
    massDelete($data);
    index();
}

function index(){
    $book = new Book();
    $cd = new CompactDisc();
    $furniture = new Furniture();
    $data["books"] = $book->GetBooks();
    $data["cd"] = $cd->GetCds();
    $data["furniture"] = $furniture->GetFurniture();
    
    require_once "Views/listView.php";
}

function massDelete($data){
    if(isset($data["books"])){
        deleteBooks($data["books"]);
    }
    if(isset($data["cds"])){
        deleteCds($data["cds"]);
    }
    if(isset($data["furniture"])){
        deleteFurniture($data["furniture"]);
    }
}

function deleteBooks($books){
    $book = new Book();
    foreach($books as $key=>$value){
        $book->DeleteById($value);
    }
}

function deleteFurniture($furnitures){
    $furniture = new Furniture();
    foreach($furnitures as $key=>$value){
        $furniture->DeleteById($value);
    }
}

function deleteCds($cds){
    $cd = new CompactDisc();
    foreach($cds as $key=>$value){
        $cd->DeleteById($value);
    }
}
?> 