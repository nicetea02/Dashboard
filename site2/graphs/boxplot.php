<!DOCTYPE html>
<html>
<head>
<title>Parameter Boxplot</title>
<link href="style.css" rel="stylesheet">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
<form action="#" method="post">
<select name="Boxplot_select">
<option value="std_rsquared">Standard R²</option>
<option value="std_slope">Standard Slope</option>
<option value="Q30">Q30</option>
<option value="cluster_density">Cluster Density</option>
<option value="phasing">Phasing</option>
<option value="prephasing">Prephasing</option>
</select>
<input type="submit" name="submit" value="Submit" class="button" />
</form>

<?php
$host = "127.0.0.1";
$userName = "project";
$password = "Mol#biol2";
$dbName = "nipt";
$conn = new mysqli($host,$userName,$password,$dbName) or die($mysqli->error);

if(isset($_POST['submit']))
{
   $search=$_POST['Boxplot_select'];
   $query_103 = "SELECT $search FROM quant_report JOIN sequencing_report
   ON quant_report.batch_name=sequencing_report.batch_name WHERE instrument='NL500103'";
   $query_111 = "SELECT $search FROM quant_report JOIN sequencing_report
   ON quant_report.batch_name=sequencing_report.batch_name WHERE instrument='NL500111'";

$result_103 = mysqli_query($conn,$query_103);

$data_103 = array();
foreach ($result_103 as $row_103) {
	$data_103[] = $row_103;
}


$json103 = json_encode($data_103, JSON_FORCE_OBJECT);
$result_111 = mysqli_query($conn,$query_111);

$data_111 = array();
foreach ($result_111 as $row_111) {
$data_111[] = $row_111;
} 
$json111 = json_encode($data_111, JSON_FORCE_OBJECT);
mysqli_close($conn);

}
?>

<script>
var data_103 = jQuery.parseJSON ('<?php echo $json103; ?>');
var search = "<?php echo $search ?>"
var data103 = [];



function countProps(obj) {
    var count = 0;
    for (var p in obj) {
      obj.hasOwnProperty(p) && count++;
    }
    return count; 
}

parseFloat(data_103[0].Q30)


var data_103counter = countProps(data_103) 
for (var i=0;i < data_103counter;i++)  { 
                data103.push(data_103[i][search]); 

    
					}
console.log(data103)

var data_111 = jQuery.parseJSON ('<?php echo $json111; ?>');
var search = "<?php echo $search ?>"
var data111 = [];



function countProps(obj) {
    var count = 0;
    for (var p in obj) {
      obj.hasOwnProperty(p) && count++;
    }
    return count; 
}

parseFloat(data_111[0].Q30)


var data_111counter = countProps(data_111) 
for (var i=0;i < data_111counter;i++)  { 
                data111.push(data_111[i][search]); 

    
					}
console.log(data111)

var NL100103 = {
  y: data103,
  type: 'box',
  name: 'NL100103'
};

var NL100111 = {
  y: data111,
  type: 'box',
  name: 'NL100111'
};

var data = [NL100103, NL100111];
console.log [NL100103]
</script>
<div id='myDiv'style="width:600px;height:800px;">
</div>
<script>Plotly.newPlot('myDiv', data);</script>
</body>
</html>