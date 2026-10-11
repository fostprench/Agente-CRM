<script type="text/javascript">
    	$(function () {
			$('#xxx').highcharts({
				chart: {
					type: 'pie',
					options3d: {
						enabled: true,
						alpha: 45
					}
				},
				title:    <?php echo $title;?> ,
				subtitle: <?php echo $subtitle;?>  ,
				plotOptions: {
					pie: {
						innerSize: 100,
						depth: 45
					}
				},
				series: [ <?php echo $series;?> ]
			});
		});
</script>	

	
<div class="row" id="xxx" ></div>