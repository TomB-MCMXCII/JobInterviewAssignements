<?php
class CompactDisc extends Product {
    public $size;

    public function __construct($sku,$name,$price,$size){
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->size = $size;
    }
}
?>