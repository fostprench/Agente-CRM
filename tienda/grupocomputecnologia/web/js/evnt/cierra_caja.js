$(function()
{  
$("#Aceptar").click(function(){

			ver_msg(0,"..::Cerrando Caja::..")
			id = $("#idcaja").val();
			fecha = $("#fecha").val();
			$.post('index.php','controller=Caja&action=cerrar_caja&idcaja='+id+'&fecha='+fecha,function(data)
		    {
			
			    //alert(data.msg);
				if(data.rep=="1")
			    {
					msg(1,data.msg,'controller=Caja'); closeWindow();
				}
			},'json');

}); 




});
