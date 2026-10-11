$(function()
{   
	$("#_form").submit(function()
	{            
		bval = true;
	    bval = bval && $( "#cuenta").required();
	    bval = bval && $( "#descripcion").required();
		if ( bval ) 
		{
			ver_msg(0,"..::Guardando::..")
			str = $(this).serialize();
			
			$.post('index.php','controller=Concepto&action=save&'+str,function(data)
		    {
			
			//alert(data.msg);
				if(data.rep=="1")
			    {
					msg(1,'Datos grabados correctamente','controller=Concepto');
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
	paginacion('controller=Concepto');
}
function imprimir()
{
	window.open("fpdf/reporte.php?tabla=Concepto");
}