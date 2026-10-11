$(function()
{   
	$("#_form").submit(function()
	{            
		bval = true;
	    bval = bval && $( "#producto").required();
	    bval = bval && $( "#stock").required();
	    bval = bval && $( "#precio_c").required();
	    bval = bval && $( "#precio_v").required();
		if ( bval ) 
		{
			ver_msg(0,"..::Guardando::..")
			str = $(this).serialize();
			
			$.post('index.php','controller=Inventario&action=save&'+str,function(data)
		    {
			
			//alert(data.msg);
				if(data.rep=="1")
			    {
					msg(1,'Datos grabados correctamente','controller=Inventario');
				}
				if(data.rep=="2")
				{
					ver_msg(2,'Datos modificados correctamente');
				}
			},'json');
		}
        return false;
	});
});


function atras()
{
	paginacion('controller=Inventario');
}
function imprimir()
{
	window.open("fpdf/reporte.php?tabla=Inventario");
}