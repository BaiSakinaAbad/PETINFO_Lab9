<?php
// database configuration
$host = 'localhost';
$port = 3306;
$dbName = 'pet_system';
$username = 'root';
$password = '';


//connection string
$dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8";

try {
    $pdo = new PDO($dsn, $username, $password); //pdo instance
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set pdo to throw exceptions on error
  //  echo "Database connected...";

    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>