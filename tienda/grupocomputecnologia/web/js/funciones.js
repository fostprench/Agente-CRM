function popup(url,width,height)
{	  	    
	cuteLittleWindow = window.open(url, "littleWindow","location=no,width="+width+",height="+height+",top=80,left=300,scrollbars=yes");
}

function closeWindow() {
	$.unblockUI({ 
		onUnblock: function(){
			$("#emergente").html("");
		}
	});	
}

$(document).ready(function(){

devolver_cliente = function (idcliente,nombres){
    document.getElementById("idcliente").value=idcliente;
    document.getElementById("cliente").value=nombres;
	closeWindow();
	$("#producto").focus();
}

devolver_cliente_orden = function (idcliente,nombres){
    document.getElementById("idcliente").value=idcliente;
    document.getElementById("cliente").value=nombres;
	closeWindow();
	$("#idtipo").focus();
}

devolver_cliente_proforma = function (idcliente,nombres){
    document.getElementById("idcliente").value=idcliente;
    document.getElementById("cliente").value=nombres;
	closeWindow();
	$("#focus1").focus();
}


devolver_proveedor = function(id, proveedor){
		document.getElementById("idproveedor").value=id;
		document.getElementById("proveedor").value=proveedor;
		$("#fecha").focus();
		closeWindow();
}

devolver_producto_compra = function(id, producto, stock){
		document.getElementById("idproducto").value=id;
		document.getElementById("producto").value=producto;
		document.getElementById("stock_P").value=stock;
		
		$.get('index.php','controller=Compras&action=devolver_costo&id='+id,function(data){
						$("#costo_ant_soles").val('S/. '+data.rep);
						$("#costo_ant_dolares").val('');
						$("#precio_v").val(data.venta);
		},'json');
		
		closeWindow();
}

devolver_componente = function(id_prod,descr,monto,tipo){
		document.getElementById("idproducto_pc").value=id_prod;
		//if(cont==0){document.getElementById("MODELO").value=descr;}
		document.getElementById("componente").value=descr;
		document.getElementById("precio_pc").value=monto;
		document.getElementById("cantidad_pc").value=1; //cont_comp++;
		$("#cantidad_pc").focus();
		closeWindow();
}

devolver_producto = function(id, producto, stock, precio){
		document.getElementById("idproducto").value=id;
		document.getElementById("producto").value=producto;
		document.getElementById("stock").value=stock;
		document.getElementById("precio").value=precio;
		document.getElementById("cant").value=1;
		closeWindow();
		$("#cant").focus();
}

devolver_producto_obs = function(id, producto, precio){
		precio_obs = Math.ceil(precio);
		document.getElementById("idproducto_obs").value=id;
		document.getElementById("producto_obs").value=producto;
		document.getElementById("cantidad_obs").value=1;
		document.getElementById("precio_obs").value=precio_obs;
		$("#cantidad_obs").focus();
		closeWindow();
}

});


