<!DOCTYPE html>
<html>
<head>
<title>Standard slope graph</title>
<style type="text/css">
BODY {
	width: 550PX;
}

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
<h1>Standard Slope graph</h1>
<body>
	<div id="chart-container" style="position: relative; height:40vh; width:80vw">
		<canvas id="graphCanvas"></canvas>
	</div>

	<script>

		function showGraph()
		{
			{
				$.post("db_connects/std_slope_db_connect.php",
				function (data)
				{
					console.log(data);
					var batch_name = [];
					var std_slope = [];
					var lower_limit = [0.95, 0.95, 0.95, 0.95, 0.95, 0.95, 0.95, 0.95, 0.95, 0.95, 0.95, 0.95, 0.95, 0.95]
					var upper_limit = [1.15, 1.15, 1.15, 1.15, 1.15, 1.15, 1.15, 1.15, 1.15, 1.15, 1.15, 1.15, 1.15, 1.15]
					for (var i in data) {
						batch_name.push(data[i].batch_name);
						std_slope.push(data[i].std_slope);
					}
					console.log(batch_name)

					var chartdata = {
						labels: batch_name,
						datasets: [
							{
								label: 'std_slope',
								borderColor: '#46d5f1',
								hoverBackgroundColor: '#CCCCCC',
								hoverBorderColor: '#666666',
								data: std_slope
							},
							{
								label: 'lower_limit',
								borderColor: '#ff0000',
								hoverBackgroundColor: '#ff0000',
								hoverBorderColor: '#666666',
								data: lower_limit
							},
							{
								label: 'upper_limit',
								borderColor: '#ff0000',
								hoverBackgroundColor: '#ff0000',
								hoverBorderColor: '#666666',
								data: upper_limit
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
          min: 0.90000,
		  max: 1.20,
		  stepSize: 0.02,
		  steps: 10
		  
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