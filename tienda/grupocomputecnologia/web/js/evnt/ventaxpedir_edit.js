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
						$('#q').focus();
				}
			}); 
		});
		
});
	

	function buscar_productos(opc){
		if(opc==1){var texto_2=""; }else{var texto_2 = $.trim($("#producto").val());}
	
		$.ajax({
					 url: "index.php",
					 type: 'GET',
					 data: "controller=Venta&action=mostrar_p_total&q="+texto_2, 
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
									$('#q').focus();
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

		
	$("#buscar_prof").click(function(){
	$("#emergente").load("index.php?controller=Proformas&action=mostrar", function(){
	$.blockUI({
					message: $("#emergente"),
					css:{
						top: '2%',
						width: '80%',
						height: 'auto',
						left: '10%'
					 },
					 onBlock: function() {
							$('#q').focus();
					}
				}); 
			});
			
	});

	arqueo_obsequios = function(monto_obsequios){
			
			$(".tr_proforma").each(function(indice,valor){
				
					if(indice==1){
						
					  canti_ = $(this).find("td:eq(3) :input").val();
					  precio_ = $(this).find("td:eq(4) :input").val();
					  
					  nuevo_precio = (parseFloat(precio_)+parseFloat(monto_obsequios)).toFixed(2);
					  nuevo_importe = (parseFloat(canti_)*parseFloat(nuevo_precio)).toFixed(2);
					  
					  var html_precio="<input name='precios[]' id='precios[]' value='"+nuevo_precio+"' type='hidden'> "+nuevo_precio+"";
					  var html_importe="<input name='sub[]' id='sub[]' value='"+nuevo_importe+"' type='hidden'> "+nuevo_importe+"";
					  
					  $(this).find("td:eq(4)").html(html_precio);
					  $(this).find("td:eq(5)").html(html_importe);
					  
					}
			});
			
		}



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


	// $("#cant").keyup(function(){
		// cant = $("#cant").val();
		// stock = $("#stock").val();
		// cant = parseInt(cant);
		// stock = parseInt(stock);
		// if(cant>stock){alert ('La cantidad de producto a vender supera el limite del stock');$("#cant").val('');}
	// });

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
				   if(glosa==''){glosa = 'Serie';}
				   
				   sub=precio*cant;
				   sub = parseFloat(sub).toFixed(2);
		           xtotal=parseFloat(xtotal).toFixed(2);
		           xtotal=(parseFloat(xtotal)+parseFloat(sub)).toFixed(2);
				   

				   
				   var str="<tr id='"+item+"' class='tr_p'>";
					   str+="<td>"+item+"<input name='codigo[]' id='codigo[]' value='"+id_prod+"' type='hidden'/><input name='glosa[]' id='glosa[]' value='"+glosa+"' type='hidden'/></td>";
					   str+="<td width='45%'>"+"<input name='producto[]' id='producto[]' value='"+prod+"' type='hidden' />"+prod+"</td>";
					   str+="<td width='17%'><input name='glosa[]' id='glosa[]' value='SERIE' type='text' class='form-control input-sm'/></td>";
					   str+="<td width='10%'>"+"<input name='canti[]' id='canti[]' value='"+cant+"' type='hidden' />"+cant+"</td>";
					   str+="<td width='10%'>"+"<input name='precios[]' id='precios[]' value='"+precio+"' type='hidden' />"+precio+"</td>";
					   str+="<td width='10%'>"+"<input name='sub[]' id='sub[]'value='"+sub+"'  type='hidden' />"+sub+"</td>";
					   str+="<td width='8%'><a class='btn btn-xs btn-danger' href='javascript:eliminar_p("+item+","+sub+",0,0);'><span class='glyphicon glyphicon-remove'></span></a> <a class='btn btn-xs btn-info' href='javascript:_ver(\"index.php?controller=Productos&action=show&id="+id_prod+"\");'> <span class='glyphicon glyphicon-zoom-in'></span></a></td>";
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
	
	$("#precio").keypress(function(e){
		if (e.which == 13) {
			$("#agregarc").focus();
		}		
	});
	
	$("#agregarc").keypress(function(e){
		if (e.which == 13) {
			agregar_grilla();
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
			    //alert(str);
				$.post('index.php','controller=Ventasxpedir&action=save&'+str,function(data)
				{
					//alert(data.msg);
					if(data.rep=="1")
					{
						msg(1,'Datos grabados correctamente','controller=Ventasxpedir');
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
	
devolver_proforma = function (idproforma){
			
			closeWindow();
			
			 $.get("index.php","controller=Proformas&action=devolver_proforma&id="+idproforma,function(data)
			 {
				document.getElementById("idcliente").value=data.cliente.idcliente;
				document.getElementById("cliente").value=data.cliente.nombres;

				let porcentajeGanancia = data.porcentajeGanancia;
				
				$.each(data.detalle_proforma, function(i,j){
							
							item+=1;
							// xtotal=parseFloat(xtotal).toFixed(2);
							// xtotal=(parseFloat(xtotal)+parseFloat(data.detalle_proforma[i].monto)).toFixed(2);
						   

						    var codigo_tr = "";
								codigo_tr = item+"_"+data.detalle_proforma[i].idproducto;
							
							var str="<tr id='"+codigo_tr+"' class='tr_proforma'>";
							
							    str+="<td>"+item+"<input name='codigo[]' id='codigo[]' value='"+data.detalle_proforma[i].idproducto+"' type='hidden'/><input name='codigo_orden[]' id='codigo_orden[]' value='0' type='hidden'/></td>";
								
							   str+="<td width='45%'>"+"<input name='producto[]' id='producto[]' value='"+data.detalle_proforma[i].descripcion+"' type='hidden' />"+data.detalle_proforma[i].descripcion+"</td>";
							   
							   str+="<td width='17%'>"+"<input type='text' name='glosa[]' id='glosa[]' value='SERIE' class='form-control input-sm'/></td>";
							   
							   str+="<td width='10%'>"+"<input name='canti[]' id='canti[]' value='"+data.detalle_proforma[i].cantidad+"' type='hidden' />"+data.detalle_proforma[i].cantidad+"</td>";
							   
							    var precioProducto = parseFloat(data.detalle_proforma[i].monto / data.detalle_proforma[i].cantidad * (1 + porcentajeGanancia/100)).toFixed(2);

							   str+="<td width='10%'>"+"<input name='precios[]' id='precios[]' value='"+precioProducto+"' type='hidden' />"+precioProducto+"</td>";

							   var sub_prof = data.detalle_proforma[i].monto * (1 + porcentajeGanancia/100);							    
							   sub_prof = redondeo(sub_prof);
							   
							   str+="<td width='10%'>"+"<input name='sub[]' id='sub[]'value='"+sub_prof+"'  type='hidden' />"+sub_prof+"</td>";
							   
							   str+="<td width='8%'><a class='servicio btn btn-xs btn-warning'  data="+item+" href='javascript:eliminar_servicio("+item+","+data.detalle_proforma[i].idproducto+")'><span class='glyphicon glyphicon-remove' ></span></a>  <a class='btn btn-xs btn-info' href='javascript:_ver(\"index.php?controller=Productos&action=show&id="+data.detalle_proforma[i].idproducto+"\");'> <span class='glyphicon glyphicon-zoom-in' ></span></a></td>";
							   var _dato= $(str);
							   
							   $("#detalle_producto").append(_dato);
							   $("#i").val(1); 

							   xtotal=(parseFloat(xtotal)+parseFloat(sub_prof)).toFixed(2);
							   
				});

				$("#totalgeneral").empty().append(xtotal);
			    $("#total_igv").empty().append(xtotal);
			    $("#totalcompra").val(xtotal);
			    $("#totalcompra_igv").val(xtotal);				
				
				$.each(data.detalle_otros, function(i,j){
							
							item+=1;
							xtotal=parseFloat(xtotal).toFixed(2);
							xtotal=(parseFloat(xtotal)+parseFloat(data.detalle_otros[i].monto)).toFixed(2);
						   

						    var codigo_tr = "";
								codigo_tr = item+"_"+data.detalle_otros[i].idproducto;
							
							var str="<tr id='"+codigo_tr+"' class='tr_proforma'>";
							
							    str+="<td>"+item+"<input name='codigo[]' id='codigo[]' value='"+data.detalle_otros[i].idproducto+"' type='hidden'/><input name='codigo_orden[]' id='codigo_orden[]' value='0' type='hidden'/></td>";
								
							   str+="<td width='45%'>"+"<input name='producto[]' id='producto[]' value='"+data.detalle_otros[i].descripcion+"' type='hidden' />"+data.detalle_otros[i].descripcion+"</td>";
							   
							   str+="<td width='17%'>"+"<input type='text' name='glosa[]' id='glosa[]' value='SERIE' class='form-control input-sm'/></td>";
							   
							   str+="<td width='10%'>"+"<input name='canti[]' id='canti[]' value='"+data.detalle_otros[i].cantidad+"' type='hidden' />"+data.detalle_otros[i].cantidad+"</td>";
							   
							   str+="<td width='10%'>"+"<input name='precios[]' id='precios[]' value='"+data.detalle_otros[i].monto+"' type='hidden' />"+data.detalle_otros[i].monto+"</td>";
							   
							   var sub_prof = data.detalle_otros[i].cantidad * data.detalle_otros[i].monto;
							   sub_prof = redondeo(sub_prof);
							   
							   str+="<td width='10%'>"+"<input name='sub[]' id='sub[]'value='"+sub_prof+"'  type='hidden' />"+sub_prof+"</td>";
							   
							   str+="<td width='8%'><a class='servicio btn btn-xs btn-warning'  data="+item+" href='javascript:eliminar_servicio("+item+","+data.detalle_otros[i].idproducto+")'><span class='glyphicon glyphicon-remove' ></span></a>  <a class='btn btn-xs btn-info' href='javascript:_ver(\"index.php?controller=Productos&action=show&id="+data.detalle_otros[i].idproducto+"\");'> <span class='glyphicon glyphicon-zoom-in' ></span></a></td>";
							   var _dato= $(str);
							   
							   $("#detalle_producto").append(_dato);
							   $("#i").val(1);

							   total=(parseFloat(xtotal)+parseFloat(sub_prof)).toFixed(2);
							   
							   
				});

				$("#totalgeneral").empty().append(xtotal);
			    $("#total_igv").empty().append(xtotal);
			    $("#totalcompra").val(xtotal);
			    $("#totalcompra_igv").val(xtotal);
				
				var total_obs = 0;
				
				$.each(data.detalle_obsequios, function(i,j){
							
							item+=1;
							// xtotal=parseFloat(xtotal).toFixed(2);
							// xtotal=(parseFloat(xtotal)+parseFloat(data.detalle_obsequios[i].monto)).toFixed(2);							
							total_obs = (parseFloat(total_obs)+parseFloat(data.detalle_obsequios[i].monto)).toFixed(2);
						   

						    var codigo_tr = "";
								codigo_tr = item+"_"+data.detalle_obsequios[i].idproducto;
							
							var str="<tr id='"+codigo_tr+"' class='tr_proforma'>";
							
							    str+="<td>"+item+"<input name='codigo[]' id='codigo[]' value='"+data.detalle_obsequios[i].idproducto+"' type='hidden'/><input name='codigo_orden[]' id='codigo_orden[]' value='0' type='hidden'/></td>";
								
							   str+="<td width='45%'>"+"<input name='producto[]' id='producto[]' value='"+data.detalle_obsequios[i].descripcion+"' type='hidden' />"+data.detalle_obsequios[i].descripcion+"</td>";
							   
							   str+="<td width='17%'>"+"<input type='text' name='glosa[]' id='glosa[]' value='SERIE' class='form-control input-sm'/></td>";
							   
							   str+="<td width='10%'>"+"<input name='canti[]' id='canti[]' value='"+data.detalle_obsequios[i].cantidad+"' type='hidden' />"+data.detalle_obsequios[i].cantidad+"</td>";
							   
							   str+="<td width='10%'><input name='precios[]' id='precios[]' value='"+data.detalle_obsequios[i].cantidad+"' type='hidden' />"+data.detalle_obsequios[i].cantidad+"</td>";

							    var sub_prof = data.detalle_obsequios[i].cantidad * data.detalle_obsequios[i].monto;
							   sub_prof = redondeo(sub_prof);							   

							   str+="<td width='10%'>"+"<input name='sub[]' id='sub[]'value='"+sub_prof+"'  type='hidden' />"+sub_prof+"</td>";
							   
							   str+="<td width='8%'><a class='servicio btn btn-xs btn-warning'  data="+item+" href='javascript:eliminar_servicio("+item+","+data.detalle_obsequios[i].idproducto+")'><span class='glyphicon glyphicon-remove' ></span></a>  <a class='btn btn-xs btn-info' href='javascript:_ver(\"index.php?controller=Productos&action=show&id="+data.detalle_obsequios[i].idproducto+"\");'> <span class='glyphicon glyphicon-zoom-in' ></span></a></td>";
							   var _dato= $(str);
							   
							   $("#detalle_producto").append(_dato);
							   $("#i").val(1);

							   xtotal=(parseFloat(xtotal)+parseFloat(sub_prof)).toFixed(2);		   
				});

				$("#totalgeneral").empty().append(xtotal);
			    $("#total_igv").empty().append(xtotal);
			    $("#totalcompra").val(xtotal);
			    $("#totalcompra_igv").val(xtotal);
				
				arqueo_obsequios(total_obs);
				//console.log(data.obj);
				//console.log(data.obj.usuario);
			 },'json');
			
			
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
  
}


function atras()
{
	paginacion('controller=Ventasxpedir');
}



	


		
