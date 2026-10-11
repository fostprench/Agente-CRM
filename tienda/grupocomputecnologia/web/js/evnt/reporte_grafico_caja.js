$(function()
{	
	$("#grafico_caja_b").click(function(){
		var idreporte = $("#nro_reporte").val();
		var carga = load_img();
		$("#load_graphic").html(carga);
		$.post('index.php','controller=Reporte_Grafico&action=grafic_barras&id='+idreporte,function(data){
				$("#load_graphic").html(data);
		});
	});
	
	$("#grafico_caja_t").click(function(){
		var idreporte = $("#nro_reporte").val();
		var carga = load_img();
		$("#load_graphic").html(carga);
		$.post('index.php','controller=Reporte_Grafico&action=grafic_torta&id='+idreporte,function(data){
				$("#load_graphic").html(data);
		});
	});
	
	$("#grafico_caja_d").click(function(){
		var idreporte = $("#nro_reporte").val();
		var carga = load_img();
		$("#load_graphic").html(carga);
		$.post('index.php','controller=Reporte_Grafico&action=grafic_donus&id='+idreporte,function(data){
				$("#load_graphic").html(data);
		});
	});
	
});