<?php
require_once("database.php");
class Book extends Product 
{
    public $weight;
    private $db;
    private $table = "Books";

    public function __construct()
    {
        $this->db = new Database();
    }

    public function insert($data)
    { 
        $newArray = array("sku"=>strtoupper($data["sku"]),"name"=>$data["name"],"price"=>$data["price"],"weight"=>$data["weight"]);
        $this->db->insert($this->table,$newArray);    
    }

    public function findBySku($data)
    {
        return $this->db->find($this->table,$data["sku"]);
    }

    public function getBooks()
    {
        return $this->db->getTableData($this->table);
    }

    public function deleteById($id)
    {
        $this->db->deleteByKey($this->table,$id);
    }

}

?>