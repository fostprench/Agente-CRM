$(function()
{
	$("#fecha_i").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true
	});
	
	$("#fecha_f").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true
	});
	
	$("#reporte_caja_mes").click(function(){
		var idcaja = $("#caja_aperturada").val();
		window.open('index.php?controller=Reporte&action=caja_apertura&id='+idcaja, '_blank');
	});
	
	$("#reporte_caja_rango").click(function(){
		var fecha_i = $("#fecha_i").val();
		fecha_i = formato_fecha(fecha_i);
		var fecha_f = $("#fecha_f").val();
		fecha_f = formato_fecha(fecha_f);
		window.open('index.php?controller=Reporte&action=caja_rango&fecha_inicio='+fecha_i+'&fecha_fin='+fecha_f, '_blank');
	});
	
	$("#reporte_hoy").click(function(){
		var fecha = $("#fecha_r").val();
		fecha = formato_fecha(fecha);
		window.open('index.php?controller=Reporte&action=caja_hoy&fecha='+fecha, '_blank');
	});
	
	$("#reporte_compras_rango_pdf").click(function(){
		// alert("	OK ");
		var fecha_i = $("#fecha_i").val();
		fecha_i = formato_fecha(fecha_i);
		var fecha_f = $("#fecha_f").val();
		fecha_f = formato_fecha(fecha_f);
		window.open('index.php?controller=Reporte&action=compras_pdf&fecha_inicio='+fecha_i+'&fecha_fin='+fecha_f, '_blank');	
	});
	
	$("#reporte_compras_rango_excel").click(function(){
		// alert("	OK ");
		var fecha_i = $("#fecha_i").val();
		fecha_i = formato_fecha(fecha_i);
		var fecha_f = $("#fecha_f").val();
		fecha_f = formato_fecha(fecha_f);
		window.open('index.php?controller=Reporte&action=compras_excel&fecha_inicio='+fecha_i+'&fecha_fin='+fecha_f, '_blank');	
	});

});


function formato_fecha(fecha){
var array=fecha.split("-");
var fecha = array[2]+'-'+array[1]+'-'+array[0];
return fecha;
}


