<!DOCTYPE html>
<html>
<head>
<title>Creating Dynamic Data Graph using PHP and Chart.js</title>
<style type="text/css">


#chart-container {
	width: 100%;
	height: auto;
}
.header{
        font-size: 30px;
        padding: 40px;
        color: white;
        text-align: center;
        background: #016893;
        background-color: linear-gradient(top to bottom, #016893, #35a7cf);}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>


</head>
<div class="header">
<h1>NIPT Quality Control Module</h1>
</div>
<body>
	<div id="chart-container" style="position: relative; height:40vh; width:80vw">
		<canvas id="graphCanvas"></canvas>
	</div>

	<script>
		// $(document).ready(function () {
		// 	showGraph();
		// });


		function showGraph()
		{
			{
				$.post("db_connects/phasing_db_connect.php",
				function (data)
				{
					console.log(data);
					var batch_name = [];
					var phasing = [];
					var lower_limit = [0.004, 0.004, 0.004, 0.004, 0.004, 0.004, 0.004, 0.004, 0.004, 0.004, 0.004, 0.004, 0.004, 0.004]

					for (var i in data) {
						batch_name.push(data[i].batch_name);
						phasing.push(data[i].phasing);
					}
					console.log(batch_name)

					var chartdata = {
						labels: batch_name,
						datasets: [
							{
								label: 'phasing',
								//backgroundColor: '#49e2ff', (to fill the area under graph line)
								borderColor: '#46d5f1',
								hoverBackgroundColor: '#CCCCCC',
								hoverBorderColor: '#666666',
								data: phasing
							},
							{
								label: 'lower_limit',
								//backgroundColor: '#49e2ff', (to fill the area under graph line)
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
     // sensitivity: 0.1,
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