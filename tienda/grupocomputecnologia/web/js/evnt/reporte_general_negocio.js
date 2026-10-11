$(function()
{
	 $("#reporte_general").click(function(){
		var   tipo = $("#tipo_reporte").val();
		var idcaja = $("#caja_aperturada").val();
		//alert("tipo:"+tipo+" idcaja:"+idcaja);//return false;
		window.open('index.php?controller=Reporte&action=reporte_general_negocio&id='+idcaja+'&tipo_r='+tipo, '_blank');
	});
	
});


