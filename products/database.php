<?php
class Database{
        private $servername = "127.0.0.1";
        private $username = "root";
        private $password = "";
        
    public function __construct()
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password);
        // Check connection
        if ($conn->connect_error) {
        //die("Connection failed: " . $conn->connect_error);
        }

        // Create Products database
        $sql = "CREATE DATABASE IF NOT EXISTS Products";
        if ($conn->query($sql) === TRUE) {
        //echo "Database created successfully ";
        } else {
        //echo "Error creating database: " . $conn->error;
        }
        $this->createTables($conn);
        $conn->close();
    }

    function insert($product){
        $conn = new mysqli($this->servername, $this->username, $this->password);
        
        $stmt = $this->createInsertQuery($product,$conn);

        if ($stmt->execute() === TRUE) {
            return true;
            } else {
            return false;
            }
        
        $stmt->close();
        $conn->close();
        
    }

    function createInsertQuery($product,$conn){

        switch(true){
            case $product instanceof Furniture :
                $stmt = $conn->prepare("INSERT INTO Products.Furniture (sku, name, price, width, height, length)
                VALUES (?,?,?,?,?,?)");
                $stmt->bind_param("ssssss", $product->sku, $product->name, $product->price, $product->width, $product->height, $product->length);
                return $stmt;
                break;
            case $product instanceof Book : 
                $stmt = $conn->prepare("INSERT INTO Products.Books (sku, name, price, weight)
                VALUES (?,?,?,?)");
                $stmt->bind_param("ssss", $product->sku, $product->name, $product->price, $product->weight);
                return $stmt;
                break;
            case $product instanceof CompactDisc :
                $stmt = $conn->prepare("INSERT INTO Products.CompactDiscs (sku, name, price, size)
                VALUES (?,?,?,?)");
                $stmt->bind_param("ssss", $product->sku, $product->name, $product->price, $product->size);
                return $stmt;
                break;
        }
    }

    function createTables($conn){
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