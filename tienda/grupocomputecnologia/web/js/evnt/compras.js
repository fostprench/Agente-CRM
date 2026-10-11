      var item=0;
var quint = 0;
var xtotal=0;
var sub_s = 0;
var sub_d = 0;
var sub_producto=0;
$(function()
{  

	$("#_form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
	
	$("#nro_comprobante").keypress(function(e) {
		if (e.which == 13) {
			$("#proveedor").focus();
						
				nro_comp  = $("#nro_comprobante").val();
				$.get('index.php','controller=Compras&action=validar_comprobante&nro_comp='+nro_comp,function(data)
				{
					if(data.rep==1)
					{
						alert('Nro. de Comprobante ya Registrado'); $("#nro_comprobante").focus(); return false;
					}
				},'json');
				  
		}		
    });
	
	$("#tipocambio" ).keypress(function(e) {
			if (e.which == 13) {
				$("#producto").focus();
			}		
	});
	
	$("#sin_igv" ).keypress(function(e) {
			if (e.which == 13) {
				$("#cant").focus();
			}		
	});
	
	$("#con_igv" ).keypress(function(e) {
			if (e.which == 13) {
				$("#cant").focus();
			}		
	});

	$("#cant" ).keypress(function(e){
			if (e.which == 13) {
				$("#precio_v").focus();
			}		
	});
	
	$("#precio_v" ).keypress(function(e) {
			if (e.which == 13) {
				$("#glosa").focus();
			}		
	});

	$("#glosa").keypress(function(e){
			if (e.which == 13) {
				agregar_grilla();
			}		
	});
	
	
	function buscar_proveedores(opc){
				if(opc==1){var texto_1=""; }else{var texto_1 = $.trim($("#proveedor").val());}
				$.ajax({
					 url: "index.php",
					 type: 'GET',
					 data: "controller=Compras&action=mostrar_proveedor&q="+texto_1, 
					 success: function(data_return){ 
						$("#emergente").html(data_return); 
							$.blockUI({
							message: $("#emergente"),
							css:{
								top: '2%',
								width: '80%',
								height: 'auto',
								left: '10%'
							 },
							 onBlock: function() {
									$('#q').setCursorToTextEnd();
							}
						}); 
					 }
				  });
	}
	
	
	$("#buscar_pro").click(function(){ 	buscar_proveedores(1); });

	$("#proveedor").keypress(function(e) {
        if (e.which == 13) {
				buscar_proveedores(2);
        }
    });
	
	function buscar_productos(opc){
			if(opc==1){var texto_=""; }else{var texto_ = $.trim($("#producto").val());}
			
				$.ajax({
					 url: "index.php",
					 type: 'GET',
					 data: "controller=Compras&action=mostrar_producto&q="+texto_, 
					 success: function(data_return){ 
						$("#emergente").html(data_return); 
							$.blockUI({
							message: $("#emergente"),
							css:{
								top: '2%',
								width: '80%',
								height: 'auto',
								left: '10%'
							 },
							 onBlock: function() {
									$('#q').setCursorToTextEnd();
							}
						}); 
					 }
				  });
	}
	
	$("#buscar_producto").click(function(){ buscar_productos(1); });
	
	$("#producto").keypress(function(e) {
        if (e.which == 13) {
			buscar_productos(2);
		}
    });
	


$(".precio_radio").click(function(){
	$("#con_igv").val('').attr("disabled",true);
	$("#sin_igv").val('').removeAttr("disabled");
	$("#sin_igv").focus();
	$(".subtotal_sig").html("SUB - TOTAL $/. ");
	$(".total_sig").html("TOTAL $/. "); 
  
	var id_product = $("#idproducto").val();
	if(id_product){
		$.get('index.php','controller=Compras&action=devolver_costo&id='+id_product,function(data){
						$("#costo_ant_dolares").val('S/. '+data.rep);
						$("#costo_ant_soles").val('');
						$("#precio_v").val(data.venta);
		},'json');
	}else{
		console.log('NO HAY PRODUCTO');
	}
  
});

$(".igv_radio").click(function(){
  $("#sin_igv").val('').attr("disabled",true);
  $("#con_igv").val('').removeAttr("disabled");
  $("#con_igv").focus();
   $(".subtotal_sig").html("SUB - TOTAL S/. ");
  $(".total_sig").html("TOTAL S/. "); 
  
  var id_product = $("#idproducto").val();
	if(id_product){
		$.get('index.php','controller=Compras&action=devolver_costo&id='+id_product,function(data){
						$("#costo_ant_soles").val('S/. '+data.rep);
						$("#costo_ant_dolares").val('');
						$("#precio_v").val(data.venta);
		},'json');
	}else{
		console.log('NO HAY PRODUCTO');
	}
});

$("#chek_igv" ).click(function() {
	if($('#chek_igv').is(':checked')){ 
		 //alert('chekeado');
		 if($(".precio_radio").is(':checked')){ //esta checkeado el precio el dolares
			cant = $("#sin_igv").val(); 
			tipo = $("#tipocambio").val();
			igv = $("#igv").val(); 
			total = (cant*tipo)*((igv/100)+1) ;
			total = redondeo(total);
			$("#con_igv").val(total);
		 }else if($(".igv_radio").is(':checked')){//esta checkeado el precio en soles
			//alert('radio soles');
			igv = $("#igv").val(); 
			cant_soles = $("#con_igv").val(); 
			total = (cant_soles)*((igv/100)+1);
			total = redondeo(total);
			monto_txt = 'S/. '+total+' SOLES';
			$("#sin_igv").val(monto_txt);
		 }
	}else{
		//alert('deschekeado');
		 if($(".precio_radio").is(':checked')){//esta checkeado el precio el dolares
			cant = $("#sin_igv").val(); 
			tipo = $("#tipocambio").val();
			total = (cant*tipo);
			total = redondeo(total);
			$("#con_igv").val(total);
		 }else if($(".igv_radio").is(':checked')){//esta checkeado el precio en soles
			//alert('radio soles');
			cant_soles = $("#con_igv").val(); 
			cant_soles = redondeo(cant_soles);
			monto_txt = 'S/. '+cant_soles+' SOLES';
			$("#sin_igv").val(monto_txt);
		 }
	}
});

$("#_descuento" ).click(function() {
	
	if($('#_descuento').is(':checked')){ 
	
		var subtotal_compra = $("#totalcompra_igv").val(); //alert(total_compra);
		var descuento = $("#descuento").val(); 
		if(descuento==''){descuento=0;}
		var sum = subtotal_compra - descuento;
		total = redondeo(sum);
		$("#total_igv").html(total);
		$("#totalcompra_igv").val(total)

	}else{

				subtotal_compra = $("#totalcompra").val();
				
				if($('#_igv').is(':checked')){
					
					
					bval = true;
					bval = bval && $( "#igv_venta").required(); 
					if(bval){
						
						igv_venta = $("#igv_venta").val(); 
						total = subtotal_compra*((igv_venta/100)+1);
						total = redondeo(total);
						$("#total_igv").html(total);
						$("#totalcompra_igv").val(total);
						
					}else{return false;}
					
					
				}else{					
							total = redondeo(subtotal_compra);
							$("#total_igv").html(total);
							$("#totalcompra_igv").val(total);
				}
	 
	}
});

$("#sin_igv" ).focusout(function() {
	sin_igv = $("#sin_igv").val();
	tipo = $("#tipocambio").val();
	if($('#chek_igv').is(':checked')){
		igv_producto = $("#igv").val();
		total= sin_igv * tipo * ((igv_producto/100)+1);
	}else{
		total= sin_igv * tipo;
	}
	total = redondeo(total);
	$("#con_igv").val(total);
});

$("#con_igv" ).focusout(function() {
	con_igv = $("#con_igv").val();
	tipo = $("#tipocambio").val();
	
	if($('#chek_igv').is(':checked')){
		igv_producto = $("#igv").val();
		total= con_igv * ((igv_producto/100)+1);
	}else{
		total= con_igv;
	}
	total = redondeo(total);
	monto_txt = 'S/. '+total+' SOLES';
	$("#sin_igv").val(monto_txt);
});




$("#_igv" ).click(function() { 
		if($('#_igv').is(':checked')){
				
				bval = true;
				bval = bval && $( "#igv_venta").required(); 
				if(bval){
							totalcompra = $("#totalcompra").val(); 
							
							if($('#_descuento').is(':checked')){
									//alert('_igv checkeado descuento chekeado');
									var descuento = $("#descuento").val();  
									igv_venta = $("#igv_venta").val(); 
									total = totalcompra*((igv_venta/100)+1); // TOTAL COMPRA + IGV
									total = total - descuento;				 // DESCUENTO A LA COMPRA
									total = redondeo(total);
									$("#total_igv").html(total);
									$("#totalcompra_igv").val(total);
									
							}else{
								
									//alert('_igv checkeado descuento no chekeado'); 
									igv_venta = $("#igv_venta").val(); 
									total = totalcompra*((igv_venta/100)+1) ;
									total = redondeo(total);
									$("#total_igv").html(total);
									$("#totalcompra_igv").val(total);
							}
							
				}else{  return false;}
		}else{
				//alert('_igv des_checkeado ');
			totalcompra = $("#totalcompra").val(); 
			
			if($('#_descuento').is(':checked')){
				
				//alert('descuento activado');
				var descuento = $("#descuento").val(); 
				var total = totalcompra - descuento;
				total = redondeo(total);
				$("#total_igv").html(total);
				$("#totalcompra_igv").val(total);
				
				
			}else{
				
				total = redondeo(totalcompra);
				$("#total_igv").html(total);
				$("#totalcompra_igv").val(total);
				
			}
			
			
		}
});

$("#descuento").keyup(function(){

		if($('#_descuento').is(':checked')){
		
			dscto = $("#descuento").val();
			setTimeout("",10000);			
			if(dscto==""){$("#descuento").val(0);dscto=0;}
			dscto = parseInt(dscto);
			var totalcompra = $("#totalcompra").val();
			
			
			if($('#_igv').is(':checked')){
				igv_venta = $("#igv_venta").val(); 
				var total_ = parseFloat(totalcompra*((igv_venta/100)+1)).toFixed(2);
				var total_DSCTO = (parseFloat(total_-dscto)).toFixed(2);
				$("#total_igv").html(total_DSCTO);
				$("#totalcompra_igv").val(total_DSCTO);

			}else{
				var total_DSCTO = (parseFloat(totalcompra-dscto)).toFixed(2);
				$("#total_igv").html(total_DSCTO);
				$("#totalcompra_igv").val(total_DSCTO);
			}
			
			
			
			
		}else{
			dscto = $("#descuento").val();
			if(dscto==""){$("#descuento").val(0);dscto=0; return false;}
		}
		
});




	 function agregar_grilla(){
	 
	    bval = true;
	    bval = bval && $( "#producto").required();
	    bval = bval && $( "#sin_igv").required();
	    bval = bval && $( "#con_igv").required();
	    bval = bval && $( "#cant").required();
	    bval = bval && $( "#precio_v").required();

		if(bval)  
		{
		   id_prod=$( "#idproducto").val();
		   prod=$("#producto").val(); //
		   
		   
		   if($('#chek_igv').is(':checked')){				 
				if($('.precio_radio').is(':checked')){ 
					 var precio_s = $("#con_igv").val();
				}else if($('.igv_radio').is(':checked')){
					 var igv = $("#igv").val(); 
					 var cant_soles = $("#con_igv").val();						 
					 var precio_s = (cant_soles)*((igv/100)+1);
			    } 
				 
			}else{
				
				 var precio_s=$("#con_igv").val(); 
			}				   
				   	
		   var precio_s = redondeo(precio_s);
				   
		   if($('.precio_radio').is(':checked')){ 
		         precio=$("#sin_igv").val(); 
		    }else{
		        precio=$("#con_igv").val(); 
		   }
		   precio = parseFloat(precio).toFixed(4);
		   cant=$( "#cant").val(); // EL STOCK EL LA CANTIDAD 
		   precio_v = $("#precio_v").val(); //stock 
		   
		   band=true;
		   $(".tr_p").each(function(indice,valor){
                  id_pp = $(this).find("td:eq(0) :input").val();
				  if(id_pp==id_prod){
					band=false;limpiar();
					alert('Este producto  ya fue agregado');
					return false; 
					}
                });
				
				if(band){
				 
				 //	PARA DESCHEQUEAR IGV Y DESCUENTO Y EVITAR ERRORES DESPUES DE CHEQUEARLOS Y QUERER VOLVER AGREGRA PRODUCTOS ESTANDP CHECKEADOS
				 $("#_igv").prop("checked", "");
				 $("#_descuento").prop("checked", "");
				 
				 item+=1;
				 $('#msg-parte').hide();
				 
				 
				 
				   var glosa=$("#glosa").val(); 
				   if(glosa==''){glosa = 'SERIE';}
				   
				    
				
				   sub=precio*cant;
				   sub = parseFloat(sub).toFixed(2);
		           xtotal=parseFloat(xtotal).toFixed(2);
		           xtotal=(parseFloat(xtotal)+parseFloat(sub)).toFixed(2);;
				   

				   
				   var str="<tr id='"+item+"' class='tr_p'>";
					   str+="<td>"+item+"<input name='codigo[]' id='codigo[]' value='"+id_prod+"' type='hidden'/></td>";
					   str+="<td width='45%'>"+"<input name='producto[]' id='producto[]' value='"+prod+"' type='hidden' />"+prod+"</td>";
					   str+="<td width='20%'>"+"<input type='text' class='form-control input-sx' name='glosa[]' id='glosa[]' value='"+glosa+"' /></td>";
					   str+="<td width='10%'>"+"<input name='canti[]' id='canti[]' value='"+cant+"' type='hidden'/>"+cant+"</td>";
					   str+="<td width='10%'>"+"<input name='precios[]' id='precios[]' value='"+precio+"' type='hidden'/>"+"<input name='precio_c[]' id='precio_c[]' value='"+precio_s+"' type='hidden' /><input name='precio_v[]' id='precio_v[]' value='"+precio_v+"' type='hidden' />"+precio+"</td>";
					   str+="<td width='10%'>"+"<input name='sub[]' id='sub[]'value='"+sub+"'  type='hidden'/>"+sub+"</td>";
					   str+="<td width='5%'><a class='btn btn-xs btn-danger' href='javascript:eliminar_p("+item+","+sub+");' ><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
					   var _dato= $(str);
					   $("#detalle_producto").append(_dato);
					   $("#i").val(1);
					   $("#totalgeneral").html(xtotal);
					   $("#total_igv").html(xtotal);
					   $("#totalcompra").val(xtotal);
					   $("#totalcompra_igv").val(xtotal);

					   limpiar();
			   }
		   }
		   return false;
	 }
	 
	 $("#agregarc").click(function(){
	    agregar_grilla();
	 });
	 
	 
	 $("#fecha").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true
	}).on('change',function(event){
		$tipo = $("#tipocambio").val();
		$("#tipocambio").val($tipo).setCursorToTextEnd();
	});
	
	$("#_form").submit(function()
	{ 
		// alert('ok');
	    bval = true;
	    bval = bval && $( "#proveedor").required();
	    bval = bval && $( "#nro_comprobante").required();
	    bval = bval && $( "#fecha").required();
	    bval = bval && $( "#usuario").required();
	    
		if ( bval ) 
		{
		  if(document.getElementById('i').value==0)
			{
			  $('#msg-parte').show();
			}else
			{
				  
				
			  ver_msg(0,"..::Guardando::..")
			
			  fecha = $("#fecha").val();
			  fecha_ = formato_fecha(fecha);
			  
			  if($('.precio_radio').is(':checked')){ 
		         tipocompra=2; 
		      }else{
		        tipocompra=1; 
		      }
			  
			  str = $(this).serialize();
			  str = str+"&fecha_="+fecha_+"&tipocompra="+tipocompra;
			   //alert(str);return false;
				$.post('index.php','controller=Compras&action=save&'+str,function(data)
				{
					//alert(data.msg);
					if(data.rep=="1")
					{
						msg(1,'Datos grabados correctamente','controller=Compras');
					}
					if(data.rep=="2")
					{
						ver_msg(2,'Datos modificados correctamente');
					}
				  },'json');
			}
			
		}
		return false;
	});
});

function redondeo(numero){ 
	var flotante = parseFloat(numero);
	var resultado = Math.round(flotante*100)/100;
	return  parseFloat(resultado).toFixed(2);
}

function formato_fecha(fecha){
var array=fecha.split("-");
var fecha = array[2]+'-'+array[1]+'-'+array[0];
return fecha;
}

function limpiar()
{
	document.getElementById("idproducto").value="";
	document.getElementById("producto").value="";
	document.getElementById("precio_v").value="";
	document.getElementById("cant").value="";
	document.getElementById("sin_igv").value="";
	document.getElementById("con_igv").value="";
	document.getElementById("glosa").value="";
	document.getElementById("costo_ant_dolares").value="";
	document.getElementById("costo_ant_soles").value="";
	document.getElementById("stock_P").value="";
	$("#producto").focus();
	//$("#chek_igv").prop("checked", "");
}

function eliminar_p(id,sss)
{  

    total = document.getElementById("totalcompra").value;
    total   = parseFloat(total);

    xtotal=total-sss;
    xtotal = redondeo(xtotal);
    
	$("#"+id).remove();
	
    document.getElementById("totalgeneral").value=xtotal;
    document.getElementById("totalcompra").value=xtotal;
    document.getElementById("total_igv").value=xtotal;
    document.getElementById("totalcompra_igv").value=xtotal;

	$("#totalgeneral").html(xtotal);
	$("#total_igv").html(xtotal);
	
	var cont_item = 0;
    $.each($('.tr_p'), function() {
		cont_item++;
    });

    if(cont_item==0){$("#i").val(0);}
	if(id>=item){item--;}
	$("#_igv").prop("checked", "");
	$("#_descuento").prop("checked", "");
	  
}



function atras()
{
paginacion('controller=Compras');
}

