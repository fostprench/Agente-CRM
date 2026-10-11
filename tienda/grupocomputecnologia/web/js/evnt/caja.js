$(function()
{   
	$("#_form").submit(function()
	{            
		bval = true;
	    bval = bval && $( "#fecha_a").required();
	    bval = bval && $( "#monto_a").required();
	    bval = bval && $( "#usuario").required();
		if ( bval ) 
		{
			ver_msg(0,"..::Guardando::..");
			
			fecha = $("#fecha_a").val();
			fecha_a = formato_fecha(fecha);
			
			str = $(this).serialize();
			str = str+"&fecha_="+fecha_a;
			//alert(str);return false;
			$.post('index.php','controller=Caja&action=save&'+str,function(data)
		    {	
			//alert(data.msg);
				if(data.rep=="1")
			    {
					msg(1,'Datos grabados correctamente','controller=Caja');
				}
			},'json');
		}
        return false;
	});
	
	 $("#fecha_a").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true
	});
});

function formato_fecha(fecha){
var array=fecha.split("-");
var fecha = array[2]+'-'+array[1]+'-'+array[0];
return fecha;
}


function atras()
{
	paginacion('controller=Caja');
}
function imprimir()
{
	window.open("fpdf/reporte.php?tabla=Caja");
}