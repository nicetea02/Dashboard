<?php
header('Content-Type: application/json');
$host = "127.0.0.1";
$userName = "project";
$password = "Mol#biol2";
$dbName = "nipt";
$conn = new mysqli($host,$userName,$password,$dbName) or die($mysqli->error);

$sqlQuery = "SELECT batch_name, std_slope FROM quant_report LIMIT 14";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>