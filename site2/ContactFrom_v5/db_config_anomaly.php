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
    $stmt = $conn->prepare("INSERT INTO positive_nipt (sample_number, age, date_reception, sex, anomaly) 
VALUES (:sample_number, :age, :date_reception, :sex, :anomaly)");
    $stmt->bindParam(':sample_number', $sample_number);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':date_reception', $date_reception);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':anomaly', $anomaly);

// insert a row
    $sample_number = $_POST["sample_number"];
    $age = $_POST["age"];
    $date_reception = $_POST["date_reception"];
    $sex = $_POST["sex"];
    $anomaly = $_POST["anomaly"];
    $stmt->execute();


    echo "New records created successfully";
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>