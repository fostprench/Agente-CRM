$(function()
{
	$("#excel_2003").click(function(){
		var idcaja = $("#_id_").val();
		var fecha = $("#_fecha_").val();
		window.open('index.php?controller=ReporteCaja_Excel&action=genera_reporte_excel&v=2003&id='+idcaja+'&fecha_='+fecha, '_blank');
	});
	
	$("#excel_2007").click(function(){
		var idcaja = $("#_id_").val();
		var fecha = $("#_fecha_").val();
		window.open('index.php?controller=ReporteCaja_Excel&action=genera_reporte_excel&v=2007&id='+idcaja+'&fecha_='+fecha, '_blank');
	});
		
});