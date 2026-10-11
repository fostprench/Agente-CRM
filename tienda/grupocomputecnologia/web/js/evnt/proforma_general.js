$(function()
{  

	$("#_form").submit(function()
	{ 
	    bval = true;
	    bval = bval && $( "#garantia").required();
	    bval = bval && $( "#cheque").required();
		bval = bval && $( "#entrega").required();
	    bval = bval && $( "#descripcion").required();
	    bval = bval && $( "#mensaje").required();
	    
		if ( bval ) 
		{
			
			ver_msg(0,"..::Guardando::..");			
			str = $(this).serialize();
			// alert(str); return false;
			
			$.post('index.php',str,function(data)
			{
					if(data.rep==1)
					{
						ver_msg(2,'Datos modificados correctamente');
					}
			},'json');

		}
		return false;
	});	
	
});


	


		
