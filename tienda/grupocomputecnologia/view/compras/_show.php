<?php require_once('lib/funciones.php'); ?>
        <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?><button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button></legend>
			
		
			<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="col-xs-12 col-sm-1 col-md-1"></div>
			<div class="col-xs-12 col-sm-5 col-md-5">
									
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Proveedor: </label>
				  <div class="col-md-6">
					<input type="text" id="proveedor" ReadOnly name="proveedor" value="<?php echo $obj->proveedor;?>" placeholder="Nombres" class="form-control input-sm">
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Direcci&oacute;n: </label>
				  <div class="col-md-6">
					<input type="text" id="direccion" name="direccion" ReadOnly value="<?php echo $obj->direccion;?>"  placeholder="Nombres" class="form-control input-sm">
				  </div>
				</div>


            </div>
			<div class="col-xs-12 col-sm-1 col-md-1"></div>
            <div class="col-xs-12 col-sm-4 col-md-4">
			
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Nro. factura: </label>
				  <div class="col-md-6">
					<input type="text" name='nro_comprobante' id='nro_comprobante' ReadOnly value="<?php echo $obj->nro_factura;?>" placeholder="Nro. factura" class="form-control input-sm">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Fecha: </label>
				  <div class="col-md-6">
					<input type="text"  value="<?php echo validar_fecha($obj->fecha); ?>" placeholder="Fecha" ReadOnly class="form-control input-sm">
				  </div>
				</div>
				
				
            </div>
            </div>

			
			<div class="col-xs-12 col-sm-12 col-md-12"><div class="alert alert-danger" id="msg-parte" style="display:none;" class="text-center" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Falta Ingresar Producto.</div></div>			
			<div class="col-xs-12 col-sm-12 col-md-12">			
				<div class="table-responsive">
					<table class="table table-hover" style="font-size:12px">
						<thead style='background-color:#428bca;color:#fff'>
							<tr>
								<td>ITEM</td>
								<td>DESCRIPCION</td>
								<td>SERIE</td>
								<td>CANTIDAD</td>
								<td>PRECIO</td>
								<td>IMPORTE</td>
							</tr>
						</thead>
						<tbody id='detalle_producto'>
						
<?php $c=0;$total_pago=0;foreach ($detalle as $key=>$val) { $c++;$total_pago = $total_pago + $val[4]; ?>							
<tr id="<?php echo $c;?>" class="tr_p">
<td><input name="codigo[]" id="codigo[]" type="hidden" value="<?php echo $val[0];?>" ><?php echo $c;?></td>
<td width="45%"><?php echo $val[1];?><!--descripcion del producto--></td>

<td width="20%"><?php echo $val[7];?></td>

<td width="10%">
<input type="hidden" id="canti[]"  name="canti[]" value="<?php echo $val[3];?>">
<input type="hidden" id="sub_producto[]" name="sub_producto[]" value="<?php echo $val[4];?>">
<?php echo $val[3];?>
</td>

<td width="10%">
<input id="precios[]" name="precios[]" type="hidden"  value="<?php echo $val[2];?>" >
<input name="precio_c[]" id="precio_c[]" type="hidden" value="<?php echo $val[5];?>">
<input name="precio_v[]" id="precio_v[]" type="hidden" value="<?php echo $val[6];?>">
<?php echo $val[2];?>
</td>

<td width="10%">
<input id="sub[]" name="sub[]" type="hidden" value="<?php echo $val[4];?>" >
<?php echo $val[4];?>
</td>

</tr>
					<?php } ?>	
					
						</tbody>
						
					</table>
					
					<div class="col-xs-12 col-sm-12 col-md-12">	
						<div class="col-xs-12 col-sm-6 col-md-6"></div>		
						<div class="col-xs-12 col-sm-6 col-md-6">	
							<table class="table">
									<?php  if($obj->tipocompra==1){ 
												$TipoMoneda = "Compra realizada en Moneda Local";
												$SIGNO = "S/.";
											}else{ 
												$TipoMoneda = "Compra realizada en Moneda Extranjera al tipo de cambio: ".$obj->tipocambio;
												$SIGNO = "$/."; 
											} ?>
									<tr>
										<td class="text-right">Sub Total <?php echo $SIGNO; ?></td>
										<td class="text-center">
											<div id="totalgeneral"><?php echo number_format($total_pago, 2, '.', ' '); ?></div>
											<input type="hidden" name="totalcompra" id="totalcompra" value="<?php echo $total_pago;?>"/>
										</td>
									</tr>
									<tr>
										<td class="text-right">I.G.V. %</td>
										<td class="text-center">
											<div id="igv_total"></div>										
											<div class="form-group">
												<div class="col-md-6">
												
												<?php 
													
													
													 $total_d=$obj->total_d;
													 
													 if($total_d > $total_pago){
													 
															if($obj->descuento>0){// DESCUENTO ACTIVADO MAS IGV
																	
																	$total_compra = $total_d + $obj->descuento;
																	$IGV = (($total_compra-$total_pago)*100)/$total_pago;
																	$IGV = round($IGV,2);
																	$check_IGV = 'checked="checked"';
																	$check_dcto = 'checked="checked"';
																	
																	
																	
															}else{ // SIN DESCUENTO -- SOLO IGV
																$IGV = (($total_d - $total_pago)*100)/$total_pago; 
																$IGV = round($IGV,2);
																$check_IGV = 'checked="checked"';
																$check_dcto = '';
															}

													 }elseif($total_d < $total_pago){
															$check_IGV = '';
															$check_dcto = 'checked="checked"';
															$IGV = 18;
													 
													 }else{ // significa que son iguales subtotal con el total
														$check_IGV = "";
														$check_dcto = "";
														$IGV = 18;
													 } 
													
													?> 
												
													<input type="text" name="igv_venta" id="igv_venta" value="<?php echo $IGV; ?>" class="form-control input-sm" Readonly="True"/>
												</div>
												<div class="col-md-1">
													<input type='checkbox' <?php  echo $check_IGV; ?> disabled />
												</div>
											</div>
										</td>
									</tr>
									
									<tr>
										<td class="text-right">Descuento: </td>
										<td class="text-center">									
											<div class="form-group">
												<div class="col-md-6">
												<input type="text" name="descuento" id="descuento" class="form-control input-sm" value='<?php echo $obj->descuento; ?>' ReadOnly="True" />
												</div>
												<div class="col-md-1">
													<input type='checkbox' name='_descuento' id='_descuento'<?php echo $check_dcto; ?> disabled />
												</div>
											</div>
										</td>
									</tr>
									
									
									<tr>
										<td class="text-right">Total <?php echo $SIGNO; ?> </td>
										<td class="text-center">
											<div id="total_igv"><?php echo $obj->total_d;?></div>
											<input type="hidden" name="totalcompra_igv" id="totalcompra_igv" value="<?php echo $obj->total_d;?>"/>
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
						<input type='text' name='observacion' id='observacion' value="<?php echo $obj->observacion; ?>" Readonly placeholder="Observacion de Compra" class="form-control input-sm"/>
					  </div>
					</div>
				</div>
            </div>
			
			<div class="form-group">
			
				<div class="col-xs-12 col-sm-12 col-md-12 text-center">		
				<div class="alert alert-info"  role="alert"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> <?php echo $TipoMoneda; ?> </div>
				</div>	
				
				<?php if($obj->tipocompra==2){ ?>
				<div class="col-xs-12 col-sm-12 col-md-12 text-center">		
				<div class="alert alert-success"  role="alert"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
				Pago de Factura en Moneda Local: S/.<?php $pago_local = round($obj->total_d*$obj->tipocambio,2); echo number_format($pago_local, 2, '.', ' '); ?> </div>
				</div>		
				<?php } ?>
				
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




