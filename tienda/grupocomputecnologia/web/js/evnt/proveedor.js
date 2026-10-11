$(function()
{  
	$("#descripcion").focus();
	$("#_form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
	
	$("#descripcion").keypress(function(e){
		if (e.which == 13) {
			$("#ruc").focus();
		}		
	});
	
	$("#ruc").keypress(function(e){
		if (e.which == 13) {
			$("#direccion").focus();
		}		
	});
	
	$("#direccion").keypress(function(e){
		if (e.which == 13) {
			$("#telefono").focus();
		}		
	});
	
	$("#telefono").keypress(function(e){
		if (e.which == 13) {
			$("#email").focus();
		}		
	});
	
	$("#email").keypress(function(e){
		if (e.which == 13) {
			$("#contacto").focus();
		}		
	});
	
	$("#contacto").keypress(function(e){
		if (e.which == 13) {
			$("#lugar").focus();
		}		
	});
	
	$("#lugar").keypress(function(e){
		if (e.which == 13) {
			$("#grabar").focus();
		}		
	});
	
	$("#grabar").click(function(){
		agregar();
	});
	
	$("#grabar").keypress(function(e){
		if (e.which == 13) {
			agregar();
		}		
	});
	
	function agregar()
	{            
		bval = true;
		
		  bval = bval && $( "#descripcion" ).required();
		  bval = bval && $( "#ruc" ).required();
	      bval = bval && $( "#telefono" ).required();
		  bval = bval && $( "#lugar" ).required();
		
		if ( bval ) 
		{
		  
			ver_msg(0,"..::Guardando::..")
			str = $("#_form").serialize();
			//alert(str);
			$.post('index.php','controller=Proveedores&action=save&'+str,function(data)
		    {
				//alert(data.msg);
				if(data.rep=="1")
			    {
					msg(1,'Datos grabados correctamente','controller=Proveedores');
				}
				if(data.rep=="2")
				{
					ver_msg(2,'Datos modificados correctamente');
				}
			},'json');
		}
        return false;
	};

	
	$("#cancel").click(function()
		{
		 $("#result").slideDown();
		  $("#res").slideUp();
		  document.getElementById("save").style.visibility="visible";
		});
		
	
});



function atras()
{
	paginacion('controller=Proveedores');
}
function imprimir()
{
	window.open("fpdf/reporte.php?tabla=Proveedores");
}