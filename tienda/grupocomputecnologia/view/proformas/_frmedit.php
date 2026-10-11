<style type="text/css">
.badgebox{
    opacity: 0;
}

.badgebox + .badge{
    text-indent: -999999px;
	width: 27px;
}

.badgebox:focus + .badge{
    box-shadow: inset 0px 0px 5px;
}

.badgebox:checked + .badge{
	text-indent: 0;
}
</style>
<?php require_once('lib/funciones.php'); ?>
<script type="text/javascript" src="web/js/evnt/proformas.js" ></script>

		 <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?></legend>
			
			<input type="hidden" name="idproformas" id="idproformas" value="<?php echo $obj->idproformas;?>" />
			<input type="hidden" name="idcliente" id="idcliente" value="<?php echo $cliente->idcliente;?>" />
			<input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
			<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario'];?>"/>
		
		
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="col-xs-12 col-sm-4 col-md-4">
					<img src="web/images/<?php echo $_SESSION['logo'];?>" class="img-responsive" style="border:0;margin:0 auto"/>	
					<span class='nombre'><?php echo $_SESSION['propietario'];?></span><br/>
					<span class='descripcion'><?php echo $_SESSION['descripcion'];?></span><br/>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3">
					<span class='descripcion'><?php echo $_SESSION['direccion'];?><br/><?php echo $_SESSION['telefono'];?></span>
				</div>
				<div class="col-xs-12 col-sm-5 col-md-5">
				
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">PROFORMA Nº </label>
						  <div class="col-md-8">
							<input type="text" value="<?php echo $correlativo; ?>" placeholder="Nro. Proforma" Readonly="True" class="form-control input-sm">
						  </div>
						</div>
						
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">Moneda: </label>
						  <div class="col-md-8">
							<select name="moneda" id="moneda" class="form-control">
								<option <?php if($obj->moneda==1){echo "selected";} ?> value="1">Soles</option>
								<option <?php if($obj->moneda==2){echo "selected";} ?> value="2">Dolares</option>
							</select>
						  </div>
						</div>
						
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">F. Emisi&oacute;n </label>
						  <div class="col-md-3">
							<input type="text" name='fecha_emision' id='fecha_emision' value="<?php echo validar_fecha($obj->fecha_emision);?>"  placeholder="Fecha Emision" class="form-control input-sm">
						  </div>
						   <label class="col-md-2 control-label" for="selectbasic">F. Venc  </label>
						  <div class="col-md-3">
							<input type="text" name='fecha_caducidad' id='fecha_caducidad' value="<?php echo validar_fecha($obj->fecha_caducidad);?>" placeholder="Fecha Caducidad" class="form-control input-sm">
						  </div>
						</div>
						
						
				
				</div>
			</div>
			<div style="padding-top:10px;">&nbsp;</div>
		
			
	
			<div class="col-xs-12 col-sm-12 col-md-12">
			
				<div class="form-group">
					  <label class="col-md-1 control-label" for="selectbasic">Se&ntilde;or(a): </label>
					   <div class="col-md-5">
						  <div class="input-group">
									<input type="text" id="cliente" name="cliente" value="<?php echo strtoupper(utf8_decode($cliente->nombres));?>" readonly="true" placeholder="Cliente" class="form-control input-sm">
									<span class="input-group-btn">
										<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_cli" title="Buscar Cliente">
										  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
										</button>
									</span>
						 </div>
					 </div>
					 <div class="col-xs-12 col-sm-6 col-md-6"> 
						    <label for="primary" class="btn btn-primary">Mostrar Precios <input type="checkbox" id="primary" name="mostrar_precios" class="badgebox" <?php $muestraprecios = $obj->muestraprecios; if( $muestraprecios==1){echo "checked='checked'";}; ?>><span class="badge">&check;</span></label>

					  </div>
				</div>
			
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="alert alert-danger" id="msg-parte" style="display:none;" class="text-center" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Falta Ingresar Producto.
				</div>
			</div>		

			<div class="col-xs-12 col-sm-12 col-md-12">
						 
							<div class="form-group">
								  <label class="col-md-1 control-label" for="textarea">MODELO: </label>
								   <div class="col-md-11">											
										<input type="text" id="MODELO" name="MODELO" value="<?php echo $obj->descripcion;?>" placeholder="MODELO" class="form-control input-sm">
								  </div>
							</div>
				</div>
			
			
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<h4 class="text-left proforma_h4">COMPUTADORA</h4>
				<span class="proforma_span"></span>
			</div>
			
			<div style="padding-top:10px;">&nbsp;</div>
			
		
				<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="form-group">
							  <label class="col-md-4 control-label" for="selectbasic">% Ganancia:</label>
							  <div class="col-md-6">
								<input type="text" id="ganancia" name="ganancia" value="<?php echo $obj->descuento;?>" class="form-control input-sm" placeholder="Descuento">
							  </div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="form-group">
							  <label class="col-md-4 control-label" for="selectbasic">Cantidad: </label>
							  <div class="col-md-6">
									<input type="number" min="1" max="9" step="1" id="cantidad" name="cantidad" value="<?php echo $obj->cantidad;?>" class="form-control input-sm" placeholder="Cantidad">
							  </div>
							</div>					
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="form-group">
							  <label class="col-md-5 control-label" for="selectbasic">Precio Unitario: </label>
							  <div class="col-md-6">
									<input type="text"  id="precio_unitario" name="precio_unitario" ReadOnly="True" value="<?php echo $obj->precio_unitario;?>" class="form-control input-sm" placeholder="Precio Unit.">
									<input type="hidden"  id="precio_unitario_hidden" name="precio_unitario_hidden" value="<?php echo (($obj->precio_unitario*100) / (100+$obj->descuento));?>">
							  </div>
							</div>					
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
								<div class="form-group">
							  <label class="col-md-5 control-label" for="selectbasic">Precio Total: </label>
							  <div class="col-md-6">
									<input type="text"  id="precio_total" name="precio_total" ReadOnly="True" value="<?php echo $obj->total_proforma;?>" class="form-control input-sm" placeholder="Total">
							  </div>
							</div>				
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-12">
								
								<div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail" id="focus1">
									  <img src="images/procesador.jpg" alt="Procesador" class="buscar_componente pointer" data-cat="1">
									  Procesador
								   </div>
								 </div>
								 
								<div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/mainboard.jpg" alt="Placa" class="buscar_componente pointer" data-cat="3">
									  Placa
								   </div>
								 </div>
								 
								 
								 <div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/ram.jpg" alt="Memoria" class="buscar_componente pointer" data-cat="4">
									  M. Ram
								   </div>
								 </div>
								 
								  <div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/disco.jpg" alt="HDD" class="buscar_componente pointer" data-cat="6">
									  HDD
								   </div>
								 </div>
								 
								  <div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/dvd.jpg" alt="DVD Drives" class="buscar_componente pointer" data-cat="8">
									  DVD_Drives
								   </div>
								 </div>
								 
								 <div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/red.jpg" alt="Red" class="buscar_componente pointer" data-cat="5">
									  T. Red
								   </div>
								 </div>
								 
								 <div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/tvideo.jpg" alt="T.Video" class="buscar_componente pointer" data-cat="13">
									  T. Video
								   </div>
								 </div>
								 
								 <div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/case.jpg" alt="Case" class="buscar_componente pointer" data-cat="2">
									  Case
								   </div>
								 </div>
								 
								 <div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/monitor.jpg" alt="Monitor" class="buscar_componente pointer" data-cat="7">
									  Monitor
								   </div>
								 </div>
								 
								 
								 <div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/teclado.jpg" alt="Teclado" class="buscar_componente pointer" data-cat="9">
									  Teclado
								   </div>
								 </div>
								 
								 <div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/mouse.jpg" alt="Mouse" class="buscar_componente pointer" data-cat="10">
									  Mouse
								   </div>
								 </div>
								 
								 <div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/parlante.jpg" alt="Parlante" class="buscar_componente pointer" data-cat="11">
									  Parlante
								   </div>
								 </div>
								 
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 text-center">
							<div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/estabilizador.jpg" alt="Establilizador" class="buscar_componente pointer" data-cat="12">
									  Estabilizador
								   </div>
							</div>
							<div class="col-xs-4 col-sm-2 col-md-1">
								<div class="thumbnail">
									<img src="images/ups.jpg" alt="UPS" class="buscar_componente pointer" data-cat="14">
									UPS
								</div>
							</div>
							<div class="col-xs-4 col-sm-2 col-md-1" style="font-size: 11px !important;">
								<div class="thumbnail">
									<img src="images/fuentepoder.jpg" alt="FUENTE PODER" class="buscar_componente pointer" data-cat="16">
									Fuente Poder
								</div>
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-12">
						
							<div class="col-xs-12 col-sm-7 col-md-7">
								<div class="form-group">
									   <label class="col-md-2 control-label" for="selectbasic">Producto:</label>
									   <div class="col-md-10">
											<input type="hidden" name="idproducto_pc" id="idproducto_pc"/>
											<input type="text" id="componente" name="componente" readonly="true" placeholder="Componente" class="form-control input-sm">
									   </div>
								</div>							
							</div>
							
							<div class="col-xs-12 col-sm-2 col-md-2">
								<div class="form-group">
								  <label class="col-md-4 control-label" for="selectbasic">Cant: </label>
								  <div class="col-md-6">
									<input type='number'  min="1" step="1"  name='cantidad_pc' id='cantidad_pc'  placeholder="Cantidad" class="form-control input-sm" onkeypress="return permite(event,'num')" />
								  </div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2">
								<div class="form-group">
								  <label class="col-md-4 control-label" for="selectbasic">Precio: </label>
								  <div class="col-md-6">
									<input type='text' name='precio_pc' id='precio_pc' placeholder="Precio"  class="form-control input-sm"/>
								  </div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-1 col-md-1">
								<div class="form-group">
								  <div class="col-md-4">
										  <button type="button" id="agregar_componente" class="btn btn-sm btn-primary" aria-label="Left Align">
										  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
										 </button>
								  </div>
								
								</div>
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="col-xs-12 col-sm-1 col-md-1"></div>
							<div class="col-xs-12 col-sm-10 col-md-10">
								<div class="table-responsive">
									<table class="table table-hover">
										<thead style='background-color:#428bca;color:#fff;font-weight:bold'>
											<tr>
												<td>ITEM</td>
												<td>DESCRIPCION</td>
												<td>CANTIDAD</td>
												<td>PRECIO</td>
												<td>ACCION</td>
											</tr>
										</thead>
										<tbody id='detalle_pc'>
										
										
															
<?php $c=0;foreach ($detalle_proforma as $key=>$val) { $c++; ?>							
<tr id="detalle_pc_<?php echo $c;?>" class="tr_primero">
<td  width='5%'>
	<input name="codigo[]" id="codigo[]" type="hidden" value="<?php echo $val[3];?>" ><?php echo $c;?>
</td>
<td width="75%">
			<input name='producto[]' id='producto[]' value='<?php echo $val[1];?>' type='hidden' />
			<?php echo $val[1];?>
			<!--descripcion del producto-->
</td>

<td width='5%'>
<input  name='canti[]' id='canti[]' type='hidden'  value="<?php echo $val[4];?>" class='form-control input-sm'><?php echo $val[4];?>
</td>

<td width="5%">
<input type="hidden" id="monto[]"  name="monto[]" value="<?php echo $val[5];?>">
<?php echo $val[5];?>
</td>
<td width="10%">

<a class="btn btn-xs btn-danger" href="javascript:eliminar_pc(<?php echo $c;?>,<?php echo $val[5];?>);"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>

<a class="btn btn-xs btn-info" href="javascript:_ver('index.php?controller=Productos&action=show&id=<?php echo $val[3];?>')"><span class='glyphicon glyphicon-zoom-in' aria-hidden='true'></span></a>

</td>

</tr>
					<?php } ?>	
										
										
										
										</tbody>
										<input type='hidden' id='j' name='j' value='0'/>
									</table>
								</div>
							</div>
							<div class="col-xs-12 col-sm-1 col-md-1"></div>
						</div>
						
						
				</div>
				
				
		
			
			
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<h4 class="text-left proforma_h4">OTROS</h4>
				<span class="proforma_span"></span>
			</div>
			
			<div style="padding-top:10px;">&nbsp;</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">	
				
				<div class="col-xs-12 col-sm-12 col-md-12">
				
						 
							<div class="form-group">
								  <label class="col-md-1 control-label" for="textarea">Producto: </label>
								   <div class="col-md-7">
									  <div class="input-group">
												
												<input type="text" id="producto" name="producto" readonly="true" placeholder="Producto" class="form-control input-sm">
												<input type="hidden" name="idproducto" id="idproducto" value="<?php echo $obj->idproducto;?>"/>
												<input type="hidden" name="stock" id="stock">
												<span class="input-group-btn">
													<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_producto" title="Buscar Cliente">
													  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
													</button>
												</span>
									 </div>
								  </div>
							</div>
				</div>
				
				
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="col-xs-12 col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">Cantidad: </label>
						  <div class="col-md-6">
							<input type='number'  min="1" step="1"  name='cant' id='cant'  placeholder="Cantidad" class="form-control input-sm" onkeypress="return permite(event,'num')" />
						  </div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">Precio: </label>
						  <div class="col-md-6">
							<input type='text' name='precio' id='precio' placeholder="Precio" class="form-control input-sm" onkeypress="return permite(event,'num')"/>
						  </div>
						</div>
					</div>
					
					<input type='hidden' name='ganancia_otro' id='ganancia_otro' value="0" />
					<!--
					<div class="col-xs-12 col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">% Ganancia: </label>
						  <div class="col-md-6">
							<input type='text' name='ganancia_otro' id='ganancia_otro' value="0" placeholder="Descuento" class="form-control input-sm"/>
						  </div>
						</div>
					</div>-->
					
					<div class="col-xs-12 col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="col-md-3 control-label" for="selectbasic">Garantia: </label>
						  <div class="col-md-5">
								<select name="garantia" id="garantia" class="form-control input-sm">
									<option value="0">SIN GARANTIA</option>
									<option value="1">1 Mes</option>
									<option value="3">3 Meses</option>
									<option value="6">6 Meses</option>
									<option value="12">12 Meses</option>
									<option value="18">18 Meses</option>
									<option value="24">24 Meses</option>
								</select>
						  </div>
						  <div class="col-md-4">
								  <button type="button" id="agregarc" class="btn btn-sm btn-primary" aria-label="Left Align">
								  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
								 </button>
						  </div>
						
						</div>
					</div>
				</div>
			
							
							
				<div class="col-xs-12 col-sm-1 col-md-1"></div>
				<div class="col-xs-12 col-sm-10 col-md-10">			
					<div class="table-responsive">
						<table class="table table-hover">
							<thead style='background-color:#428bca;color:#fff;font-weight:bold'>
								<tr>
									<td>ITEM</td>
									<td>DESCRIPCION</td>
									<td>CANT</td>
									<td>PRECIO</td>
									<td>IMPORTE</td>
									<td>GAN</td>
									<td>GAR.</td>
									<td>ACCION</td>
								</tr>
							</thead>
							<tbody id='detalle_producto'>
							
							
							<?php $d=0;foreach ($detalle_otros as $key=>$val2) { $d++; ?>							
<tr id="detalle_otro_<?php echo $d;?>" class="tr_p">
<td  width='5%'>
	<input name="codigo_otros[]" id="codigo_otros[]" type="hidden" value="<?php echo $val2[4];?>" ><?php echo $d;?>
</td>
<td width="48%">
			<input name='producto_otros[]' id='producto_otros[]' value='<?php echo $val2[1];?>' type='hidden' />
			<?php echo $val2[1];?>
			<!--descripcion del producto-->
</td>

<td width='5%'>
<input  name='canti_otros[]' id='canti_otros[]' type='hidden'  value="<?php echo $val2[2];?>" class='form-control input-sm'><?php echo $val2[2];?>
</td>

<td width="8%">
<input type="hidden" id="precios_otros[]"  name="precios_otros[]" value="<?php echo $val2[3];?>">
<?php echo $val2[3];?>
</td>

<td width="8%">
<input type="hidden" id="importe_otros[]"  name="importe_otros[]" value="<?php $sub_t = $val2[2]*$val2[3]; 
$format_sub = number_format($sub_t,2,'.',''); echo $format_sub; ?>">
<?php echo $format_sub; ?>
</td>

<td width="8%">
<input type="hidden" id="descuento[]"  name="descuento[]" value="<?php echo $val2[5];?>">
<?php echo $val2[5];?>
</td>

<td width="8%">
<input type="hidden" id="garantia[]"  name="garantia[]" value="<?php echo $val2[6];?>">
<?php echo $val2[6];?> M
</td>

<td width="10%">

<a class="btn btn-xs btn-danger" href="javascript:eliminar_otro(<?php echo $d;?>,<?php echo $format_sub;?>);"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>

<a class="btn btn-xs btn-info" href="javascript:_ver('index.php?controller=Productos&action=show&id=<?php echo $val2[4];?>')"><span class='glyphicon glyphicon-zoom-in' aria-hidden='true'></span></a>

</td>

</tr>
					<?php } ?>

							
							
							</tbody>
						</table>
						
						<div class="col-xs-12 col-sm-12 col-md-12">	
							<div class="col-xs-12 col-sm-8 col-md-6"></div>		
							<div class="col-xs-12 col-sm-4 col-md-4">	
								<table class="table">
										<tr>
											<td class="text-right">TOTAL S/.</td>
											<td class="text-left">
												<div id="txttotal_otros"><?php echo $obj->total_otro;?></div>
												<input type="hidden" name="total_otros" id="total_otros" value="<?php echo $obj->total_otro;?>"/>
											</td>
										</tr>
								</table>
							</div>
						</div>	
					</div>
				</div>
				<div class="col-xs-12 col-sm-1 col-md-1"></div>
            </div>
			
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<h4 class="text-left proforma_h4">OBSEQUIOS</h4>
				<span class="proforma_span"></span>
			</div>
			
			<div style="padding-top:10px;">&nbsp;</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
			
							
							<div class="col-xs-12 col-sm-12 col-md-12">
									<div class="col-xs-12 col-sm-7 col-md-7">							 
											<div class="form-group">
												  <label class="col-md-2 control-label" for="textarea">Producto: </label>
												   <div class="col-md-10">
													  <div class="input-group">
																
																<input type="text" id="producto_obs" name="producto_obs" readonly="true" placeholder="Producto" class="form-control input-sm">
																<input type="hidden" name="idproducto_obs" id="idproducto_obs"/>
																<span class="input-group-btn">
																	<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_obsequio" title="Buscar Cliente">
																	  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
																	</button>
																</span>
													 </div>
												  </div>
											</div>
								</div>
								<div class="col-xs-12 col-sm-2 col-md-2">
									<div class="form-group">
									  <label class="col-md-4 control-label" for="selectbasic">Cant: </label>
									  <div class="col-md-6">
										<input type='number'  min="1" max="9" step="1" name='cantidad_obs' id='cantidad_obs'  placeholder="Cantidad" class="form-control input-sm" onkeypress="return permite(event,'num')" />
									  </div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-2 col-md-2">
									<div class="form-group">
									  <label class="col-md-4 control-label" for="selectbasic">Precio: </label>
									  <div class="col-md-6">
										<input type='text' name='precio_obs' id='precio_obs' placeholder="P. COSTO" class="form-control input-sm"/>
									  </div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-1 col-md-1">
											  <button type="button" id="agregar_obsequio" class="btn btn-sm btn-primary" aria-label="Left Align">
											  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
											 </button>
								</div>
							</div>
							
							<div class="col-xs-12 col-sm-1 col-md-1"></div>
							<div class="col-xs-12 col-sm-10 col-md-10">
								<div class="table-responsive">
									<table class="table table-hover">
										<thead style='background-color:#428bca;color:#fff;font-weight:bold'>
											<tr>
												<td>ITEM</td>
												<td>DESCRIPCION</td>
												<td>CANT</td>
												<td>PRECIO</td>
												<td>IMPORTE</td>
												<td>ACCION</td>
											</tr>
										</thead>
										<tbody id='detalle_obs'>
										
										
										<?php $cc=0;foreach ($detalle_obsequios as $key=>$val3) { $cc++; ?>							
<tr id="detalle_obs_<?php echo $cc;?>" class="tr_obs">
<td  width='5%'>
	<input name="codigo_obs[]" id="codigo_obs[]" type="hidden" value="<?php echo $val3[4];?>" ><?php echo $cc;?>
</td>
<td width="53%">
			<input name='producto_obs[]' id='producto_obs[]' value='<?php echo $val3[1];?>' type='hidden' />
			<?php echo $val3[1];?>
			<!--descripcion del producto-->
</td>

<td width='8%'>
<input  name='canti_obs[]' id='canti_obs[]' type='hidden'  value="<?php echo $val3[2];?>" class='form-control input-sm'><?php echo $val3[2];?>
</td>

<td width="8%">
<input type="hidden" id="precios_obs[]"  name="precios_obs[]" value="<?php echo $val3[3];?>">
<?php echo $val3[3];?>
</td>

<td width="8%">
<input type="hidden" id="importe_obs[]"  name="importe_obs[]" value="<?php $sub_t2 = $val3[2]*$val3[3]; 
$format_sub2 = number_format($sub_t2,2,'.',''); echo $format_sub2; ?>">
<?php echo $format_sub2; ?>
</td>

<td width="10%">

<a class="btn btn-xs btn-danger" href="javascript:eliminar_obs(<?php echo $cc;?>,<?php echo $format_sub2;?>);"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>

<a class="btn btn-xs btn-info" href="javascript:_ver('index.php?controller=Productos&action=show&id=<?php echo $val3[4];?>')"><span class='glyphicon glyphicon-zoom-in' aria-hidden='true'></span></a>

</td>

</tr>
					<?php } ?>
										
										
										</tbody>
										<input type='hidden' id='j' name='j' value='0'/>
									</table>
									
									<div class="col-xs-12 col-sm-12 col-md-12">	
							<div class="col-xs-12 col-sm-8 col-md-8"></div>		
							<div class="col-xs-12 col-sm-4 col-md-4">	
								<table class="table">
										<tr>
											<td class="text-right">TOTAL S/.</td>
											<td class="text-left">
												<div id="txttotal_obsequios"><?php echo $obj->total_obsequio;?></div>
												<input type="hidden" name="total_obsequios" id="total_obsequios" value="<?php echo $obj->total_obsequio;?>"/>
											</td>
										</tr>
								</table>
							</div>
						</div>
						
								</div>
							</div>
							<div class="col-xs-12 col-sm-1 col-md-1"></div>
			</div>
		
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<span class="proforma_span"></span>
			</div>
			
			<div style="padding-top:10px;">&nbsp;</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="col-xs-12 col-sm-4 col-md-4"></div>
					<div class="col-xs-12 col-sm-5 col-md-5"></div>
					<div class="col-xs-12 col-sm-3 col-md-3">
						<div class="form-group">
							<?php if($obj->descuento_general>0){ $check ="checked='checked'"; }else{ $check=""; }?>
						  <label class="col-md-4 control-label" for="selectbasic">Descuento: </label>
						  <div class="col-md-5">
							<input type='text'   name='descuento_general' id='descuento_general' readonly="true" value="<?php echo $obj->descuento_general; ?>" class="form-control input-sm" onkeypress="return permite(event,'num')" />
						  </div>
						  <div class="col-md-1">
							<!--<input type='checkbox' name='_descuento' id='_descuento' <?php //echo $check; ?> /> -->
						  </div>
						</div>
					</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="form-group">
						  <label class="col-md-10 control-label" for="selectbasic">Mantenimiento Preventivo: </label>
						  <div class="col-md-2">
							<input type='number'   name='mantenimiento' id='mantenimiento' min="1" max="9" step="1" value="<?php echo $obj->mantenimiento; ?>" class="form-control input-sm" onkeypress="return permite(event,'num')" />
							<input type="hidden" name="general_hidden" id="general_hidden" value="0">
						  </div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-5 col-md-5"></div>
					<div class="col-xs-12 col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">Total General: </label>
						  <div class="col-md-6">
							<input type='text'   name='total_general' id='total_general' ReadOnly="True" value="<?php echo $obj->total_general;?>" class="form-control input-sm" onkeypress="return permite(event,'num')" />
						  </div>
						</div>
					</div>
			</div>
			

			
			<div class="col-xs-12 col-sm-12 col-md-12">
					  <label class="col-md-12" for="selectbasic">Responsable: <?php echo $_SESSION['usuario'];?></label>
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

		<script type="text/javascript" src="web/js/evnt/items_proforma.js" ></script>



       