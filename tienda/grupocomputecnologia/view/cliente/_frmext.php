<script>
	$(document).ready(function(){
		$('.style_nombres').addClass("hide");
		$('.style_razon').addClass("hide");

		$("#tipo_cliente").change(function(){
				idd = $(this).val();
			
				 if(idd==1)
				 {
					  $(".style_razon").removeClass("show").addClass("hide");
					  $('.style_nombres').removeClass("hide").addClass("show");
					  $("#nombres").focus();
				 }
				 if(idd==2)
				 {
					 $('.style_nombres').removeClass("show").addClass("hide");
					 $(".style_razon").removeClass("hide").addClass("show");
					 $("#raz_social").focus();
				 }
		});
		
		
		$("#nombres").keypress(function(e) {
        if (e.which == 13) {
            $("#dni").focus();
        }
    });
	
	$("#raz_social").keypress(function(e) {
        if (e.which == 13) {
            $("#ruc").focus();
        }
    });
	
	$("#ruc").keypress(function(e) {
        if (e.which == 13) {
            $("#direccion").focus();
        }
    });
	
	$("#dni").keypress(function(e) {
        if (e.which == 13) {
            $("#direccion").focus();
        }
    });
	
	$("#direccion").keypress(function(e) {
        if (e.which == 13) {
			if($("#tipo_cliente").val()==1){
				$("#email").focus();
			}else{
				$("#telefono").focus();
			}
        }
    });
	
	$("#email").keypress(function(e) {
        if (e.which == 13) {
            $("#telefono").focus();
        }
    });
	
	$("#telefono").keypress(function(e) {
        if (e.which == 13) {
            $("#guardarExt").focus();
        }
    });
	
	$("#observaciones").keypress(function(e) {
        if (e.which == 13) {
            $("#guardarExt").focus();
        }
    });
	
	$("#_form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
	
	$("#guardarExt").keypress(function(e) {
        if (e.which == 13) {
            agregar(); return false; 
			// alert("keypress"); return  false;
        }
    });
	
	$("#guardarExt").click(function() {
            agregar(); return false;   
			// alert("click");			
    });
	
	function agregar()
	{    console.log("h");
			 tipo_cliente = document.getElementById("tipo_cliente").value;
			if(tipo_cliente==0){$("#tipo_cliente" ).focus();return false;}
			
			if($( "#tipo_cliente" ).val()==1)
			{	
				nombre_cliente = document.getElementById("nombres").value;
				if(nombre_cliente==''){$("#nombres" ).focus();return false;}
				if($("#dni" ).val()){
					var myString = $("#dni").val();
					var tamanio = myString.length;
					if(tamanio<8){alert('DNI incorrecto, Verifique que Tenga 8 Digitos');$("#dni").focus();return false;}
				}
			}
			  if($("#tipo_cliente").val()==2)
			{
				rz_cliente = document.getElementById("raz_social").value;
				if(rz_cliente==''){$("#raz_social" ).focus();return false;}
				ruc_cliente = document.getElementById("ruc").value;
				if(ruc_cliente==''){$("#ruc" ).focus();return false;}
				
				var myString = $("#ruc").val();
				var tamanio = myString.length;
				if(tamanio<11){alert('RUC incorrecto, Verifique que Tenga 11 Digitos');$("#ruc").focus();return false;}
		 
			}
		
			fecha_ = $("#fecha_cliente").val();
			tipo_cliente = $("#tipo_cliente").val();
			
			str = $("#form_ext_cliente").serialize();
			str = str+"&fecha_="+fecha_+"&tipo_c="+tipo_cliente;
			$("#msg_cliente").css("display","block");
			$.post('index.php','controller=Cliente&action=save&'+str,function(data)
		    {
				if(data.rep=="1")
			    {
					console.log(data.rep);
					var HTML_DATA = '<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> Cliente Guardado Correctamente';
					$("#msg_cliente").html(HTML_DATA);
						$("#emergente").load("index.php?controller=Cliente&action=mostrar", function(){
						$.blockUI({
								message: $("#emergente"),
								css:{
										top: '5%',
										width: '70%',
										height: 'auto',
										left: '15%'
									}
								}); 
						});
				}
			},'json');
		
        return false;
	}
	
	
	
		
	});

</script>
<form id="form_ext_cliente" name="form_ext_cliente" class="form-horizontal">
	<fieldset>

		<legend class='text-center'><?php echo $titulo; ?></legend>
		
		<input type="hidden" name="controller" value="Cliente" /> 
		<input name="oper" id="oper" type="hidden" value="<?php echo $p;?>"/>
		<input type="hidden" name="idcliente" id="idcliente" >
		   
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Tipo cliente:</label>  
		  <div class="col-md-4">
				<select id="tipo_cliente" name="tipo_cliente" class="form-control">
				<option value="0">::..Seleccione..::</option>
				<option value="1" >Natural</option>
				<option value="2" >Juridico</option>
				</select>
		  </div>
		</div>

		<div class="form-group style_nombres">
		  <label class="col-md-4 control-label" for="textinput">Nombres:</label>  
		  <div class="col-md-4">
		  <input type="text" name="nombres" id="nombres"  placeholder="Nombres" class="form-control input-md"> 
		  </div>
		</div>

		<div class="form-group style_razon">
		  <label class="col-md-4 control-label" for="textinput">Razon social:</label>  
		  <div class="col-md-4">
		  <input type="text" name="raz_social" id="raz_social"   placeholder="Razon social" class="form-control input-md"> 
		  </div>
		</div>

		<div class="form-group style_nombres">
		  <label class="col-md-4 control-label" for="textinput">DNI:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="dni" id="dni" size="13" maxlength="8"  onkeypress="return permite(event,'num')" placeholder="DNI" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group style_razon">
		  <label class="col-md-4 control-label" for="textinput">RUC:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="ruc" id="ruc" size="13" maxlength="13"  onkeypress="return permite(event,'num')" placeholder="RUC" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Ubigeo:</label>  
		  <div class="col-md-4">
			<?php echo $ubigeo;?>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Direcci&oacute;n:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="direccion" id="direccion" size="150" maxlength="150"   placeholder="Direccion" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group style_nombres">
		  <label class="col-md-4 control-label" for="textinput">Email:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="email" id="email" size="150" maxlength="150"  placeholder="Email" class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Telefono:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="telefono" id="telefono" size="45" maxlength="45"  placeholder="Telefono" onkeypress="return permite(event,'num')"class="form-control input-md">
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Fecha:</label>  
		  <div class="col-md-4">
		  <input type='hidden' name="fecha_cliente" id="fecha_cliente" value="<?php echo date('Y-m-d'); ?>" >
		  <input type='text' readonly value="<?php echo date('d-m-Y'); ?>" placeholder="Fecha" class="form-control input-md">
		  </div>
		</div>
		
		
		<div class="form-group">
			  <div class="col-md-12 text-center">
				<div class="alert alert-danger" id="msg_cliente" style="display:none;" class="text-center" role="alert">
					<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> Guardando Cliente, Por Favor Espere ...
				</div>
			  </div>
		</div>
		

		
		<div class="form-group">
			<div class="col-md-12 text-center">
				<input type="button" name="guardarExt" id="guardarExt" value="Registrar" class="btn btn-success"/>
				<input type="button" value="Cerrar" onclick="closeWindow();" class="btn btn-warning"/>
			</div>
		</div>
		
		

	</fieldset>
</form>