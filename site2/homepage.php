<!DOCTYPE html>
<html>
<head>
<link href="style.css" rel="stylesheet">
</head>
<body>

<div class="header">
<h1>NIPT Quality Control Module</h1>
</div>

<div class="btn-group"  style="width:230px; float: left">
<button class="button" style="vertical-align:middle" onclick="window.location.href = 'http://localhost/QC_module_overview.php';"><span>Quality control table</span></button>
<button class="button" style="vertical-align:middle"onclick="window.location.href = 'http://localhost/boxplot.php';"><span>Boxplot</span></button>
<button class="button" style="vertical-align:middle" onclick="window.location.href = 'http://localhost/lotnumber_summ.php';"><span>Lotnumbers</span></button>
<button class="button" style="vertical-align:middle"onclick="window.location.href = 'http://localhost/anomaly_summ.php';"><span>Anomaly positives summary</span></button>
</div>

<?php
 $host = "127.0.0.1";
 $userName = "project";
 $password = "Mol#biol2";
 $dbName = "nipt";
  try {
$con = new PDO("mysql:host=$host;dbname=$dbName", $userName, $password);
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = "SELECT quant_report.batch_name, quant_report.std_slope, quant_report.std_rsquared, sequencing_report.cluster_density,
  sequencing_report.Q30, sequencing_report.phasing, sequencing_report.prephasing FROM quant_report JOIN sequencing_report
  ON quant_report.batch_name=sequencing_report.batch_name ORDER BY batch_name DESC LIMIT 1";

  print "<table class='responsive-table' style='width: 500px; float:left; height:100px; margin:10px; margin-top:150px; margin-left: 150px'> ";
  print "<caption>Latest VeriSeq run</caption>";
  print "<col id='batch_name'/>";
  print "<col id='std_slope' />";
  print "<col id='std_rsquared' />";
  print "<col id='cluster_density' />";
  print "<col id='Q30' />";
  print "<col id='phasing' />";
  print "<col id='prephasing' />";
  $result = $con->query($query);
  //return only the first row (we only need field names)
  $row = $result->fetch(PDO::FETCH_ASSOC);
  print "<thead>";
  print " <tr> ";
  foreach ($row as $field => $value){
    $var = 'http://localhost/'.$field.'_Graph.php';
   print " <th class><a href=$var>$field</a></th> ";
   //print " <col id ='$field'/>";
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
  } 
  catch(PDOException $e) {
   echo 'ERROR: ' . $e->getMessage();
  } // end try
 
?>
<script>
const tren = document.querySelectorAll("tr")
const head = document.querySelectorAll("th")


const std_slope_head = head[1].outerText
const std_rsquared_head = head[2].outerText
const cluster_density_head = head[3].outerText
const Q30_head = head[4].outerText
const phasing_head = head[5].outerText
const prephasing_head = head[6].outerText
console.log(std_slope_head)


for (var i=1;i < tren.length;i++ )
    {
    console.log(i)
    const std_slope = tren[i].children[1].outerText
    const std_rsquared = tren[i].children[2].outerText
    const cluster_density= tren[i].children[3].outerText
    const Q30 = tren[i].children[4].outerText
    const phasing = tren[i].children[5].outerText
    const prephasing = tren[i].children[6].outerText

 std_slope_fl = parseFloat(std_slope)
 std_rsquared_fl = parseFloat(std_rsquared)
 cluster_density_fl = parseFloat(cluster_density)
 Q30_fl = parseFloat(Q30)
 phasing_fl = parseFloat(phasing)
 prephasing_fl = parseFloat(prephasing)
 console.log(std_slope_fl)

    if (std_slope_fl < 0.95   || std_slope_fl > 1.15) {
      console.log("stdslope")
      tren[i].children[1].className += 'vPoor';
    }
    
    if (0.980 > std_rsquared_fl) {
        console.log("stdrsq") 
        tren[i].children[2].className += 'vPoor';
    }
     if (152000 > cluster_density || cluster_density_fl > 338000) {
        console.log("cluster") 
        tren[i].children[3].className += 'vPoor';
    }
    
     if (80 > Q30_fl) {
        console.log("q30") 
        tren[i].children[4].className += 'vPoor';
    }
     if (0.004 < phasing_fl) {
        console.log("phas") 
        tren[i].children[5].className += 'vPoor';
    }
     if (0.003 < prephasing) {
        console.log("pre") 
        tren[i].children[6].className += 'vPoor';
    }
  
}

</script>
</body>
</html>