$(function()
{   
	$("#_form").submit(function()
	{            
		bval = true;
	    bval = bval && $( "#descripcion").required();
		if ( bval ) 
		{
			ver_msg(0,"..::Guardando::..");
			str = $(this).serialize();
			// alert(str);
			$.post('index.php','controller=Marca&action=save&'+str,function(data)
		    {
			//alert(data.str);
				if(data.rep=="1")
			    {
					msg(1,'Datos grabados correctamente','controller=Marca');
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
	paginacion('controller=Marca');
}
function imprimir()
{
	window.open("fpdf/reporte.php?tabla=Marca");
}