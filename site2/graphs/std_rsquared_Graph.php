<!DOCTYPE html>
<html>
<head>
<title>R² graph</title>
<style type="text/css">


#chart-container {
	width: 100%;
	height: auto;
}
.header{
        font-size: 30px;
        padding: 60px;
        color: white;
        text-align: center;
        background: #016893;
        background-color: linear-gradient(top to bottom, #016893, #35a7cf);}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>


</head>
<div class="header">
<h1>Std R² graph</h1>
</div>
<body>
	<div id="chart-container" style="position: relative; height:40vh; width:80vw">
		<canvas id="graphCanvas"></canvas>
	</div>

	<script>

		function showGraph()
		{
			{
				$.post("db_connects/std_rsquared_db_connect.php",
				function (data)
				{
					console.log(data);
					var batch_name = [];
					var std_rsquared = [];
					var lower_limit = [0.98, 0.98, 0.98, 0.98, 0.98, 0.98, 0.98, 0.98, 0.98, 0.98, 0.98, 0.98, 0.98, 0.98]

					for (var i in data) {
						batch_name.push(data[i].batch_name);
						std_rsquared.push(data[i].std_rsquared);
					}
					console.log(batch_name)

					var chartdata = {
						labels: batch_name,
						datasets: [
							{
								label: 'std_rsquared',
								borderColor: '#46d5f1',
								hoverBackgroundColor: '#CCCCCC',
								hoverBorderColor: '#666666',
								data: std_rsquared
							},
							{
								label: 'lower_limit',
								borderColor: '#ff0000',
								hoverBackgroundColor: '#ff0000',
								hoverBorderColor: '#666666',
								data: lower_limit
							}
						],
						
		}

					var graphTarget = $("#graphCanvas");

					var barGraph = new Chart(graphTarget, {
						type: 'line',
						data: chartdata,
						options: {
    responsive: true,
    legend: {
      display: true,
    },
    scales: {
      yAxes: [{
        ticks: {
          min: 0.97500,
		  max: 1.01,
		  stepSize: 0.01,
		  steps: 20
		  
        },
      }],
    }

					}});
				})
	}
}
		showGraph();
</script>

</body>
</html>