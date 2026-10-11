<?php require_once('lib/funciones.php'); ?>
<script>
$(document).ready(function(){
$("#tipo_c").attr("disabled","disabled");
});
</script>
 <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?><button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button></legend>
			
			<input type="hidden" name="idventa" id="idventa" value="<?php echo $obj->idventa;?>"/>
			<input type="hidden" name="idcliente" id="idcliente" value="<?php echo $obj->idcliente;?>"/>
			<input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
			<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario'];?>"/>
		
		
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="col-xs-12 col-sm-4 col-md-4 text-center">
					<img src="web/images/<?php echo $_SESSION['logo'];?>" class="img-responsive" style="border:0;margin:0 auto"/>	
					<span class='nombre'><?php echo $_SESSION['propietario'];?></span><br/>
					<span class='descripcion'><?php echo $_SESSION['descripcion'];?></span><br/>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 text-center">
					<span class='descripcion'><?php echo $_SESSION['direccion'];?><br/><?php echo $_SESSION['telefono'];?></span>
				</div>
				<div class="col-xs-12 col-sm-5 col-md-5">
				
						<div class="form-group">
						  <label class="col-md-3 control-label" for="selectbasic">Tipo: </label>
						  <div class="col-md-9">
							<?php echo $tipo_c; ?>
						  </div>
						</div>
						
						<div class="form-group">
						  <label class="col-md-3 control-label" for="selectbasic">Comprobante: </label>
						  <div class="col-md-3">
							<input type="text" name='nro_comprobante' id='nro_comprobante' disabled value='<?php echo $obj->nro_comprobante;?>' placeholder="Nro. Comprobante" class="form-control input-sm">
						  </div>
						   <label class="col-md-2 control-label" for="selectbasic">Fecha: </label>
						  <div class="col-md-4">
							<input type="text" name='fecha' id='fecha' disabled value="<?php echo validar_fecha($obj->fecha);  ?>" placeholder="Fecha" class="form-control input-sm">
						  </div>
						</div>
				
				</div>
			</div>
			<div style="padding-top:20px;">&nbsp;</div>
		

		
			<div class="col-xs-12 col-sm-12 col-md-12">
	
				<div class="form-group">
				  <label class="col-md-1 control-label" for="selectbasic">Cliente: </label>
				  <div class="col-md-5">
					<input type="text" id="cliente" name="cliente" value="<?php echo $obj->cliente;?>" readonly="true" placeholder="Cliente" class="form-control input-sm">
				  </div>
				  <label class="col-md-2 control-label" for="selectbasic">Telefono: </label>
				  <div class="col-md-3">
					<input type="text" id="telefono" name="telefono" value="<?php echo $obj->telefono;?>" readonly="true" placeholder="Telefono" class="form-control input-sm">
				  </div>
				</div>
				

            </div>
			

			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="alert alert-danger" id="msg-parte" style="display:none;" class="text-center" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Falta Ingresar Producto.
				</div>
			</div>			
			
			<div class="col-xs-12 col-sm-12 col-md-12">			
				<div class="table-responsive">
					<table class="table table-hover" style="font-size:12px">
						<thead style='background-color:#428bca;color:#fff'>
							<tr>
								<td>ITEM</td>
								<td>DESCRIPCION</td>
								<td>CANTIDAD</td>
								<td>PRECIO</td>
								<td>IMPORTE</td>
							</tr>
						</thead>
						<tbody id='detalle_producto'>
													
<?php $c=0;foreach ($detalle as $key=>$val) { $c++;?>							
<tr id="<?php echo $c;?>" class="tr_p">
<td><?php echo $c;?><input type="hidden" name="codigo[]" id="codigo[]"  value="<?php echo $val[0];?>" ></td>
<td width="50%"><input type="hidden" name="producto[]" id="producto[]"  size="40" value="<?php echo $val[1];?>" ><?php echo $val[1];?></td>

<td width="15%">
<input type="hidden" id="canti[]"  size="5" name="canti[]" value="<?php echo $val[3];?>"><?php echo $val[3];?>
</td>

<td width="18%">
<input id="precios[]" type="hidden" size="5" value="<?php echo $val[2];?>" name="precios[]"><?php echo $val[2];?>
</td>

<td width="17%">
<input id="sub[]" type="hidden" size="10" value="<?php echo $val[4];?>" name="sub[]"><?php echo $val[4];?>
</td>

</tr>
					<?php } ?>
					
						</tbody>
						<input type='hidden' id='i' name='i' value='<?php echo $c;?>'/>
					</table>
					
					<div class="col-xs-12 col-sm-12 col-md-12">	
						<div class="col-xs-12 col-sm-8 col-md-7"></div>		
						<div class="col-xs-12 col-sm-4 col-md-5">	
							<table class="table">
									<tr>
										<td class="text-right">SUB - TOTAL S/.</td>
										<td class="text-center">
											<div id="totalgeneral"><?php echo $obj->total;?></div>
											<input type="hidden" name="totalcompra" id="totalcompra" value='<?php echo $obj->total;?>'/>
										</td>
									</tr>
									<tr>
										<td class="text-right">I.G.V. %</td>
										<td class="text-center">
											<div id="igv_total"></div>										
											<div class="form-group">
												<div class="col-md-4">
													<input type="text" name="igv_venta" id="igv_venta" disabled class="form-control input-sm" value='0 %' onkeypress="return permite(event,'num')"/>
												</div>
												
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-right">TOTAL S/.</td>
										<td class="text-center">
											<div id="total_igv"><?php echo $obj->total;?></div>
											<input type="hidden" name="totalcompra_igv" id="totalcompra_igv" value="<?php echo $obj->total;?>"/>
										</td>
									</tr>
							</table>
						</div>
					</div>	
				</div>
            </div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="col-xs-12 col-sm-1 col-md-1"></div>
				<div class="col-xs-12 col-sm-11 col-md-11">
					<div class="form-group">
					  <label class="col-md-2 control-label" for="selectbasic">Observaci&oacute;n: </label>
					  <div class="col-md-8">
						<input type='text' name='observacion' id='observacion' value="<?php echo $obj->observacion; ?>" placeholder="Observacion de Compra" class="form-control input-sm"/>
					  </div>
					</div>
				</div>
            </div>
			
			
			<div class="form-group">
			  <div class="col-md-12 text-center">
				 <label class="col-md-12" for="selectbasic">Responsable: <?php echo $obj->usuario;?></label>
			  </div>
			</div>
			
			<hr style="border-top: 1px solid #e5e5e5; width:100%"/>
	
			
			
			<div class="form-group">
			  <div class="col-md-12 text-center">
				<input type="button" value="Cerrar" onclick="closeWindow();" class="btn btn-success"/>
			  </div>
			</div>
			
			

			</fieldset>
        </form>


