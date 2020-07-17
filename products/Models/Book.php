<?php
require_once("database.php");
class Book extends Product {
    public $weight;
    private $db;
    private $table = "Books";

    public function __construct(){
        $this->db = new Database();
    }

    public function Insert($data)
    { 
        $newArray = array("sku"=>strtoupper($data["sku"]),"name"=>$data["name"],"price"=>$data["price"],"weight"=>$data["weight"]);
        $this->db->Insert($this->table,$newArray);    
    }

    public function FindBySku($data){
        return $this->db->Find($this->table,$data["sku"]);
    }

    public function GetBooks()
    {
        return $this->db->GetTableData($this->table);
    }

    public function DeleteById($id)
    {
        $this->db->DeleteByKey($this->table,$id);
    }

}

?>