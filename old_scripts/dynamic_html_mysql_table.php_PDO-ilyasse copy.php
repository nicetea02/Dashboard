
<!DOCTYPE html>
<html>

<body>

<form action='#' method='post'>
<select name='Table'>
<option value='run_parameters'>run_parameters</option>
<option value='sequencing_report'>Sequencing_report</option>
<option value='reagent_report'>Reagent_report</option>
<option value='quant_report'>Quantification_report</option>
</select>
<input type='submit' name='submit' value='Get Selected Values' />
</form>

<canvas id="myChart" width="400" height="200"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php $keys ?>],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

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
    var_export($row);
    $keys = array_keys($row);
    $data_keys = json_encode($keys);
    echo($keys);
    echo($row);
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
};
?>

</body>
</html>