<?php
require_once('Models/Product.php');
require_once("database.php");

if(!isset($_GET["f"])){
    index();
}else if($_GET["f"] == "newProduct" && isset($_POST)){
    $data = $_POST;
    $db = new Database();
    $productObject = createProduct($data);
    $db->insert($productObject);
    require_once "Views/newView.php";
}

function index(){
    require_once "Views/newView.php";
}

function createProduct($data){
    $objectFactory = [
        "furniture" => function ($data) {
            require_once('Models/Furniture.php');
            return new Furniture($data["sku"],$data["name"],$data["price"],$data["height"],$data["width"],$data["length"]);
         },
         "book" => function($product) {
            require_once('Models/Book.php');
            return new Book($data["sku"],$data["name"],$data["price"],$data["weight"]);
         },
         "cd" => function($product) {
            require_once('Models/CompactDisc.php');
             return new CompactDisc($data["sku"],$data["name"],$data["price"],$data["size"]);
         }
      ];
    $productObject = $objectFactory[$product["type"]]($product);
    return $productObject;
}

?>  