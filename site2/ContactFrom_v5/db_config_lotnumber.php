<?php
$host = "127.0.0.1";
$userName = "project";
$password = "Mol#biol2";
$dbName = "nipt";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $userName, $password);
// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO lotnumber_nipt (lot_number,expiration_date, reception_date, reagent_type) 
VALUES (:lot_number, :expiration_date, :reception_date, :reagent_type)");
    $stmt->bindParam(':lot_number', $lot_number);
    $stmt->bindParam(':expiration_date', $expiration_date);
    $stmt->bindParam(':reception_date', $reception_date);
    $stmt->bindParam(':reagent_type', $reagent_type);

// insert a row
    $lot_number = $_POST["lot_number"];
    $expiration_date = $_POST["expiration_date"];
    $reception_date = $_POST["reception_date"];
    $reagent_type = $_POST["reagent_type"];
    $stmt->execute();


    echo "New records created successfully";
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>