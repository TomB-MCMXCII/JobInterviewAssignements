<?php
require_once('Models/Product.php');

if(!isset($_GET["f"]))
{
    index();
}else if($_GET["f"] == "addProduct" && isset($_POST))
{
    addProduct($_POST);   
}else if($_GET["f"] == "skuExists")
{
    skuExists();
}


function skuExists()
{
    $skuValidationData = $_POST["myData"];

    $productType = createProductType($skuValidationData);

    if($productType->FindBySku($skuValidationData) == false){    
        echo "0";
    }
    //if product with given sku does exist
    else{
        echo "1";
    }       
}

function addProduct($data)
{
    $productType = createProductType($data);
    
    $productType->insert($data);
    require_once "Views/newView.php";
}

function index()
{
    require_once "Views/newView.php";
}

function createProductType($data)
{
    $objectFactory = [
        "furniture" => function () {
            require_once('Models/Furniture.php');
            return new Furniture();
         },
         "book" => function() {
            require_once('Models/Book.php');
            return new Book();
         },
         "cd" => function() {
            require_once('Models/CompactDisc.php');
             return new CompactDisc();
         }
      ];
    $productObject = $objectFactory[$data["type"]]();
    return $productObject;
}

?>  