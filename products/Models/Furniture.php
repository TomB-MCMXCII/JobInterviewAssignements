<?php
class Furniture extends Product {
    public $height;
    public $width;
    public $length;

    public function __construct($sku,$name,$price, $height, $width, $length){
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }
}
?>