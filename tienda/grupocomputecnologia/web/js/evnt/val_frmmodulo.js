$(function()
{   

	$("#crear").change(function(){
		id = $(this).val();
		if(id==2){$("#modulo_padre").removeClass('hidden');$("#modulo_icono").addClass('hidden');}else{$("#modulo_padre").addClass('hidden');$("#modulo_icono").addClass('hidden');}
	});
	
	$("#_form").submit(function()
	{            
	    bval = true;
	    //bval = bval && $( "#idpadre" ).required();
	    bval = bval && $( "#descripcion" ).required();
        bval = bval && $( "#url" ).required();
        bval = bval && $( "#orden" ).required();
		
		 if ( bval ) 
		 {
		   ver_msg(0,"..::Guardando::..")
          str = $(this).serialize(); //alert(str);
                	$.post('index.php','controller=modulo&action=save&'+str,function(data)
		    {
	            
                        if(data.rep=="1")
			   {
				msg(1,'Datos grabados correctamente','controller=modulo');
			   }
			           if(data.rep=="2")
			   {
				ver_msg(2,'Datos modificados correctamente');
				
			   }
		   },'json');
		//return false; 
        }
        return false;
               
		
                
                
    });
});
	
function atras()
{
paginacion('controller=modulo');
}

function imprimir()
{
window.open("fpdf/reporte.php?tabla=modulos");
}