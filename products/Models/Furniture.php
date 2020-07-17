<?php
require_once("database.php");
class Furniture extends Product {
    public $height;
    public $width;
    public $length;
    private $db;
    private $table = "Furniture";

    public function __construct(){
       $this->db = new Database();
    }

    public function Insert($data)
    { 
        $newArray = array("sku"=>strtoupper($data["sku"]),"name"=>$data["name"],"price"=>$data["price"],"height"=>$data["height"],"width"=>$data["width"],"length"=>$data["length"]);
        $this->db->Insert($this->table,$newArray);    
    }

    public function FindBySku($data){
        return $this->db->Find($this->table,$data["sku"]);
    }

    public function GetFurniture()
    {
        return $this->db->GetTableData($this->table);
    }

    public function DeleteById($id)
    {
        $this->db->DeleteByKey($this->table,$id);
    }
}
?>