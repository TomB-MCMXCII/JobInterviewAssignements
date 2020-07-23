<?php
class Database
{
    private $servername = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $dbName = "Products";

    public function __construct()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password);

        if ($conn->connect_error) {
        //die("Connection failed: " . $conn->connect_error);
        }

        $sql = "CREATE DATABASE IF NOT EXISTS $this->dbName";
        if ($conn->query($sql) === TRUE) {
        
        } else {
        
        }
        $this->createTables($conn);
        $conn->close();
    }
    // Inserts a single record given table and
    public function insert($table,$data)
    {
        $conn = new mysqli($this->servername, $this->username, $this->password);
        $columns = array_keys($data);

        $values = array();
        $paramTypes = array();
        foreach($columns as $c){ 
            $values[] = "?";
            $paramTypes[] = "s";
        }

        $stmt = $conn->prepare("INSERT INTO $this->dbName.". $table . " (" . implode(",", $columns) .") VALUES (". implode(",",$values) .")");

        $stmt->bind_param("". implode("", $paramTypes) ."", ...array_values($data) );

        if ($stmt->execute() === true) {
                
            } else {
                
            }
        
        $stmt->close();
        $conn->close();
        
    }

    // Looks for a given value in a particular table. If the value is found returns true;
    public function find($table,$value)
    {
        $columns = $this->getTableColumns($table);

        $conn = new mysqli($this->servername, $this->username, $this->password);
        $result = $conn->query("SELECT * FROM $this->dbName.". $table . " WHERE '$value' IN (". implode(",",$columns).")");

        if($result->num_rows > 0){
            return true;
        }
        else {
            return false;
        } 
    }

    // Gets all data from a given table;
    public function getTableData($table)
    {
        $conn = new mysqli($this->servername, $this->username, $this->password);
        $sql = "SELECT * FROM $this->dbName.". $table ."";

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
    // Gets all the column names of a given table;
    public function getTableColumns($table)
    {
        $conn = new mysqli($this->servername, $this->username, $this->password);
        $sql = "SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA='$this->dbName'
            AND TABLE_NAME='$table'";
        
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $columns[] = $row['COLUMN_NAME'];
        }
        
        return $columns;

    }
    // Gets the name of primary key column for a table;
    public function getTableKeyColumnName($table)
    {
        $conn = new mysqli($this->servername, $this->username, $this->password);
        $sql = "SELECT COLUMN_NAME 
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_NAME = '$table' 
        AND CONSTRAINT_NAME = 'PRIMARY'";
        $result = $conn->query($sql);
        $column = $result->fetch_assoc();
        return $column["COLUMN_NAME"];    
    }
    // Deletes a record by primary key;
    public function deleteByKey($table,$id)
    { 
        
        $key = $this->getTableKeyColumnName($table);

        $conn = new mysqli($this->servername, $this->username, $this->password);
        $stmt = $conn->prepare("DELETE FROM $this->dbName.". $table . " WHERE ". $key ." = ? ");
        
        $stmt->bind_param("i", intval($id));
        
        if ($stmt->execute() === true) 
        {
                
        } else 
        {
            
        }
    
    $stmt->close();
    $conn->close();

    }

    public function createTables($conn)
    {

        $furnitureTable = "CREATE TABLE IF NOT EXISTS $this->dbName.Furniture (
            id int key AUTO_INCREMENT,
            sku varchar(25) NOT NULL ,
            name varchar(25) NOT NULL,
            price varchar(25) NOT NULL,
            width varchar(25) ,
            height varchar(25),
            length varchar(25)
        )";
        $booksTable = "CREATE TABLE IF NOT EXISTS $this->dbName.Books (
            id int key AUTO_INCREMENT,
            sku varchar(25) NOT NULL ,
            name varchar(25) NOT NULL,
            price varchar(25) NOT NULL,
            weight varchar(25) 
        )";
        $cdTable = "CREATE TABLE IF NOT EXISTS $this->dbName.CompactDiscs (
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