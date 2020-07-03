<?php
class Product {
    public $sku;
    public $name;
    public $price;

    public function __construct($sku,$name,$price){
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }
}
?>