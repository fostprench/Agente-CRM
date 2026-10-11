<script type="text/javascript" src="web/js/evnt/tipo.js" ></script>
<form id="_form" name="_form" action="" method="GET" class="form-horizontal">
	<fieldset>

		<legend class='text-center'><?php echo $titulo; ?></legend>
		
		<input name="oper" id="oper" type="hidden" value="<?php echo $p;?>"/>
		<input name="idtipo" id="idtipo" type="hidden" value="<?php echo $obj->idtipo ?>"/>
					

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Categoria:</label>  
		  <div class="col-md-4">
		  <input  type="text"  name="descripcion" id="descripcion" maxlength="100" value="<?php echo $obj->descripcion;?>" placeholder="Categoria" class="form-control input-md" required="">  
		  </div>
		</div>
		
		<div class="form-group">
			  <div class="col-md-12 text-center">
				<div id="msg" ></div>
			  </div>
		</div>

			<div class="form-group">
			  <div class="col-md-12">
				<?php if($p==1){?>
				<input type="submit" name="grabar" id="grabar" value="Registrar" class="btn btn-success"/>
				<?php }if($p==2){?>
				<input type="submit" name="grabar" id="grabar" value="Actualizar" class="btn btn-success"/>
				<?php }?>
				<input type="button" name="regresar" id="regresar" value="Atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
			</div>

	</fieldset>
</form>
 <div style='padding-top:250px;'> </div>
<br/>