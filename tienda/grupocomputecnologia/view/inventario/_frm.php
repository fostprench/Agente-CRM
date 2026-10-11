<script type="text/javascript" src="web/js/evnt/inventario.js" ></script>
<form id="_form" name="_form" class="form-horizontal">
	<fieldset>

		<legend class='text-center'><?php echo $titulo; ?></legend>
		
		<input name="oper" id="oper" type="hidden" value="<?php echo $p;?>"/>
		<input name="idinventario" id="idinventario" type="hidden" value="<?php echo $obj->idinventario ?>"/>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Producto:</label>  
		  <div class="col-md-4">
				<textarea class="form-control" name="descripcion" rows="7" id="descripcion" readonly='Readonly'><?php echo $obj->producto; ?></textarea>
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Stock:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="stock" id="stock" value="<?php echo $obj->stock;?>"  placeholder="Sctock" class="form-control input-md"> 
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Precio Compra:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="precio_c" id="precio_c"  value="<?php echo $obj->precio_c;?>" placeholder="Precio Compra" class="form-control input-md"> 
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Precio de Venta:</label>  
		  <div class="col-md-4">
		  <input type="text"  name="precio_v" id="precio_v" value="<?php echo $obj->precio_v;?>" placeholder="Precio de Venta" class="form-control input-md">
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
				<input type="submit" name="grabar" id="grabar" value="registrar" class="btn btn-success"/>
				<?php }if($p==2){?>
				<input type="submit" name="grabar" id="grabar" value="actualizar" class="btn btn-success"/>
				<?php }?>
				<input type="button" name="regresar" id="regresar" value="atras"  onclick="atras();" class="btn btn-warning"/>
			</div>
		</div>

	</fieldset>
</form>
 <div style='padding-top:150px;'> </div>