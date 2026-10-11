$(function()
{
	$("#reporte_ventas_c").click(function(){
		var idcaja = $("#caja_aperturada").val(); 
		window.open('index.php?controller=Reporte&action=ventas_c_pdf&id='+idcaja, '_blank');
	});
	
	$("#reporte_ventas_xc").click(function(){
		window.open('index.php?controller=Reporte&action=ventas_xc_pdf&id='+1, '_blank');
	});
	
	$("#reporte_ventas_xc_All").click(function(){
		window.open('index.php?controller=Reporte&action=ventas_xc_pdf&id='+2, '_blank');
	});
	
	$("#reporte_ventas_margenbruto").click(function(){
		var idcaja_2 = $("#caja_aperturada_2").val();
		window.open('index.php?controller=Reporte&action=ventas_margenbruto_pdf&id='+idcaja_2, '_blank');
	});
});