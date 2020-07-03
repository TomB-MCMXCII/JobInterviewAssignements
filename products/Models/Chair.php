<?php
class Chair extends Product {
    public $dimension;

    public function __construct($sku,$name,$price, $dimension){
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->dimension = $dimension;
    }
}
?>