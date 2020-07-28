<!DOCTYPE html>
<html lang = "en-US">
 <head>
 <meta charset = "UTF-8">
 <title>contact.php</title>
 <link href="style.css" rel="stylesheet">
 </head>
 <body>
 <div class="header">
<h1>Summary of positive NIPT samples</h1>
<button class="button" style="vertical-align:middle"onclick="window.location.href = 'ContactFrom_v5/anomaly_form.html';"><span>Anomaly positives</span></button>
</div>
 <p>
 <?php
 $host = "127.0.0.1";
 $userName = "project";
 $password = "Mol#biol2";
 $dbName = "nipt";
  try {
$con = new PDO("mysql:host=$host;dbname=$dbName", $userName, $password);
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = "SELECT * FROM positive_nipt";
  //first pass just gets the column names
   print "<div class='container'>";
  print "<table class='responsive-table'> ";
  $result = $con->query($query);
  //return only the first row (we only need field names)
  $row = $result->fetch(PDO::FETCH_ASSOC);
  print "<thead>";
  print " <tr> ";
  foreach ($row as $field => $value){
   print " <th>$field</th> ";
  } // end foreach
  print " </tr> ";
  print "</thead>";
  //second query gets the data
  $data = $con->query($query);
  $data->setFetchMode(PDO::FETCH_ASSOC);
  foreach($data as $row){
   print " <tr> ";
   foreach ($row as $name=>$value){
   print " <td>$value</td> ";
   } // end field loop
   print " </tr> ";
  } // end record loop
  print "</table> ";
  print "</div>";
  } catch(PDOException $e) {
   echo 'ERROR: ' . $e->getMessage();
  } // end try
 ?>
 </p>
 </body>
</html>