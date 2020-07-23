<?php
require_once("database.php");
class Furniture extends Product 
{
    public $height;
    public $width;
    public $length;
    private $db;
    private $table = "Furniture";

    public function __construct()
    {
       $this->db = new Database();
    }

    public function insert($data)
    {      
        $newArray = array("sku"=>strtoupper($data["sku"]),"name"=>$data["name"],"price"=>$data["price"],"height"=>$data["height"],"width"=>$data["width"],"length"=>$data["length"]);
        $this->db->Insert($this->table,$newArray);    
    }

    public function findBySku($data)
    {
        return $this->db->find($this->table,$data["sku"]);
    }

    public function getFurniture()
    {
        return $this->db->getTableData($this->table);
    }

    public function deleteById($id)
    {
        $this->db->deleteByKey($this->table,$id);
    }
}
?>