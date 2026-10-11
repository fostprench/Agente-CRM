$(function()
{

	$("#fecha_inicial").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true
	});
	
	$("#fecha_final").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true
	});
	
	$("#fecha_dia").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true
	});
	
	
	$("#reporte_soporte").click(function(){
		var idcaja = $("#caja_aperturada").val();
		window.open('index.php?controller=Reporte&action=soporte_pdf&id='+idcaja,'_blank');
	});
	
	$("#reporte_soporte_rango").click(function(){
		var fecha_i = $("#fecha_inicial").val();
		fecha_i = formato_fecha(fecha_i);
		var fecha_f = $("#fecha_final").val();
		fecha_f = formato_fecha(fecha_f);
		window.open('index.php?controller=Reporte&action=soporte_pdf_rango&fecha_inicio='+fecha_i+'&fecha_fin='+fecha_f,'_blank');
	});
	
	$("#reporte_soporte_hoy").click(function(){
		var fecha = $("#fecha_dia").val();
		fecha = formato_fecha(fecha);
		window.open('index.php?controller=Reporte&action=soporte_pdf_dia&fecha_d='+fecha, '_blank');
	});
});

function formato_fecha(fecha){
var array=fecha.split("-");
var fecha = array[2]+'-'+array[1]+'-'+array[0];
return fecha;
}

