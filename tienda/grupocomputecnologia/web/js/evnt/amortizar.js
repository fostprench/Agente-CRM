$(function()
{  
	$("#monto_amortizacion").focus();	
	
	$("#monto_amortizacion").keypress(function(e) {
        if (e.which == 13) {
            $("#operacion").focus();
        }
    });
	
	$("#operacion").keypress(function(e) {
        if (e.which == 13) {
            $("#observaciones").focus();
        }
    });
	
	$("#observaciones").keypress(function(e){
        if (e.which == 13){
            $("#monto_amortizar").focus();
        }
    });
	
	
	var c = 0;
	$("#monto_amortizar").click(function(){
		if(c==0){
			guardar();
			$('#monto_amortizar').hide();
			$('#btnOculto').show();
			c++;
		}		
	});
	
	function guardar(){
				bval = true;
	    bval = bval && $( "#monto_amortizacion").required();
	    bval = bval && $( "#fecha").required();
	    bval = bval && $( "#comprobante").required();
	    bval = bval && $( "#cliente").required();
	    bval = bval && $( "#descripcion").required();
		if(bval){
			$i = $("#i").val();
			if($i==0){$("#detalle_producto").empty();}
			monto_comprobante=$("#monto_comprobante").val();
			monto=$("#monto_amortizacion").val();
			monto=parseFloat(monto);
			deuda=$("#deuda").val();
			deuda=parseFloat(deuda);
			if(monto>deuda){
			alert("El monto de amortizacion no puede ser mayor a la deuda"); $("#monto_amortizacion").focus();return false;
			}
			//document.getElementById('msg-parte').style.display = 'block';
			$('#msg-parte').show();
			fecha=$("#fecha").val(); 
			fecha_ = formato_fecha(fecha);
			idventa = $("#idventa").val();
			idusuario = $("#idusuario").val();
			descripcion = $("#descripcion").val();
			operacion = $("#operacion").val();
			observaciones = $("#observaciones").val();
			tipo = $("#tipo_amortizacion").val();
			user = $("#user").val();
			str = "deuda="+deuda+"&descripcion="+descripcion+"&operacion="+operacion+"&observaciones="+observaciones+"&idusuario="+idusuario+"&monto="+monto+"&fecha_="+fecha_+"&idventa="+idventa+"&tipo_amortizacion="+tipo;
			
			if($i>0){
				$(".tr_p").each(function(indice,valor){
					  item = $(this).find("td:eq(0) :input").val();
					  if(item=="undefined"){item=1;}
					  else{item++;}
				});
			}else{var item=1;}
			//alert(str); return false;
			$.post('index.php','controller=Amortizar&action=save&'+str,function(data)
				{
					//alert(data.rep);
					if(data.rep=="1")
					{
						$('#monto_amortizar').show();
						$('#btnOculto').hide();
						c = 0;
						total_txt =  $("#txt_total").text();
						total_txt = parseFloat(total_txt);
						total_txt = (parseFloat(total_txt)+parseFloat(monto)).toFixed(2);
						nueva_deuda = (parseFloat(monto_comprobante)-parseFloat(total_txt)).toFixed(2);
						//alert("total_txt="+total_txt+"  ---- nueva_deuda="+nueva_deuda);
						//document.getElementById('msg-parte').style.display = 'none';
						$('#msg-parte').hide();
					   var grilla_="<tr id='"+item+"' class='tr_p'>";
					   grilla_+="<td><input type='hidden' value='"+item+"'>"+item+"</td>";
					   grilla_+="<td>"+fecha_+"</td>";
					   grilla_+="<td>"+user+"</td>";
					   grilla_+="<td>"+parseFloat(monto).toFixed(2)+"</td>";
					   grilla_+="<td><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button> <a href='javascript:popup(\"index.php?controller=Amortizar&action=_prinft&idm="+data.idmov+"\",850,500)' title='Imprimir Recibo'> <button type='button' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-print' aria-hidden='true'> </span> </button> </a> </td>";
		
					    $("#total_amortizaciones").val(total_txt);
						$("#deuda").val(nueva_deuda);
					    $("#detalle_producto").append(grilla_);
						$("#txt_total").text(total_txt);
						$("#monto_amortizacion").val('');
						$i++;
						$("#i").val($i);
					}else{
						ver_msg(2,'ERROR: '+data.msg);
					}
			},'json');
		}
	}
	

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


// FALTA VER LOS ITEMS DEL DE LA FUNCION ELMIMNAR eliminar_p
function eliminar_p(id,idprod,idvent,monto_amort)
{  
	$("#eliminado_"+idprod).fadeOut("slow");
	document.getElementById("eliminado_"+idprod).style.color='#3a57a8';
	$("#eliminado_"+idprod).html("::ELIMINANDO::");
	$("#eliminado_"+idprod).fadeIn("slow").fadeOut("slow").fadeIn("slow");
	$i = $("#i").val();
	str = "idventa="+idvent+"&idmovimiento="+idprod;
	$.get('index.php','controller=Amortizar&action=delete_item&'+str,function(data){
		if(data.rep==1){
			$("#eliminado_"+idprod).html(data.msg);
			$i--; $("#i").val($i);
			$("#fila_"+id).fadeOut(3000);
			//RESTAS PARA NIVELAR MONTOS EN EL RESTO DEL FORMULARIO
			txt_total =  $("#txt_total").text();
			txt_total = parseFloat(txt_total);
			txt_total = (parseFloat(txt_total)-parseFloat(monto_amort)).toFixed(2);
			$("#txt_total").text(txt_total);
			$("#total_amortizaciones").val(txt_total);
			nueva_deuda=$("#deuda").val();
			nueva_deuda = (parseFloat(nueva_deuda)+parseFloat(monto_amort)).toFixed(2);
			$("#deuda").val(nueva_deuda);
		}else{
			$("#eliminado_"+idprod).html(data.msg);
			alert(data.error);
			console.log(data.error);
		}
		
	},'json');
	 
}

function formato_fecha(fecha){
var array=fecha.split("-");
var fecha = array[2]+'-'+array[1]+'-'+array[0];
return fecha;
}

