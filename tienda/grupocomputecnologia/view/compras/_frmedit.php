<?php require_once('lib/funciones.php'); ?>

        <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?></legend>
			
			<input type="hidden" name="idcompra" id="idcompra" value="<?php echo $obj->idcompra;?>"/>
			<input type="hidden" name="idproveedor" id="idproveedor" value="<?php echo $obj->idproveedor;?>"/>
			<input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
			<input type="hidden" name="idproducto" id="idproducto" value="<?php echo $obj->idproducto;?>"/>
			<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $obj->idusuario;?>"/>
			
		
			<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="col-xs-12 col-sm-5 col-md-5">
									
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Nro. factura: </label>
				  <div class="col-md-6">
					<input type="text" name='nro_comprobante' id='nro_comprobante' value="<?php echo $obj->nro_factura;?>" placeholder="Nro. factura" class="form-control input-sm">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Tipo de Cambio: </label>
				  <div class="col-md-6">
					<input type="text" name='tipocambio' id='tipocambio' value="<?php echo $obj->tipocambio;?>" placeholder="Cambio" class="form-control input-sm">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Producto: </label>
				  <div class="col-md-6">                     
					<textarea class="form-control" id="producto" name="producto"></textarea>
				  </div>
				  <div class="col-md-1">
						<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_producto">
						  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</button>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Incluye IGV: </label>
				  <div class="col-md-1">
					<input type='checkbox' name='chek_igv' id='chek_igv'/>
				  </div>
				  <label class="col-md-3 control-label" for="selectbasic">IGV%: </label>
				  <div class="col-md-2">
					<input type='text' name='igv' id='igv' value="18" placeholder="IGV" class="form-control input-sm"/>
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Precio $ </label>
				  <div class="col-md-4">                     
					<input type="text" name='sin_igv' id='sin_igv' <?php $tipo = $obj->tipocompra; if($tipo == 1){ echo "disabled";} ?> placeholder="Precio Dolares" class="form-control input-sm">
				  </div>
				  <div class="col-md-1">    
					  <input class='radio precio_radio' type='radio' name='precio' id='precio' <?php  if($tipo == 2){ echo 'checked="checked"';} ?>>
				  </div>
				  <div class="col-md-3">                     
					<input type="text" id='costo_ant_dolares' disabled placeholder="Precio Anterior" class="form-control input-sm" onkeypress="return permite(event,'num')" >
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Precio S/. </label>
				  <div class="col-md-4">                     
					<input type="text"  name='con_igv' id='con_igv'  <?php if($tipo == 2){ echo "disabled";} ?>  placeholder="Precio Soles" class="form-control input-sm" >
				  </div>
				  <div class="col-md-1">    
					  <input class='radio igv_radio' type='radio' name='precio' id='precio'  <?php  if($tipo == 1){ echo 'checked="checked"';} ?> />
				  </div>
				  <div class="col-md-3">                     
					<input type="text" id='costo_ant_soles' disabled placeholder="Precio Anterior" class="form-control input-sm" onkeypress="return permite(event,'num')" >
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-9 control-label" for="textarea">Stock: </label>
				  <div class="col-md-3">                     
					<input type="text"  name='stock_P' id='stock_P'  disabled placeholder="Stock" class="form-control input-sm" onkeypress="return permite(event,'num')"  >
				  </div>
				</div>
				
				
				
				

            </div>
			<div class="col-xs-12 col-sm-1 col-md-1"></div>
            <div class="col-xs-12 col-sm-6 col-md-6">
			
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Proveedor: </label>
				  <div class="col-md-6">
					<input type="text" id="proveedor" name="proveedor" value="<?php echo $obj->proveedor;?>" readonly="true" placeholder="Nombres" class="form-control input-sm">
				  </div>
				  <div class="col-md-1">   
						<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_pro">
						  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</button>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Fecha: </label>
				  <div class="col-md-6">
					<input type="text" name='fecha' id='fecha' value="<?php echo validar_fecha($obj->fecha); ?>" placeholder="Fecha" class="form-control input-sm">
				  </div>
				</div>
				
				
				
            </div>
            </div>
			
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="col-xs-12 col-sm-1 col-md-1"></div>
				<div class="col-xs-12 col-sm-5 col-md-5">
					<div class="form-group">
					  <label class="col-md-4 control-label" for="selectbasic">Cantidad: </label>
					  <div class="col-md-6">
						<input type='text'   name='cant' id='cant'  placeholder="Cantidad" class="form-control input-sm" onkeypress="return permite(event,'num')" />
					  </div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-1 col-md-1"></div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
					  <label class="col-md-4 control-label" for="selectbasic">Precio de Venta: </label>
					  <div class="col-md-6">
						<input type='text' name='precio_v' id='precio_v' placeholder="Precio" class="form-control input-sm"/>
					  </div>
					</div>
				</div>

            </div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="col-xs-12 col-sm-1 col-md-1"></div>
				<div class="col-xs-12 col-sm-11 col-md-11">
					<div class="form-group">
					  <label class="col-md-2 control-label" for="selectbasic">Serie: </label>
					  <div class="col-md-7">
						<input type='text' name='glosa' id='glosa' placeholder="Serie de Producto" class="form-control input-sm"/>
					  </div>
					  <div class="col-md-1">
						<button type="button" id="agregarc" class="btn btn-sm btn-primary" aria-label="Left Align">
						  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</button>
					  </div>
					</div>
				</div>
            </div>
			
			<div class="col-xs-12 col-sm-12 col-md-12"><div class="alert alert-danger" id="msg-parte" style="display:none;" class="text-center" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Falta Ingresar Producto.</div></div>			
			<div class="col-xs-12 col-sm-12 col-md-12">			
				<div class="table-responsive">
					<table class="table table-hover">
						<thead style='background-color:#428bca;color:#fff'>
							<tr>
								<td>ITEM</td>
								<td>DESCRIPCION</td>
								<td>SERIE</td>
								<td>CANTIDAD</td>								
								<td>PRECIO</td>
								<td>IMPORTE</td>
								<td>ACCION</td>
							</tr>
						</thead>
						<tbody id='detalle_producto'>
						
<?php $c=0;$total_pago=0;foreach ($detalle as $key=>$val) { $c++;$total_pago = $total_pago + $val[4]; ?>							
<tr id="<?php echo $c;?>" class="tr_p">
<td>
	<input name="codigo[]" id="codigo[]" type="hidden" value="<?php echo $val[0];?>" ><?php echo $c;?>
</td>
<td width="45%"><?php echo $val[1];?><!--descripcion del producto--></td>

<td width="20%">
<input type="text" class='form-control input-sm' id="glosa[]"  name="glosa[]" value="<?php echo $val[7];?>">
</td>

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
<td width="5%">
<a class="btn btn-xs btn-danger" href="javascript:eliminar_p(<?php echo $c;?>,<?php echo $val[4];?>,<?php echo $obj->idcompra;?>,<?php echo $val[0];?>);"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>
</td>

</tr>
					<?php } $total_pago = number_format($total_pago,2,'.','');  ?>	
					
						</tbody>
						<input type='hidden' id='i' name='i' value='<?php echo $c;?>'/>
					</table>
					
					<div class="col-xs-12 col-sm-12 col-md-12">	
						<div class="col-xs-12 col-sm-8 col-md-8"></div>		
						<div class="col-xs-12 col-sm-4 col-md-4">	
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
											<div id="totalgeneral"><?php echo $total_pago;?></div>
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
													
													<input type="text" name="igv_venta" id="igv_venta" value="<?php echo $IGV; ?>" class="form-control input-sm" onkeypress="return permite(event,'num')"/>
												</div>
												<div class="col-md-1">
													<input type='checkbox' name='_igv' id='_igv'  <?php  echo $check_IGV; ?> />
												</div>
											</div>
										</td>
									</tr>
									
									<tr>
										<td class="text-right">Descuento: </td>
										<td class="text-center">									
											<div class="form-group">
												<div class="col-md-6">
												<input type="text" name="descuento" id="descuento" class="form-control input-sm" value='<?php echo $obj->descuento; ?>' />
												</div>
												<div class="col-md-1">
													<input type='checkbox' name='_descuento' id='_descuento'<?php echo $check_dcto; ?>  />
												</div>
											</div>
										</td>
									</tr>
									
									
									<tr>
										<td class="text-right">Total <?php echo $SIGNO; ?></td>
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
				<?php $tipo = $obj->tipocompra; if($tipo==1){ $TipoMoneda = "Compra realizada en Moneda Local";}else{ $TipoMoneda = "Compra realizada en Moneda Extranjera al tipo de cambio: ".$obj->tipocambio;} ?>
									
				<div class="alert alert-success" class="text-center" role="alert"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> <?php echo $TipoMoneda; ?> </div>
			</div>	

			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="col-xs-12 col-sm-1 col-md-1"></div>
				<div class="col-xs-12 col-sm-11 col-md-11">
					<div class="form-group">
					  <label class="col-md-2 control-label" for="selectbasic">Observacion: </label>
					  <div class="col-md-8">
						<input type='text' name='observacion' id='observacion' value="<?php echo $obj->observacion; ?>" placeholder="Observacion de Compra" class="form-control input-sm"/>
					  </div>
					</div>
				</div>
            </div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
					  <label class="col-md-12" for="selectbasic">Responsable: <?php echo $obj->usuario;?></label>
			</div>
			
			<hr style="border-top: 1px solid #e5e5e5; width:100%"/>
			
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

<script type="text/javascript" src="web/js/evnt/compras_edit.js" ></script>


