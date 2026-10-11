<script type="text/javascript">
var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'xxx',
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 15,
                depth: 50,
                viewDistance: 25
            }
        },
        title:    <?php echo $title;?> ,
        subtitle: <?php echo $subtitle;?>  ,
        plotOptions: {
             pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [ <?php echo $series;?> ]
    });



		</script>	

	
	<div class="row" id="xxx" ></div>