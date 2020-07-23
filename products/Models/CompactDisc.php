<?php
require_once("database.php");
class CompactDisc extends Product 
{
    public $size;
    private $db;
    private $table = "CompactDiscs";

    public function __construct()
    {
        $this->db = new Database();
    }

    public function insert($data)
    { 
        $newArray = array("sku"=>strtoupper($data["sku"]),"name"=>$data["name"],"price"=>$data["price"],"size"=>$data["size"]);
        $this->db->insert($this->table,$newArray);    
    }

    public function findBySku($data){
        return $this->db->find($this->table,$data["sku"]);
    }

    public function getCds()
    {
        return $this->db->getTableData($this->table);
    }

    public function deleteById($id)
    {
        $this->db->deleteByKey($this->table,$id);
    }
}
?>