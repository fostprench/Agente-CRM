$(function()
{   
	$("#_form").submit(function()
	{            
		bval = true;
	    bval = bval && $("#idmarca").required();
	    bval = bval && $("#descripcion").required();
		if ( bval ) 
		{
			ver_msg(0,"..::Guardando::..")
			str = $(this).serialize();
			//alert(str); 
			$.post('index.php','controller=Modelo&action=save&'+str,function(data)
		    {
                 //alert(data.msg);      	
                if(data.rep=="1")
			    {
					msg(1,'Datos grabados correctamente','controller=Modelo');
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
	paginacion('controller=Modelo');
}
function imprimir()
{
	window.open("fpdf/reporte.php?tabla=Modelo");
}