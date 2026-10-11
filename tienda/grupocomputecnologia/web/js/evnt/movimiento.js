$(function()
{   
	$("#_form").submit(function()
	{            
		bval = true;
		if($("#tipo_movimiento").val()==2){
			 bval = bval && $( "#idcontrolcaja").required();
		}
	    bval = bval && $( "#descripcion").required();
	    bval = bval && $( "#monto").required();
	    bval = bval && $( "#fecha").required();
		if ( bval ) 
		{
			ver_msg(0,"..::Guardando::..");
			
			fecha = $("#fecha").val();
			fecha_ = formato_fecha(fecha);
			
			str = $(this).serialize();
			str = str+"&fecha_="+fecha_;
			//alert(str);return false;
			$.post('index.php','controller=Movimiento&action=save&'+str,function(data)
		    {
			
			    //alert(data.msg);
				if(data.rep=="1")
			    {
					msg(1,'Datos grabados correctamente','controller=Movimiento');
				}
				if(data.rep=="2")
				{
					ver_msg(2,'Datos modificados correctamente');
				}
			},'json');
		}
        return false;
	});
	
	 $("#fecha").datepicker({
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
	paginacion('controller=Movimiento');
}
function imprimir()
{
	window.open("fpdf/reporte.php?tabla=Movimiento");
}