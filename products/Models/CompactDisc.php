<?php
require_once("database.php");
class CompactDisc extends Product {
    public $size;
    private $db;
    private $table = "CompactDiscs";

    public function __construct(){
        $this->db = new Database();
    }

    public function Insert($data)
    { 
        $newArray = array("sku"=>strtoupper($data["sku"]),"name"=>$data["name"],"price"=>$data["price"],"size"=>$data["size"]);
        $this->db->Insert($this->table,$newArray);    
    }

    public function FindBySku($data){
        return $this->db->Find($this->table,$data["sku"]);
    }

    public function GetCds()
    {
        return $this->db->GetTableData($this->table);
    }

    public function DeleteById($id)
    {
        $this->db->DeleteByKey($this->table,$id);
    }
}
?>