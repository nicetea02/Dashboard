<!DOCTYPE html>
<html>
<head>
<title>Prephasing score graph</title>
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
<h1>Prephasing graph</h1>
</div>
<body>
	<div id="chart-container" style="position: relative; height:40vh; width:80vw">
		<canvas id="graphCanvas"></canvas>
	</div>

	<script>


		function showGraph()
		{
			{
				$.post("db_connects/prephasing_db_connect.php",
				function (data)
				{
					console.log(data);
					var batch_name = [];
					var prephasing = [];
					var lower_limit = [0.003, 0.003, 0.003, 0.003, 0.003, 0.003, 0.003, 0.003, 0.003, 0.003, 0.003, 0.003, 0.003, 0.003]

					for (var i in data) {
						batch_name.push(data[i].batch_name);
						prephasing.push(data[i].prephasing);
					}
					console.log(batch_name)

					var chartdata = {
						labels: batch_name,
						datasets: [
							{
								label: 'prephasing',
								borderColor: '#46d5f1',
								hoverBackgroundColor: '#CCCCCC',
								hoverBorderColor: '#666666',
								data: prephasing
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
          min: 0,
		  max: 0.007,
		  stepSize: 0.001,
		  steps: 10
		  
        },
	  }],
	},
    pan: {
      enabled: true,
      mode: "x",
      speed: 10,
      threshold: 10
    },
    zoom: {
      enabled: true,
      drag: false,
      mode: "xy",
     speed: 0.5,
      limits: {
        max: 10,
        min: 0.5
      }
    }
  }
});
				})
	}
}
		showGraph();
</script>

</body>
</html>