<form action="#" method="post">
<select name="Table">
<option value="run_parameters">run_parameters</option>
<option value="sequencing_report">Green</option>
<option value="reagent_report">Blue</option>
<option value="Pink">Pink</option>
<option value="Yellow">Yellow</option>
</select>
<input type="submit" name="submit" value="Get Selected Values" />
</form>
<?php

if(isset($_POST['submit']))
{
   $search=$_POST['Table'];
   $conn = new mysqli("127.0.0.1","project","Mol#biol2","nipt");
   $sql = "SELECT * FROM $search";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) 
   {
      echo "<table id='tbl'><tr>";
      $field=$result->fetch_fields();
// output column names  
echo "<table border = '2'>";
     foreach ($field as $col)
     {
        echo "<th>".$col->name."</th>";
     }
     echo "</tr>";

// output data of each row
echo "<table border = '2'>";
     while($row = $result->fetch_row()) 
     {
        echo "<tr>";

        for ($i=0 ; $i < sizeof($field) ; $i++)
        {
           echo "<td>".$row[$i]."</td>";
        }

        echo "</tr>";
      }
     echo "</table>";

  }

else  
{
 echo "No data found";
}

}


?>