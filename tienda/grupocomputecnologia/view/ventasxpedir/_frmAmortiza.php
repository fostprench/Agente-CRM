<script type="text/javascript" src="web/js/evnt/amortizar.js" ></script>
<script type="text/javascript" src="web/js/evnt/<?php echo $JS; ?>" ></script>

<?php if($mensaje){?>

		 <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?></legend>
			
			<input type="hidden" name="idventa" id="idventa" value="<?php echo $idventa; ?>"/>
			<input type="hidden" name="idusuario" id="idusuario" value="<?php echo $_SESSION['id_usuario'];?>"/>
			<input type="hidden" name="user" id="user" value="<?php echo $_SESSION['user'];?>"/>
			<input type="hidden" name="tipo_amortizacion" id="tipo_amortizacion" value="VentasxPedir"/>
		
		

				<div class="col-xs-12 col-sm-5 col-md-5">
					<div class="form-group">
						<label class="col-md-4 control-label" for="selectbasic">Cliente: </label>
						<div class="col-md-8">
							<input type="text"  id="cliente" name="cliente" value="<?php echo $obj->cliente;?>" readonly="true" class="form-control input-sm" >
						</div>
				    </div>
					<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">Nro.Comprobante: </label>
						  <div class="col-md-8">
							<input type="text"  id="comprobante" name="comprobante" value='<?php echo $obj->nro_comprobante;?>' readonly="true"  class="form-control input-sm">
						  </div>
					</div>
					<div class="form-group">
						   <label class="col-md-4 control-label" for="selectbasic">Fecha: </label>
						  <div class="col-md-8">
							<input type="text" value="<?php echo validar_fecha($obj->fecha);?>" readonly="true"  class="form-control input-sm">
						  </div>
					</div>
					<div class="form-group">
						   <label class="col-md-4 control-label" for="selectbasic">Monto Comprobante: </label>
						  <div class="col-md-8">
							<input type="text" id="monto_comprobante" name="monto_comprobante" value="<?php echo $obj->total;$total = $obj->total;?>" readonly="true"  class="form-control input-sm">
						  </div>
					</div>
					<div class="form-group">
						   <label class="col-md-4 control-label" for="selectbasic">Total Amortizaciones:</label>
						  <div class="col-md-8">
							<input type="text" id="total_amortizaciones" value="<?php if($total_amortizacion != NULL){echo $total_amortizacion;$amortizaciones=$total_amortizacion;}else{echo "0.00";$amortizaciones=0;}?>" <?php if($total_amortizacion != NULL){ echo "style='color:#3c763d'";}else{echo "style='color:#a94442'";}?> readonly="true"  class="form-control input-sm">
						  </div>
					</div>
					<div class="form-group">
							<label class="col-md-4 control-label" for="selectbasic">Total de Deuda: </label>
							<div class="col-md-8">
								<input type="text" id="deuda" name="deuda" value="<?php $t =$total-$amortizaciones; echo number_format((float)$t, 2, '.', '');?>" style='color:#a94442' readonly="true"  class="form-control input-sm">
							</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-1 col-md-1">
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
						  <label class="col-md-2 control-label" for="selectbasic">Cantidad: </label>
						  <div class="col-md-3">
							<input type="text" id="monto_amortizacion" name="monto_amortizacion"   placeholder="Monto Amortizar" class="form-control input-sm" onkeypress="return permite(event,'num')">
						  </div>
						  <label class="col-md-2 control-label" for="selectbasic">Fecha: </label>
						  <div class="col-md-3">
							<input type="text" id="fecha" name="fecha"   placeholder="Fecha" value="<?php echo date('d-m-Y');?>" class="form-control input-sm">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-md-2 control-label" for="selectbasic">Descripci&oacute;n: </label>
						  <div class="col-md-8">
						    <textarea class="form-control" id="descripcion" rows="3" name="descripcion"><?php echo "AMORTIZACION COMPROBANTE ".$obj->nro_comprobante.' -- '.$obj->cliente;?></textarea>
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-md-2 control-label" for="selectbasic">Operaci&oacute;n: </label>
						  <div class="col-md-8">
							<input type="text" id="operacion" name="operacion"   placeholder="Nro. Operacion" class="form-control input-sm">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-md-2 control-label" for="selectbasic">Observaci&oacute;n: </label>
						  <div class="col-md-8">
						    <textarea class="form-control" id="observaciones" rows="2" name="observaciones">Obs. </textarea>
						  </div>
						</div>
						<div class="form-group">
						  <div class="col-md-12 text-center">   
								<button type="button" class="btn btn-success" aria-label="Left Align" id="monto_amortizar">
								  ACEPTAR
								</button>
								<button type="button" class="btn btn-success" aria-label="Left Align" Disabled="true" style="display:none" id="btnOculto">
								  ACEPTAR
								</button>
						  </div>
						</div>	
				</div>
						
				<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="alert alert-success" id="msg-parte" style="display:none;"  role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">
							<strong>Guardando Amortizaci&oacute;n...<img src="images/ajax-loader.gif"></strong> Por Favor Espere.
				</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">			
				<div class="table-responsive">
					<table class="table table-hover">
						<thead style='background-color:#428bca;color:#fff'>
							<tr>
								<td>ID</td>
								<td>FECHA</td>
								<td>USUARIO</td>
								<td>MONTO</td>
								<td>ACCION</td>
							</tr>
						</thead>
						<tbody id='detalle_producto'>
													
<?php $totalcompra=0;$c=0;if($detalle){foreach ($detalle as $key=>$val) { $c++; $totalcompra = $totalcompra + $val[3];?>							
<tr id="fila_<?php echo $c;?>" class="tr_p">
<td><input type="hidden" value="<?php echo $c;?>" ><?php echo $c;?></td>
<td><?php echo $val[1];?></td>
<td><?php echo $val[2];?></td>
<td><?php echo $val[3];?></td>
</td>
<td>
	<div id="eliminado_<?php echo $val[0];?>">
	
		<?php if($_SESSION['delete']==1){ ?>
		<a class="btn btn-danger btn-sm"  href="javascript:eliminar_p('<?php echo $c;?>','<?php echo $val[0];?>','<?php echo $obj->idventa;?>','<?php echo $val[3];?>');"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>
		<?php } ?>
		
		<a href="javascript:popup('index.php?controller=Amortizar&action=_prinft&idm=<?php echo $val[0];?>',850,500)" title='Ver'><button type='button' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-print' aria-hidden='true'></span> </button></a>
	
	</div>
	

</td>

</tr>
					<?php }}else{ ?>
					<tr>
						<td colspan="5" class="text-center alert-danger">NO HAY PAGOS REGISTRADOS</td>
					</tr>
					<?php } ?>
					
						</tbody>
						<tr>
							<td colspan="3" class="text-right">
							<label class="control-label" for="selectbasic">TOTAL DE AMORTIZACIONES: </label>
							 </td>
							<td>
								<label class="control-label" id="txt_total"><?php echo number_format($totalcompra,2,'.',''); ?></label>
							</td>
							<td></td>
						</tr>
						<input type='hidden' id='i' name='i' value='<?php echo $c;?>'/>
					</table>
					
						
				</div>
            </div>
			
			
		
			
			<div style="padding-top:20px;">&nbsp;</div>
		
			
			
			<div class="col-xs-12 col-sm-12 col-md-12">
					  <label class="col-md-12" for="selectbasic">Responsable: <?php echo $_SESSION['usuario'];?></label>
			</div>
			
			<hr style="border-top: 1px solid #e5e5e5; width:100%"/>
			
		

			
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

<?php }else { ?>
		<form class="form-horizontal">
		<div class="form-group">
			  <div class="col-md-12 text-center">
					<div class="alert alert-danger" id="msg-parte" class="text-center" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><?php echo $msg; ?></div>
			  </div>
		</div>
		<div class="form-group">
			  <div class="col-md-12">
				<input type="button" name="regresar" id="regresar" value="atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
		</div>
		</form>
<?php } ?>

       

					 