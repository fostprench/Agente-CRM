$(function()
{
	$("#liberar_comp").click(function(){
		var idvent = $("#_idventa").val();
		str = "idventa="+idvent;
		ver_msg(0,''); //return false; 
		$.get('index.php','controller=Ventasxpedir&action=actualizar_inventario&'+str,function(data){
			if(data.rep==1){
				ver_msg(2,data.msg);
				paginacion('controller=Ventasxpedir');
			}else{
				ver_msg(1,data.msg);
				console.log('No se pudo liberar comprobante, error interno al realizar arqueo de inventario');
			}
			
		},'json');
	});
	
		
});