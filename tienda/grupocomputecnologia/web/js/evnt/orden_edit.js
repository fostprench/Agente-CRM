var item=0;
var xtotal=0;
var sub_s = 0;
var sub_d = 0;
var sub_producto=0;


$(function()
{  
	
	$("#atendido").focus();
	
	$("#_form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
	
	$("#nro_recibo" ).keypress(function(e){
			if (e.which == 13) {
				$("#idtipo").focus();
			}		
	});
	
	$("#idtipo").change('click',function(){
		$("#idmarca").focus();
	});
	
	$("#idmarca").change('click',function(){
		$("#desc_equipo").focus();
	});
	
	$("#desc_equipo" ).keypress(function(e){
			if (e.which == 13) {
				$("#desc_falla").focus();
			}		
	});
	
	$("#desc_falla" ).keypress(function(e){
			if (e.which == 13) {
				$("#accesorios").focus();
			}		
	});
	
	$("#accesorios" ).keypress(function(e){
			if (e.which == 13) {
				$("#idservicio").focus();
			}		
	});
	
	$("#idservicio" ).keypress(function(e){
			if (e.which == 13) {
				agregar();
			}		
	});
	
	$("#precio_s" ).keypress(function(e){
			if (e.which == 13) {
				$("#agregar_serv").focus();
			}		
	});
	
	$("#agregar_serv" ).keypress(function(e){
			if (e.which == 13) {
				agregar();
			}		
	});
	
	$("#cant_s").keypress(function(e) {
        if (e.which == 13) {
			if($(this).val()){
				$("#agregar_serv").focus(); 
			}else{
				$("#cant_s").focus();
			}
        }
    });
	
	$.each($('.tr_p'), function() {
         item = (this.id );
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
				 onBlock: function(){
					$('#q').focus();
				}
			}); 
		});
		
});

	$("#idservicio").change('click',function(){
		var text = $('#idservicio option:selected').html();
		var precio_s = text.split("-");
		$("#precio_s").val(precio_s[1]);
		$("#cant_s").focus();
	});
	 
	 
	 
     $("#agregar_serv").click(function()
	 {
		agregar();
	 });
	 
	 function agregar(){
		 var id_serv = $('#idservicio option:selected').val(); 
		if(id_serv==''){
		
			alert('Dede Seleccionar un Item de Servicio de Soporte Tecnico');
			
		}else{
		
			xtotal = $("#total_servicio").val();
			xtotal = parseFloat(xtotal);
			
			
			$.each($('.tr_p'),function(){
				item = (this.id );
			});
			
			item = parseInt(item);
		
			var txt = $('#idservicio option:selected').html(); 
			var res = txt.split("-");
			var servicio = res[0];
			var preciox = $("#precio_s").val();
			var cant_ = $("#cant_s").val();
			var precio_s = parseFloat(preciox).toFixed(2);
			var cant_s= parseInt(cant_);
			var subtotal=precio_s*cant_s;
			
			band=true;
		    $(".tr_p").each(function(indice,valor){
                  id_pp = $(this).find("td:eq(0) :input").val();
				  if(id_pp==id_serv){
					band=false;limpiar();
					alert('Este Servicio ya fue agregado');
					return false; 
					}
            });
				
			if(band){
				
				item+=1;
				$('#msg-parte').hide();
				
				
		        xtotal=parseFloat(xtotal).toFixed(2);
		        xtotal=(parseFloat(xtotal)+parseFloat(subtotal)).toFixed(2);
				subtotal=parseFloat(subtotal).toFixed(2);
				
				var str="<tr id='"+item+"' class='tr_p'>";
					str+="<td width='5%'>"+cant_s+"<input name='codigo[]' id='codigo[]' value='"+id_serv+"' type='hidden'/><input name='cant_s[]' id='cant_s[]' value='"+cant_s+"' type='hidden'/></td>";
					str+="<td width='70%'>"+"<input name='servicio[]' id='servicio[]' value='"+servicio+"' type='hidden' />"+servicio+"</td>";
					str+="<td width='15%'>"+"<input name='precio_real[]' id='precio_real[]' value='"+precio_s+"' type='hidden'/>"+precio_s+"</td>";
					str+="<td width='25%'>"+"<input name='subtotal[]' id='subtotal[]' value='"+subtotal+"' type='hidden'/>"+subtotal+"</td>";
					str+="<td width='5%'><a class='btn btn-xs btn-danger' href='javascript:eliminar_p("+item+","+subtotal+");' ><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
					var _dato= $(str);
					$("#detalle_servicio").append(_dato);
					$("#i").val(item);
					$("#totalgeneral").html(xtotal);
					$("#total_servicio").val(xtotal);

				limpiar();
			}
				
		}

		   return false;
	 }
	 
	$('#fecha').datetimepicker({
        language:  'es',
		format: 'dd-mm-yyyy hh:ii:ss',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	
	$("#_form").submit(function()
	{ 
		// alert('ok');
	    bval = true;
	    bval = bval && $( "#nro_orden").required();
	    bval = bval && $( "#fecha").required();
	    bval = bval && $( "#cliente").required();
	    bval = bval && $( "#idtipo").required();
	    bval = bval && $( "#idmarca").required();
	    bval = bval && $( "#desc_equipo").required();
	    bval = bval && $( "#desc_falla").required();
	    bval = bval && $( "#accesorios").required();
	    
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
			  
			  str = $(this).serialize();
			  str = str+"&fecha_="+fecha_;
			   //alert(str);//return false;
				$.post('index.php','controller=Orden_st&action=save&'+str,function(data)
				{
					//alert(data.msg);
					if(data.rep=="1")
					{
						msg(1,'Datos grabados correctamente','controller=Orden_st');
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

function redondeo(numero)
{
var flotante = parseFloat(numero);
var resultado = Math.round(flotante*100)/100;
return resultado.toFixed(2);
}

function formato_fecha(fecha){
var date_part = fecha.split(" ");
var array=date_part[0].split("-");
var fecha = array[2]+'-'+array[1]+'-'+array[0];
return fecha+' '+date_part[1];
}

function limpiar()
{
	document.getElementById("cant_s").value="";
	document.getElementById("precio_s").value="";
	document.getElementById("idservicio").value="";
}

function eliminar_p(id,sss)
{  

    total = document.getElementById("total_servicio").value;
    total   = parseFloat(total);

    xtotal=total-sss;
    xtotal = redondeo(xtotal);
    
	$("#"+id).remove();
	
    document.getElementById("total_servicio").value=xtotal;

	$("#totalgeneral").html(xtotal);
	
	var cont_item = 0;
    $.each($('.tr_p'), function() {
		cont_item++;
    });

    if(cont_item==0){$("#i").val(0);}
	if(id>=item){item--;}
	  
}



function atras()
{
paginacion('controller=Orden_st');
}

function imprimir()
{
window.open("fpdf/reporte.php?tabla=Orden_st");
}

	


		
