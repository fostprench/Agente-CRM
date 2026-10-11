<?php    
    global $n;
    if(!isset($_GET['key'])) { $n=rand(1000,9999); } else { $n = base64_decode($_GET['key']); }
?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">INICIO DE SESION</h4>
      </div>
      <div class="modal-body">
			
			<form class="form-horizontal" id="frmperfil" name="frmperfil"method="post" >
				<fieldset>

				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Principal:</label>
				  <div class="col-md-4">
					<select id="sucursal" name="sucursal" class="form-control">
					  <option value="1">Nueva Cajamarca</option>
					</select>
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label">Usuario:</label>  
				  <div class="col-md-4">
				  <input id="login" name="login" type="text" placeholder="Usuario" class="form-control input-md">			 
				  </div>
				</div>

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label">Password:</label>
				  <div class="col-md-4">
					<input id="clave" name="clave" type="password" placeholder="Password" class="form-control input-md">
					
				  </div>
				</div>
				
				<!-- Appended Input-->
				<div class="form-group">
				  <label class="col-md-4 control-label">Digite:</label>
				  <div class="col-md-4">
					<div class="input-group">
					  <input id="codigo" name="codigo" onkeypress="validar_numero()" class="form-control" placeholder="Codigo" type="text" >
					  <span class="input-group-addon"><img alt=""  src="lib/capcha.php?key=<?php echo $n; ?>" width="60" height="20" border="0"  /></span>
					</div>
					
				  </div>
				</div>
				
				
				</fieldset>
				</form>

      </div>
      <div class="modal-footer">
		<input type="button" id="ingresar" name="ingresar" value="Aceptar" class="btn btn-primary"/>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> 
      </div>
	   <div class="modal-footer">
		 <p class="text-center" style="display:none;" id="loader"><img src="web/images/cargando.gif" /></p>
		 <div id="msg" class="alert alert-danger text-center" style="display:none;">Mensaje</div>
      </div>
    </div>
  </div>
 <?php echo "<script>CodVali='".$n."';</script>"; ?>
  
