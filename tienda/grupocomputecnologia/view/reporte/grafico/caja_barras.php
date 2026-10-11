<script type="text/javascript">
var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'xxx',
            type: 'column',
            options3d: {
                enabled: <?php echo $enabled;?>,
                alpha: 10,
                beta: -5,
                depth: 70,
                viewDistance: 25
            }
        },
        title:    <?php echo $title;?> ,
        subtitle: <?php echo $subtitle;?>  ,
		xAxis: 	<?php echo $xAxis;?> ,
		yAxis: {
            title: {
                text: 'Cantidad $/.'
            }
        },
		// legend: {
            // layout: 'vertical',
            // align: 'right',
            // verticalAlign: 'middle',
            // borderWidth: 1
        // },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        series: [ 
				<?php echo $series;?> , 
				<?php echo $combinacion;?> 
		]
    });

function showValues() {
        $('#alpha-value').html(chart.options.chart.options3d.alpha);
        $('#beta-value').html(chart.options.chart.options3d.beta);
        $('#depth-value').html(chart.options.chart.options3d.depth);
    }

    // Activate the sliders
    $('#sliders input').on('input change', function () {
        chart.options.chart.options3d[this.id] = this.value;
        showValues();
        chart.redraw(false);
    });

    showValues();

		</script>	

<div class="row" id="xxx" ></div>
<div id="sliders">
    <table>
        <tr>
        	<td>&Aacute;ngulo Alpha</td>
        	<td><input id="alpha" type="range" min="0" max="45" value="15"/> <span id="alpha-value" class="value"></span></td>
        </tr>
        <tr>
        	<td>&Aacute;ngulo Beta</td>
        	<td><input id="beta" type="range" min="-45" max="45" value="15"/> <span id="beta-value" class="value"></span></td>
        </tr>
        <tr>
        	<td>Profundidad</td>
        	<td><input id="depth" type="range" min="20" max="100" value="50"/> <span id="depth-value" class="value"></span></td>
        </tr>
    </table>
</div>