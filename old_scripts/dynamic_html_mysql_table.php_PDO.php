<form action="#" method="post">
<select name="Table">
<option value="run_parameters">run_parameters</option>
<option value="sequencing_report">Sequencing_report</option>
<option value="reagent_report">Reagent_report</option>
<option value="quant_report">Quantification_report</option>
</select>
<input type="submit" name="submit" value="Get Selected Values" />
</form>
<?php

if(isset($_POST['submit']))
{
$search=$_POST['Table'];
$conn = new PDO("mysql:host=127.0.0.1; dbname=nipt", "project","Mol#biol2");

try {
    $con= new PDO("mysql:host=127.0.0.1; dbname=nipt", "project","Mol#biol2");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT * FROM $search";
    //first pass just gets the column names
    print "<table> ";
    $result = $con->query($query);
    //return only the first row (we only need field names)
    $row = $result->fetch(PDO::FETCH_ASSOC);
    print " <tr> ";
    foreach ($row as $field => $value){
     print " <th>$field</th> ";
    } // end foreach
    print " </tr> ";
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
    } catch(PDOException $e) {
     echo 'ERROR: ' . $e->getMessage();
    } // end try
}
?>