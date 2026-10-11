var item=0;
var item_pc=0;
var item_otros=0;
var item_obsequios=0;
var total_general=0;

$(function()
{  
	$("#cliente").focus();
	$("#_form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
	
	$("#cantidad_pc").keypress(function(e){
        if (e.which == 13) {
            $("#precio_pc").focus();
        }
    });
	
	$("#precio_pc").keypress(function(e){
        if (e.which == 13) {
             $("#agregar_componente").focus();
        }
    });
	
	
	$("#agregar_componente").keypress(function(e){
        if (e.which == 13) {
            agregar_comp_equipo();
        }
    });
	
	$("#cant").keypress(function(e){
        if (e.which == 13) {
            $("#precio").focus();
        }
    });
	
	$("#precio").keypress(function(e){
        if (e.which == 13) {
            $("#agregarc").focus();
        }
    });
	
	// $("#garantia").keypress(function(e) {
        // if (e.which == 13) {
			// $('#garantia').trigger('click');
        // }
    // });
	


	
	$("#garantia").change('click',function(){
		var text = $('#garantia option:selected').html();
		$("#agregarc").focus();
	});
	
	
	
	$("#agregarc").keypress(function(e){
        if (e.which == 13) {
            $("#agregarc").click();
            $("#buscar_producto").focus();
        }
    });
	
	
	$("#cantidad_obs").keypress(function(e){
        if (e.which == 13) {
            $("#precio_obs").focus();
        }
    });
	
	$("#precio_obs").keypress(function(e){
        if (e.which == 13) {
            $("#agregar_obsequio").focus();
        }
    });
	
	$("#agregar_obsequio").keypress(function(e){
        if (e.which == 13) {
             agregar_comp_obsequio();			 
			 $("#producto_obs").focus();
        }
    });
	
	$("#producto_obs").keypress(function(e){
        if (e.which == 13) {
            $("#buscar_obsequio").click();
        }
    });
	

	
	
// $("#buscar_cli").click(function(){
// $("#emergente").load("index.php?controller=Cliente&action=mostrar", function(){
// $.blockUI({
				// message: $("#emergente"),
				// css:{
					// top: '2%',
					// width: '80%',
					// height: 'auto',
					// left: '10%'
				 // },
				 // onBlock: function() {
						// $('#q').focus();
				// }
			// }); 
		// });
		
// });

	function buscar_cliente(opc){
		if(opc==1){var texto_1=""; }else{var texto_1 = $.trim($("#cliente").val());}
		$.ajax({
					 url: "index.php",
					 type: 'GET',
					 data: "controller=Cliente&action=mostrar_cliente_proforma&q="+texto_1, 
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
	
	$("#buscar_cli").click(function(){ 	buscar_cliente(1); });

	$("#cliente").keypress(function(e){
        if (e.which == 13) {
				buscar_cliente(2);
        }
    });


$(".buscar_componente").click(function(){
categoria = $(this).data('cat');
$("#emergente").load("index.php?controller=Productos&action=mostrar_p&cat="+categoria, function(){
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


	$("#buscar_producto").keypress(function(e){
        if (e.which == 13) {
			$("#buscar_producto").click();
        }
    });




$("#buscar_producto").click(function(){
$("#emergente").load("index.php?controller=Venta&action=mostrar_otros_proforma", function(){
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

$("#buscar_obsequio").click(function(){
$("#emergente").load("index.php?controller=Venta&action=mostrar_p_total_obs", function(){
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



	$("#ganancia").keyup(function(){
		
		ganancia = $("#ganancia").val();
		setTimeout("",10000);
		if(ganancia==""){$("#ganancia").val(0);ganancia=0;}
		ganancia = parseInt(ganancia);	
		var precio_unitario_hidden = $("#precio_unitario_hidden").val();

		console.log("precio_unitario_hidden => "+precio_unitario_hidden);

		var cant_pc = $("#cantidad").val();	
		console.log("cant_pc => "+cant_pc);	
		var total_pc_Actual = $("#precio_total").val(); // RESTAR AL TOTAL GENERAL	
		console.log("total_pc_Actual => "+total_pc_Actual);	
		
		var subtotal_DSCTO = (parseFloat(precio_unitario_hidden*(1+(ganancia/100)))).toFixed(2);	

		console.log("subtotal_DSCTO => "+subtotal_DSCTO);	

		var precio_total_DSCTO = parseFloat(cant_pc*subtotal_DSCTO).toFixed(2);
		
		console.log("precio_total_DSCTO => "+precio_total_DSCTO);	

		$("#precio_unitario").val(subtotal_DSCTO);
		$("#precio_total").val(precio_total_DSCTO);
		
		operacion_totalgeneral(2,total_pc_Actual);
		operacion_totalgeneral(1,precio_total_DSCTO);
		
	});
	
	$("#cantidad").on('keyup click', function(){
		
		cant = this.value;
		setTimeout("",10000);
		if(cant=="" || cant==0){$("#cantidad").val(1);cant=1;}
		var precio_u = $("#precio_unitario").val();
		var total_pc_Actual = $("#precio_total").val();
		
		var precio_total_DSCTO = parseFloat(cant*precio_u).toFixed(2);
		
		$("#precio_total").val(precio_total_DSCTO);
		
		operacion_totalgeneral(2,total_pc_Actual);
		operacion_totalgeneral(1,precio_total_DSCTO);
		
	});
	

$("#_descuento" ).click(function() {
	if($('#_descuento').is(':checked')){ 	
		var total_compra = $("#total_general").val(); //alert(total_compra);
		var descuento = $("#descuento_general").val(); 
		if(descuento==''){$("#descuento_general").val(0); descuento=0;}
		var sum = total_compra - descuento;
		total = redondeo(sum);
		$("#total_general").val(total);
	}else{	
		total_compra = $("#total_general").val();
		var descuento = $("#descuento_general").val(); 
		if(descuento==''){$("#descuento_general").val(0); descuento=0;}
		var sum = (parseFloat(total_compra)+parseFloat(descuento)).toFixed(2);
		total = redondeo(sum);
		$("#total_general").val(total);				 
	}
});

$("#descuento_general").keyup(function(){
	if($('#_descuento').is(':checked')){ 	
		var total_compra = $("#general_hidden").val(); //alert(total_compra);
		var descuento = $("#descuento_general").val(); 
		if(descuento==''){$("#descuento_general").val(0);descuento=0;}
		var sum = total_compra - descuento;
		total = redondeo(sum);
		$("#total_general").val(total);
	}else{
	//no hace nada
	}
});

	

	function agregar_comp_equipo(){
		
				bval = true;
				bval = bval && $( "#ganancia").required();
				bval = bval && $( "#cantidad").required();
				bval = bval && $( "#componente").required();
				bval = bval && $( "#cantidad_pc").required();
				bval = bval && $( "#precio_pc").required();
				
				if(bval)
			   {				
		
						var cantidad = $("#cantidad").val();
						var ganancia = $("#ganancia").val();
						var componente = $("#componente").val();
						var cantidad_pc = $("#cantidad_pc").val();
						var precio_pc = $("#precio_pc").val();
						var idproducto_pc = $("#idproducto_pc").val();
						var precio_unitario = $("#precio_unitario").val();
						var precio_unitario_hidden = $("#precio_unitario_hidden").val();


						var costo_producto = parseFloat(precio_pc*cantidad_pc).toFixed(2);
						
						var precio_u_hiiden = (parseFloat(precio_unitario_hidden)+parseFloat(costo_producto)).toFixed(2);
						
						
						
						
						var sub_total = (parseFloat(precio_unitario)+parseFloat(costo_producto*(1+(ganancia/100)))).toFixed(2);
							
							precio_total = parseFloat(cantidad*sub_total).toFixed(2);
							
							monto_procesar = parseFloat((cantidad*costo_producto)*(1+(ganancia/100))).toFixed(2);
				   
						closeWindow();
				   
					   item_pc+=1;
					   var str="<tr id='detalle_pc_"+item_pc+"' class='tr_primero'>";
					   str+="<td width='5%'>"+item_pc+"<input name='codigo[]' id='codigo[]' value='"+idproducto_pc+"' type='hidden'/></td>";
					   str+="<td width='75%'>"+"<input name='producto[]' id='producto[]' value='"+componente+"' type='hidden' />"+componente+"</td>";
					   str+="<td width='5%'>"+"<input name='canti[]' id='canti[]' value='"+cantidad_pc+"' type='hidden' />"+cantidad_pc+"</td>";
					   str+="<td width='5%'>"+"<input name='monto[]' id='monto[]' value='"+costo_producto+"' type='hidden' />"+costo_producto+"</td>";
					   str+="<td width='10%'><a class='btn btn-xs btn-danger' href='javascript:eliminar_pc("+item_pc+","+costo_producto+");'><span class='glyphicon glyphicon-remove' ></span></a> <a class='btn btn-xs btn-info' href='javascript:_ver(\"index.php?controller=Productos&action=show&id="+idproducto_pc+"\");'> <span class='glyphicon glyphicon-zoom-in' ></span></a></td>";
					   var _dato= $(str);
					   $("#detalle_pc").append(_dato);
					   $("#precio_unitario").val(sub_total);
					   $("#precio_unitario_hidden").val(precio_u_hiiden);
					   $("#precio_total").val(precio_total);
					   limpiar_pc();
					   operacion_totalgeneral(1,monto_procesar);
					   
					} 
					return false;
		
	}
				
	$("#agregar_componente").click(function(){
			agregar_comp_equipo();
	 });
	
     $("#agregarc").click(function()
	 {
	    bval = true;
	    bval = bval && $( "#producto").required();
	    bval = bval && $( "#cant").required();
	    bval = bval && $( "#precio").required();
	    bval = bval && $( "#ganancia_otro").required();

		if(bval)
		{
		  
		   garantia=$( "#garantia").val();
		   id_prod=$( "#idproducto").val();
		   prod=$("#producto").val(); 
		   cant=$( "#cant").val();
		   precio=$("#precio").val(); 
		   total_otros=$("#total_otros").val(); 
		   ganancia_otro =$("#ganancia_otro").val(); 
		   
		   item_dscto = parseFloat((precio*(ganancia_otro/100))*cant).toFixed(2);
		   precio = (precio*(1+(ganancia_otro/100))).toFixed(2);
		   
		  
		   
		   importe_total = (cant*precio);
		   importe_total = redondeo(importe_total);
		   
		   xtotal_otros = (parseFloat(total_otros)+parseFloat(importe_total)).toFixed(2);
		   
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
				      
				   
				   var str="<tr id='detalle_otro_"+item+"' class='tr_p'>";
					   str+="<td width='5%'>"+item+"<input name='codigo_otros[]' id='codigo_otros[]' value='"+id_prod+"' type='hidden'/></td>";
					   str+="<td width='48%'>"+"<input name='producto_otros[]' id='producto_otros[]' value='"+prod+"' type='hidden' />"+prod+"</td>";
					   str+="<td width='5%'>"+"<input name='canti_otros[]' id='canti_otros[]' value='"+cant+"' type='hidden' />"+cant+"</td>";
					   str+="<td width='8%'>"+"<input name='precios_otros[]' id='precios_otros[]' value='"+precio+"' type='hidden' />"+precio+"</td>";
					   str+="<td width='8%'>"+"<input name='importe_otros[]' id='importe_otros[]'value='"+importe_total+"'  type='hidden' />"+importe_total+"</td>";
					   str+="<td width='8%'>"+"<input name='descuento[]' id='descuento[]'value='"+item_dscto+"'  type='hidden' />"+item_dscto+"</td>";
					   str+="<td width='8%'>"+"<input name='garantia[]' id='garantia[]'value='"+garantia+"'  type='hidden' />"+garantia+" M</td>";
					   str+="<td width='10%'><a class='btn btn-xs btn-danger' href='javascript:eliminar_otro("+item+","+importe_total+");'><span class='glyphicon glyphicon-remove'></span></a> <a class='btn btn-xs btn-info' href='javascript:_ver(\"index.php?controller=Productos&action=show&id="+id_prod+"\");'> <span class='glyphicon glyphicon-zoom-in' ></span></a></td>";
					   var _dato= $(str);
					   
					   $("#detalle_producto").append(_dato);
					   $("#txttotal_otros").html(xtotal_otros);
					   $("#total_otros").val(xtotal_otros);
					   limpiar();
					   
					   operacion_totalgeneral(1,importe_total);
			   }
		   }
		   return false;
	 });
	
	
	function agregar_comp_obsequio(){
		bval = true;
	    bval = bval && $( "#producto_obs").required();
	    bval = bval && $( "#cantidad_obs").required();
	    bval = bval && $( "#precio_obs").required();

		if(bval)
		{
		  
		   id_prod=$( "#idproducto_obs").val();
		   prod=$("#producto_obs").val(); 
		   cant=$( "#cantidad_obs").val();
		   precio_obs = $("#precio_obs").val(); 
		   total_obsequios=$("#total_obsequios").val(); 
		   
		   
		   sub_total2 = parseFloat(precio_obs*cant).toFixed(2);
		   txttotal_obsequios = (parseFloat(total_obsequios)+parseFloat(sub_total2)).toFixed(2);

		   band=true;
		    $(".tr_obs").each(function(indice,valor){
                  id_pp = $(this).find("td:eq(0) :input").val();
				  if(id_pp==id_prod){
					band=false;limpiar();
					alert('Este producto  ya fue agregado');
					return false; 
					}
                });

				if(band){
				
				 item_obsequios+=1;
				      
				   
				   var str="<tr id='detalle_obs_"+item_obsequios+"' class='tr_obs'>";
					   str+="<td>"+item_obsequios+"<input name='codigo_obs[]' id='codigo_obs[]' value='"+id_prod+"' type='hidden'/></td>";
					   str+="<td width='53%'>"+"<input name='producto_obs[]' id='producto_obs[]' value='"+prod+"' type='hidden' />"+prod+"</td>";
					   str+="<td width='8%'>"+"<input name='canti_obs[]' id='canti_obs[]' value='"+cant+"' type='hidden' />"+cant+"</td>";
					   str+="<td width='8%'>"+"<input name='precios_obs[]' id='precios_obs[]' value='"+precio_obs+"' type='hidden' />"+precio_obs+"</td>";
					   str+="<td width='8%'>"+"<input name='importe_obs[]' id='importe_obs[]'value='"+sub_total2+"'  type='hidden' />"+sub_total2+"</td>";
					   str+="<td width='10%'><a class='btn btn-xs btn-danger' href='javascript:eliminar_obs("+item_obsequios+","+sub_total2+");'><span class='glyphicon glyphicon-remove' ></span></a> <a class='btn btn-xs btn-info' href='javascript:_ver(\"index.php?controller=Productos&action=show&id="+id_prod+"\");'> <span class='glyphicon glyphicon-zoom-in'></span></a></td>";
					   var _dato= $(str);
					   
					   $("#detalle_obs").append(_dato);
					   $("#txttotal_obsequios").html(txttotal_obsequios);
					   $("#total_obsequios").val(txttotal_obsequios);
					   limpiar_obs();
					   
					   operacion_totalgeneral(1,sub_total2);
			   }
		   }
		   return false;
	}
	
	$("#agregar_obsequio").click(function()
	 {
	    agregar_comp_obsequio();
	 });
	 
	
	 $("#fecha_emision").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true
	});
	
	$("#fecha_caducidad").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true
	});
	
	$("#_form").submit(function()
	{ 
	    bval = true;
	    bval = bval && $( "#cliente").required();
	    bval = bval && $( "#MODELO").required();
		// bval = bval && $( "#nro_comprobante").required();
	    // bval = bval && $( "#fecha").required();
	    
		if ( bval ) 
		{
		  //FALTA VALIDAR SI ENTAN LLENOS LOS DETALLES
			
			ver_msg(0,"..::Guardando::..");
			
			fecha_1 = $("#fecha_emision").val();
			fecha_11 = formato_fecha(fecha_1);
			
			fecha_2 = $("#fecha_caducidad").val();
			fecha_22 = formato_fecha(fecha_2);
			
			
			  str = $(this).serialize();
			  str = str+"&fecha_emision_="+fecha_11+"&fecha_caducidad_="+fecha_22;
			    //alert(str); return false;
				$.post('index.php','controller=Proformas&action=save&'+str,function(data)
				{
					//alert(data.msg);
					if(data.rep=="1")
					{
						msg(1,'Datos grabados correctamente','controller=Proformas');
					}
					if(data.rep=="2")
					{
						ver_msg(2,'Datos modificados correctamente');
					}
				  },'json');
			
			
		}
		return false;
	});
	
	
	
	
	
});


function operacion_totalgeneral(tipo,monto_procesar){
		_total_general = document.getElementById("total_general").value;
		if(tipo==1){
			total_general = (parseFloat(_total_general)+parseFloat(monto_procesar)).toFixed(2);
		}else{
			total_general = (parseFloat(_total_general)-parseFloat(monto_procesar)).toFixed(2);
		}
		document.getElementById("total_general").value=total_general;	
		document.getElementById("general_hidden").value=total_general;	
}
	

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

function limpiar_pc()
{
	document.getElementById("idproducto_pc").value="";
	document.getElementById("componente").value="";
	document.getElementById("cantidad_pc").value="";
	document.getElementById("precio_pc").value="";
}


function limpiar()
{
	document.getElementById("idproducto").value="";
	document.getElementById("producto").value="";
	document.getElementById("precio").value="";
	document.getElementById("cant").value="";
}

function limpiar_obs()
{
	document.getElementById("producto_obs").value="";
	document.getElementById("idproducto_obs").value="";
	document.getElementById("cantidad_obs").value="";
	document.getElementById("precio_obs").value="";
}



function eliminar_pc(id,sss)
{ 
	 cantidad_pc  = document.getElementById("cantidad").value;    
	 ganancia_pc = document.getElementById("ganancia").value;    
	    descontar = sss*(1+(ganancia_pc/100));

	precio_unitario = document.getElementById("precio_unitario").value;
	precio_unitario = parseFloat(precio_unitario - descontar).toFixed(2);
	precio_unitario = redondeo(precio_unitario);
	
	precio_unitario_hidden = document.getElementById("precio_unitario_hidden").value;
	precio_unitario_hidden = parseFloat(precio_unitario_hidden - sss).toFixed(2);
	
	document.getElementById("precio_unitario").value=precio_unitario;
	document.getElementById("precio_unitario_hidden").value=precio_unitario_hidden;
	
	
	precio_total = parseFloat(cantidad_pc*precio_unitario).toFixed(2);
	document.getElementById("precio_total").value=precio_total; 
	
	$("#detalle_pc_"+id).remove();
	
	descontar_total = parseFloat(descontar*cantidad_pc).toFixed(2);
	operacion_totalgeneral(2,descontar_total);   
}

function eliminar_otro(id,subtotal)
{ 
	total_otros = document.getElementById("total_otros").value;
	xtotal_ = (parseFloat(total_otros)-parseFloat(subtotal)).toFixed(2);
	document.getElementById("txttotal_otros").innerHTML=xtotal_;
	document.getElementById("total_otros").value=xtotal_;
	$("#detalle_otro_"+id).remove();
	operacion_totalgeneral(2,subtotal);   
}

function eliminar_obs(id,sub)
{ 
	total_obsequios = document.getElementById("total_obsequios").value;
	xtotal_obs = (parseFloat(total_obsequios)-parseFloat(sub)).toFixed(2);
	document.getElementById("txttotal_obsequios").innerHTML=xtotal_obs;
	document.getElementById("total_obsequios").value=xtotal_obs;
	$("#detalle_obs_"+id).remove();
	operacion_totalgeneral(2,sub);   
}



function atras(){paginacion('controller=Proformas');}


	


		
