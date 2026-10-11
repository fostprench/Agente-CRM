$(function()
{ 
	
	$("#monto" ).keypress(function(e) {
			if (e.which == 13) {
				$("#fecha").focus();
			}		
	});
	
	$("#fecha" ).keypress(function(e) {
			if (e.which == 13) {
				$("#referencia").focus();
			}		
	});
	
	$("#referencia" ).keypress(function(e) {
			if (e.which == 13) {
				$("#observacion").focus();
			}		
	});
	
	$("#observacion" ).keypress(function(e) {
			if (e.which == 13) {
				guardar_cuentas();
			}		
	});
	
	$("#idcuentas_bancarias").change(function(){
		id = $(this).val();
		$.post('index.php','controller=MovimientoCuentasBancarias&action=saldo_cuenta&idbanco='+id,function(data)
		    {
				$("#monto_banco").val(data.monto);
			},'json');
	});
	
	
	
	function actualizar_saldo(){
		idbanco = $("#idcuentas_bancarias").val();
		  if(idbanco==''){alert('Seleccione Cuenta Bancaria');return false;}
		  monto = $("#monto_banco").val();
		  if(monto==''){$("#monto_banco").val(0); return false;}
		  $.post('index.php','controller=MovimientoCuentasBancarias&action=Updatesaldo_cuenta&idbanco='+idbanco+'&monto='+monto,function(data)
		    {
				$("#msg_saldo").fadeOut();
				$("#msg_saldo").html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '+data.mensaje);
				$("#msg_saldo").fadeIn( "slow");
				$("#msg_saldo").fadeOut();
				$("#msg_saldo").fadeIn( "slow");
				$("#msg_saldo").fadeOut();
			},'json');
	}
	
	$("#act_saldo").click(function()
	{  
		actualizar_saldo();
	});
	
	$("#monto_banco").keypress(function(e) {
			if (e.which == 13) {
				actualizar_saldo();
			}		
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

	
	function guardar_cuentas(){
		bval = true;
	    bval = bval && $("#idmotivo_movimiento").required();
	    bval = bval && $("#tipo_ingreso").required();
	    bval = bval && $("#monto").required();
	    bval = bval && $("#fecha").required();
		if ( bval ) 
		{
			ver_msg(0,"..::Guardando::..");
			fecha = $("#fecha").val();
			fecha_ = formato_fecha(fecha);
			
			str = $("#_form").serialize();
			str = str+"&fecha_="+fecha_;
			
			$.post('index.php','controller=MovimientoCuentasBancarias&action=save&'+str,function(data)
		    {
				if(data.rep=="1")
			    {
					msg(1,'Datos grabados correctamente','controller=MovimientoCuentasBancarias');
				}
				if(data.rep=="2")
				{
					ver_msg(2,'Datos modificados correctamente');
				}
			},'json');
		}
        return false;
	}

function atras()
{
	paginacion('controller=MovimientoCuentasBancarias');
}
function imprimir()
{
	window.open("fpdf/reporte.php?tabla=Marca");
}

function formato_fecha(fecha){
var array=fecha.split("-");
var fecha = array[2]+'-'+array[1]+'-'+array[0];
return fecha;
}