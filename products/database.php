<?php
class Database{
        private $servername = "127.0.0.1";
        private $username = "root";
        private $password = "";
        private $count = 0;
    public function __construct()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password);

        if ($conn->connect_error) {
        //die("Connection failed: " . $conn->connect_error);
        }

        $sql = "CREATE DATABASE IF NOT EXISTS Products";
        if ($conn->query($sql) === TRUE) {
        
        } else {
        
        }
        $this->createTables($conn);
        $conn->close();
    }

    public function Insert($table,$data){
        $conn = new mysqli($this->servername, $this->username, $this->password);
        $columns = array_keys($data);

        $values = array();
        $paramTypes = array();
        foreach($columns as $c){ 
            $values[] = "?";
            $paramTypes[] = "s";
        }

        $stmt = $conn->prepare("INSERT INTO Products.". $table . " (" . implode(",", $columns) .") VALUES (". implode(",",$values) .")");

        $stmt->bind_param("". implode("", $paramTypes) ."", ...array_values($data) );

        if ($stmt->execute() === true) {
                
            } else {
                
            }
        
        $stmt->close();
        $conn->close();
        
    }

    public function Find($table,$value){
        $columns = $this->GetTableColumns($table);

        $conn = new mysqli($this->servername, $this->username, $this->password);
        $result = $conn->query("SELECT * FROM Products.". $table . " WHERE '$value' IN (". implode(",",$columns).")");

        if($result->num_rows > 0){
            return true;
        }
        else {
            return false;
        } 
    }

    public function GetTableData($table){
        $conn = new mysqli($this->servername, $this->username, $this->password);
        $sql = "SELECT * FROM Products.". $table ."";

        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
            if(count($rows) == 4){
                return $rows;
            }
        }
        if(!isset($rows)){
            return $rows = array();
        }
        return $rows;
    }

    public function GetTableColumns($table){
        $conn = new mysqli($this->servername, $this->username, $this->password);
        $sql = "SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA='Products'
            AND TABLE_NAME='$table'";
        
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $columns[] = $row['COLUMN_NAME'];
        }
        
        return $columns;

    }
    public function GetTableKeyColumnName($table){
        $conn = new mysqli($this->servername, $this->username, $this->password);
        $sql = "SELECT COLUMN_NAME 
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_NAME = '$table' 
        AND CONSTRAINT_NAME = 'PRIMARY'";
        $result = $conn->query($sql);
        $column = $result->fetch_assoc();
        return $column["COLUMN_NAME"];    
    }

    public function DeleteByKey($table,$id)
    { 
        
        $key = $this->GetTableKeyColumnName($table);
            
        $this->count = $this->count + 1; 

        $conn = new mysqli($this->servername, $this->username, $this->password);
        $stmt = $conn->prepare("DELETE FROM Products.". $table . " WHERE ". $key ." = ? ");
        
        $stmt->bind_param("i", intval($id));
        
        if ($stmt->execute() === true) {
                
        } else {
            
        }
    
    $stmt->close();
    $conn->close();

    }
    public function createTables($conn){
        //create furniture table
        $furnitureTable = "CREATE TABLE IF NOT EXISTS Products.Furniture (
            id int key AUTO_INCREMENT,
            sku varchar(25) NOT NULL ,
            name varchar(25) NOT NULL,
            price varchar(25) NOT NULL,
            width varchar(25) ,
            height varchar(25),
            length varchar(25)
        )";
        $booksTable = "CREATE TABLE IF NOT EXISTS Products.Books (
            id int key AUTO_INCREMENT,
            sku varchar(25) NOT NULL ,
            name varchar(25) NOT NULL,
            price varchar(25) NOT NULL,
            weight varchar(25) 
        )";
        $cdTable = "CREATE TABLE IF NOT EXISTS Products.CompactDiscs (
            id int key AUTO_INCREMENT,
            sku varchar(25) NOT NULL ,
            name varchar(25) NOT NULL,
            price varchar(25) NOT NULL,
            size varchar(25) 
        )";

        $tables = [$furnitureTable, $booksTable, $cdTable];

        foreach($tables as $k => $sql){
            if ($conn->query($sql) === TRUE) {
                //echo "Table created successfully ";
                } else {
                //echo "Error creating table: " . $conn->error;
                }
        }
    }
}
?>