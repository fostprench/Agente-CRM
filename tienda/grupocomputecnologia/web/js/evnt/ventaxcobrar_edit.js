var item=0;
var quint = 0;
var xtotal=0;
$(function()
{  
	$.each($('.tr_p'), function() {
         item = (this.id );
	});
	
	$("#_form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
	
	$("#cant" ).keypress(function(e) {
			if (e.which == 13) {
				$("#precio").focus();
			}		
	});
	
	$("#precio" ).keypress(function(e) {
			if (e.which == 13) {
				$("#glosa").focus();
			}		
	});
	
$("#buscar_cli").click(function(){
$("#emergente").load("index.php?controller=Cliente&action=mostrar", function(){
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
		});
		
});

$("#buscar_serv").click(function(){
$("#emergente").load("index.php?controller=Orden_st&action=mostrar", function(){
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
		});
		
});

	function buscar_productos(opc){
		if(opc==1){var texto_2=""; }else{var texto_2 = $.trim($("#producto").val());}
	
		$.ajax({
					 url: "index.php",
					 type: 'GET',
					 data: "controller=Venta&action=mostrar_p&q="+texto_2, 
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


$("#tipo_c").change(function(){
id = $(this).val();
if(id=='1'){
	nro = 'B001-';
	$("#nro_comprobante").val(nro);
	$("#nro_comprobante").focus();
}else if(id=='2'){
	nro = 'F001';
	$("#nro_comprobante").val(nro);
	$("#nro_comprobante").focus();
}else{
	nro = 'S/C';
	$("#nro_comprobante").val(nro);
	$("#nro_comprobante").focus();
}
});


	$("#cant").keyup(function(){
		cant = $("#cant").val();
		stock = $("#stock").val();
		cant = parseInt(cant);
		stock = parseInt(stock);
		if(cant>stock){alert ('La cantidad de producto a vender supera el limite del stock');$("#cant").val('');}
	});

	// $("#producto").keyup(function(){
		// stock = $("#stock").val();
		// if(stock){$("#stock").val('');}
	// });


	 
	 function agregar_grilla(){
	 
		xtotal = $("#totalcompra").val();
		xtotal = parseFloat(xtotal);
		
		$.each($('.tr_p'), function() {
         item = (this.id );
         });
		 
		item = parseInt(item);
		
	    bval = true;
	    bval = bval && $( "#producto").required();
	    bval = bval && $( "#cant").required();
	    bval = bval && $( "#precio").required();

		if(bval)
		{
		  
		   id_prod=$( "#idproducto").val();
		   prod=$("#producto").val(); //
		   precio=$("#precio").val(); 
		   precio = parseFloat(precio).toFixed(2);

		   cant=$( "#cant").val(); // EL STOCK EL LA CANTIDAD 

		
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
				
				 item+=1;
				
				 $('#msg-parte').hide();
				 
				 var glosa=$("#glosa").val(); 
				   if(glosa==''){glosa = 'SERIE';}
				   
				   sub=precio*cant;
				   sub = parseFloat(sub).toFixed(2);
		           xtotal=parseFloat(xtotal).toFixed(2);
		           xtotal=(parseFloat(xtotal)+parseFloat(sub)).toFixed(2);
				   

				   
				   var str="<tr id='"+item+"' class='tr_p'>";
					   str+="<td>"+item+"<input name='codigo[]' id='codigo[]' value='"+id_prod+"' type='hidden'/><input name='codigo_orden[]' id='codigo_orden[]' value='0' type='hidden'/></td>";
					   str+="<td width='45%'>"+"<input name='producto[]' id='producto[]' value='"+prod+"' type='hidden' />"+prod+"</td>";
					   str+="<td width='17%'>"+"<input type='text' name='glosa[]' id='glosa[]' value='"+glosa+"' class='form-control input-sm'  /></td>";
					   str+="<td width='10%'>"+"<input name='canti[]' id='canti[]' value='"+cant+"' type='hidden' />"+cant+"</td>";
					   str+="<td width='10%'>"+"<input name='precios[]' id='precios[]' value='"+precio+"' type='hidden' />"+precio+"</td>";
					   str+="<td width='10%'>"+"<input name='sub[]' id='sub[]'value='"+sub+"'  type='hidden' />"+sub+"</td>";
					   str+="<td width='8%'><a class='btn btn-xs btn-danger' href='javascript:eliminar_p("+item+","+sub+",0,0);'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a> <a class='btn btn-xs btn-info' href='javascript:_ver(\"index.php?controller=Productos&action=show&id="+id_prod+"\");'> <span class='glyphicon glyphicon-zoom-in' aria-hidden='true'></span></a></td>";
					   var _dato= $(str);
					   
					   $("#detalle_producto").append(_dato);
					   $("#i").val(1);
					   $("#totalgeneral").empty().append(xtotal);
					   $("#total_igv").empty().append(xtotal);
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
	
	$("#agregarc").keypress(function(e){
		if (e.which == 13) {
			agregar_grilla();
		}		
	});
	
	$("#glosa").keypress(function(e){
		if (e.which == 13) {
			$("#agregarc").focus();	
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
	}).on('change',function(event){
		$("#cliente").focus();
	});
	
	$("#_form").submit(function()
	{ 
	    bval = true;
	    bval = bval && $( "#cliente").required();
	    bval = bval && $( "#tipo_c").required();
		bval = bval && $( "#nro_comprobante").required();
	    bval = bval && $( "#fecha").required();
	    
		if ( bval ) 
		{
		  if(document.getElementById('i').value==0)
			{
			  $('#msg-parte').show();
			}else
			{
			
			ver_msg(0,"..::Guardando::..");
			
			fecha = $("#fecha").val();
			fecha_ = formato_fecha(fecha);
			
			  str = $(this).serialize();
			  str = str+"&fecha_="+fecha_;
			    // alert(str);
				$.post('index.php','controller=VentasxCobrar&action=save&'+str,function(data)
				{
					//alert(data.msg);
					if(data.rep=="1")
					{
						msg(1,'Datos grabados correctamente','controller=VentasxCobrar');
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
	
		
	devolver_orden = function (idorden){
			
			xtotal = $("#totalcompra").val();
			xtotal = parseFloat(xtotal);
		
			$.each($('.tr_p'), function() {
			 item = (this.id );
			});
			 
			item = parseInt(item);
    
			 $.get("index.php","controller=Orden_st&action=orden_venta&id="+idorden,function(data)
			 {
				document.getElementById("idcliente").value=data.obj.idcliente;
				document.getElementById("cliente").value=data.obj.nombres;
				
				$.each(data.detalle, function(i,j){
					//console.log(data.detalle[i]);
							
							item+=1;
							var subdetalle = (parseFloat(data.detalle[i].cant) * parseFloat(data.detalle[i].precio_real)).toFixed(2);
							xtotal=parseFloat(xtotal).toFixed(2);
							xtotal=(parseFloat(xtotal)+parseFloat(subdetalle)).toFixed(2);
						   
							var codigo_tr = "";
								codigo_tr = item+"_"+data.detalle[i].idorden_st;
						   
							var str="<tr id='"+codigo_tr+"' class='tr_p'>";
							   str+="<td>"+item+"<input name='codigo[]' id='codigo[]' value='0' type='hidden'/><input name='codigo_orden[]' id='codigo_orden[]' value='"+data.detalle[i].idorden_st+"' type='hidden'/><input name='glosa[]' id='glosa[]' value='Soporte' type='hidden'/></td>";
							   str+="<td width='45%'>"+"<input name='producto[]' id='producto[]' value='"+data.detalle[i].descripcion+"' type='hidden' />"+data.detalle[i].descripcion+"</td>";
							   str+="<td width='17%'>-----------</td>";
							   str+="<td width='10%'>"+"<input name='canti[]' id='canti[]' value='"+data.detalle[i].cant+"' type='hidden' />"+data.detalle[i].cant+"</td>";
							   str+="<td width='10%'>"+"<input name='precios[]' id='precios[]' value='"+data.detalle[i].precio_real+"' type='hidden' />"+data.detalle[i].precio_real+"</td>";
							   str+="<td width='10%'>"+"<input name='sub[]' id='sub[]'value='"+subdetalle+"'  type='hidden' />"+subdetalle+"</td>";
							   str+="<td width='8%'><a class='servicio btn btn-xs btn-warning'  data="+item+" href='javascript:eliminar_servicio("+item+","+data.detalle[i].idorden_st+")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a> <a class='btn btn-xs btn-info' href='javascript:_ver(\"index.php?controller=Orden_st&action=show&id="+data.detalle[i].idorden_st+"\");'> <span class='glyphicon glyphicon-zoom-in' aria-hidden='true'></span></a> </td>";
							   var _dato= $(str);
							   
							   $("#detalle_producto").append(_dato);
							   $("#i").val(1);
							   $("#totalgeneral").empty().append(xtotal);
							   $("#total_igv").empty().append(xtotal);
							   $("#totalcompra").val(xtotal);
							   $("#totalcompra_igv").val(xtotal);
							   
					
					//document.write("<br>"+i+" - "+miJSON[i].valor+" - "+miJSON[i].color+" - "+miJSON[i].caracteristica.tipo+" - "+miJSON[i].caracteristica.ref);
				})
				
				//console.log(data.obj);
				//console.log(data.obj.usuario);
			 },'json');
			
			closeWindow();
	}
	
	
});


function formato_fecha(fecha){
var array=fecha.split("-");
var fecha = array[2]+'-'+array[1]+'-'+array[0];
return fecha;
}

function redondeo(numero){ 
	var flotante = parseFloat(numero);
	var resultado = Math.round(flotante*100)/100;
	return  parseFloat(resultado).toFixed(2);
}

function limpiar()
{
	document.getElementById("idproducto").value="";
	document.getElementById("producto").value="";
	document.getElementById("precio").value="";
	document.getElementById("cant").value="";
	document.getElementById("glosa").value="";
	$("#producto").focus();
}

// FALTA VER LOS ITEMS DEL DE LA FUNCION ELMIMNAR eliminar_p
function eliminar_p(id,sss,idvent,idprod)
{  

   total = document.getElementById("totalcompra").value;
   total   = parseFloat(total);

   xtotal=total-sss;
   xtotal = redondeo(xtotal);
   xtotal = parseFloat(xtotal).toFixed(2);

   document.getElementById("totalcompra").value=xtotal;
   
   $("#"+id).remove();
   
  $("#totalgeneral").html(xtotal);
  $("#total_igv").html(xtotal);

  var cont_item = 0;
    $.each($('.tr_p'), function() {
		cont_item++;
    });
	
   if(cont_item==0){$("#i").val(0);}
   if(id>=item){item--;}
  
  
	if(idvent>0){
		str = "idventa="+idvent+"&idproducto="+idprod;
		$.get('index.php','controller=VentasxCobrar&action=delete_item&'+str,function(data){
			alert(data.msg);
		},'json');
	}
  
  
}

function eliminar_servicio(id,idorden_st){

		var subtotal = 0; cont_i = 0;
		$(".servicio").each(function(indice,valor){
			_id = $(this).attr('data');
			codigo_eliminar = _id+"_"+idorden_st;
			if ($("#"+codigo_eliminar)[0]) {
				 sub = $("#"+codigo_eliminar).find("td:eq(5) :input").val(); 
				sub = parseFloat(sub);
				subtotal = subtotal + sub;
				$("#"+codigo_eliminar).remove();				
				cont_i++;
			}
		});
		
		total = document.getElementById("totalcompra").value;
		total   = parseFloat(total);
		xtotal=total-subtotal;
		xtotal = redondeo(xtotal);
		xtotal = parseFloat(xtotal).toFixed(2);
		document.getElementById("totalcompra").value=xtotal;
	   
	    $("#totalgeneral").html(xtotal);
	    $("#total_igv").html(xtotal);

	    var cont_item = 0;
		$.each($('.tr_p'), function() {
			cont_item++;
		});
		
	   if(cont_item==0){$("#i").val(0);}
	   if(id>=item){
			if(cont_i==1){item--;}else{ for(i=1;i<=cont_i;i++){item--;} }
		}
	   
		str = "idorden="+idorden_st;
		$.get('index.php','controller=Orden_st&action=delete_item_venta&'+str,function(data){
			console.log(data.msg);
		},'json');
	 
}

function eliminar_otro(id,sss,idvent,idprod)
{  

   total = document.getElementById("totalcompra").value;
   total   = parseFloat(total);

   xtotal=total-sss;
   xtotal = redondeo(xtotal);
   xtotal = parseFloat(xtotal).toFixed(2);

   document.getElementById("totalcompra").value=xtotal;
   
   $("#"+id).remove();
   
  $("#totalgeneral").html(xtotal);
  $("#total_igv").html(xtotal);

  var cont_item = 0;
    $.each($('.tr_p'), function() {
		cont_item++;
    });
	
   if(cont_item==0){$("#i").val(0);}
   if(id>=item){item--;}
   
}


function atras()
{
	paginacion('controller=VentasxCobrar');
}



	


		
