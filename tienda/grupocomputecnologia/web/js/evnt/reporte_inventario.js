$(function()
{
	$("#reporte_inventario").click(function(){
		var order = $("#order_by").val();
		if($("#contador").is(':checked')){
			contador = 1;
		}else{
			contador = 0;
		}
		window.open('index.php?controller=Reporte&action=inventario_pdf&order='+order+'&check='+contador, '_blank');
	});
});