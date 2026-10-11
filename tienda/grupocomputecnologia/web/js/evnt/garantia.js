var band=0;
$(function()
{ 
	 $("#serie").keypress(function(evt){
        var keyPressed = (evt.which) ? evt.which : event.keyCode;
		if(keyPressed==13){
			if($("#serie").val()){
				codigo = $("#serie").val();
				$.post('index.php','controller=Garantia&action=buscar_serieproducto&serie='+codigo,function(data)
				{
					//alert(data.select);
					if(data.res==1){
						$("#producto").val(data.producto);
						$("#comprobante").val(data.comprobante);
						$("#f_comprobante").val(data.f_comprobante);
						$("#idventa").val(data.idventa);
						$("#idcliente").val(data.idcliente);
						$("#cliente").val(data.cliente);
						$("#idproducto").val(data.idproducto);
						$("#tipo_venta").val(data.tipo_venta);
						$(".help-block").html('');
						$("#select_falla").html(data.select);
					}else{
						$(".help-block").html(data.text);
						$(".help-block").fadeOut();
						$(".help-block").fadeIn("slow");
						$("#producto").val('');
						$("#comprobante").val('');
						$("#f_comprobante").val('');
						$("#idventa").val('');
						$("#idcliente").val('');
						$("#cliente").val('');
						$("#tipo_venta").val('');
						$("#idproducto").val('');
					}
					
				},'json');
			}
		}
    });
				
	$("#buscar_serie").click(function(){
		if($("#serie").val()){
			codigo = $("#serie").val();
			$.post('index.php','controller=Garantia&action=buscar_serieproducto&serie='+codigo,function(data)
		    {
				if(data.res==1){
					$("#producto").val(data.producto);
					$("#comprobante").val(data.comprobante);
					$("#f_comprobante").val(data.f_comprobante);
					$("#idventa").val(data.idventa);
					$("#idcliente").val(data.idcliente);
					$("#cliente").val(data.cliente);
					$("#tipo_venta").val(data.tipo_venta);
					$("#idproducto").val(data.idproducto);
					$(".help-block").html('');
					$("#select_falla").html(data.select);
				}else{
					$(".help-block").html(data.text);
					$(".help-block").fadeOut();
					$(".help-block").fadeIn("slow");
					$("#producto").val('');
					$("#comprobante").val('');
					$("#f_comprobante").val('');
					$("#idventa").val('');
					$("#idcliente").val('');
					$("#cliente").val('');
					$("#idproducto").val('');
					$("#tipo_venta").val('');
					$("#select_falla").html(data.select);
				}
				
			},'json');
		}
	});
	
	$("#ver_factura").click(function(){
		if($("#idventa").val()){
			idventa = $("#idventa").val();
			_ver('index.php?controller=Venta&action=show&id='+idventa);
		}else{alert('Debe buscar al menos la Serie de un Producto');}
	});


	 $("#grabar").click(function()
	{   
		bval = true;
	    bval = bval && $( "#idfalla" ).required();
	    bval = bval && $( "#idproducto" ).required();
	    bval = bval && $( "#idventa" ).required();
	    bval = bval && $( "#serie" ).required();
	    bval = bval && $( "#detalle_falla" ).required();
 
		if ( bval ) 
		{
			ver_msg(0,"..::Guardando::..");
			str = $("#_form").serialize();	
			//alert(str); //return false;
			$.post('index.php','controller=Garantia&action=save&'+str,function(data)
		    {   
				if(data.rep==1)
			    {
					msg(1,'Datos grabados correctamente','controller=Garantia'); // insertar
				}
			},'json');
		}
        return false;
	});
	 



});


function atras()
{
	paginacion('controller=Garantia');
}



	