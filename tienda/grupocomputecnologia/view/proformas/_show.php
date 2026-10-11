<?php require_once('lib/funciones.php'); ?>

		 <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?><button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button></legend>
			
			<input type="hidden" name="idproformas" id="idproformas" value="<?php echo $obj->idproformas;?>" />
			<input type="hidden" name="idcliente" id="idcliente" value="<?php echo $cliente->idcliente;?>" />
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
						  <label class="col-md-4 control-label" for="selectbasic">PROFORMA Nº </label>
						  <div class="col-md-8">
							<input type="text" value="<?php echo $correlativo; ?>" placeholder="Nro. Proforma" Readonly="True" class="form-control input-sm">
						  </div>
						</div>
						
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">Moneda: </label>
						  <div class="col-md-8">
							<select name="moneda" id="moneda" class="form-control" 	ReadOnly>
								<option <?php if($obj->moneda==1){echo "selected";} ?> value="1">Soles</option>
								<option <?php if($obj->moneda==2){echo "selected";} ?> value="2">Dolares</option>
							</select>
						  </div>
						</div>
						
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">F. Emisi&oacute;n </label>
						  <div class="col-md-3">
							<input type="text" name='fecha_emision' id='fecha_emision' value="<?php echo validar_fecha($obj->fecha_emision);?>" ReadOnly  class="form-control input-sm">
						  </div>
						   <label class="col-md-2 control-label" for="selectbasic">F. Venc  </label>
						  <div class="col-md-3">
							<input type="text" name='fecha_caducidad' id='fecha_caducidad' value="<?php echo validar_fecha($obj->fecha_caducidad);?>"  ReadOnly class="form-control input-sm">
						  </div>
						</div>
						
						
				
				</div>
			</div>
			<div style="padding-top:10px;">&nbsp;</div>
		
			
	
			<div class="col-xs-12 col-sm-12 col-md-12">
			
				<div class="form-group">
					  <label class="col-md-1 control-label" for="selectbasic">Se&ntilde;or(a): </label>
					   <div class="col-md-11">
						<input type="text" id="cliente" name="cliente" value="<?php echo strtoupper(utf8_decode($cliente->nombres));?>" readonly="true" placeholder="Cliente" class="form-control input-sm">
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
										<input type="text" id="MODELO" name="MODELO" value="<?php echo $obj->descripcion;?>" ReadOnly class="form-control input-sm">
								  </div>
							</div>
				</div>
			
			
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<h4 class="text-left proforma_h4">COMPUTADORA</h4>
				<span class="proforma_span"></span>
			</div>
			
			<div style="padding-top:10px;">&nbsp;</div>
			
		
				<div class="col-xs-12 col-sm-12 col-md-12">
						
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
											</tr>
										</thead>
										<tbody id='detalle_pc'>
										
										
															
<?php $c=0;foreach ($detalle_proforma as $key=>$val) { $c++; ?>							
<tr id="detalle_pc_<?php echo $c;?>" class="tr_primero">
<td  width='5%'>
	<input name="codigo[]" id="codigo[]" type="hidden" value="<?php echo $val[3];?>" ><?php echo $c;?>
</td>
<td width="85%">
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
									<td>DCTO</td>
									<td>GAR.</td>
								</tr>
							</thead>
							<tbody id='detalle_producto'>
							
							
							<?php $d=0;foreach ($detalle_otros as $key=>$val2) { $d++; ?>							
<tr id="detalle_otro_<?php echo $d;?>" class="tr_p">
<td  width='5%'>
	<input name="codigo_otros[]" id="codigo_otros[]" type="hidden" value="<?php echo $val2[4];?>" ><?php echo $d;?>
</td>
<td width="58%">
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


</tr>
					<?php } ?>

							
							
							</tbody>
						</table>
						
						<div class="col-xs-12 col-sm-12 col-md-12">	
							<div class="col-xs-12 col-sm-8 col-md-8"></div>		
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
											</tr>
										</thead>
										<tbody id='detalle_obs'>
										
										
										<?php $cc=0;foreach ($detalle_obsequios as $key=>$val3) { $cc++; ?>							
<tr id="detalle_obs_<?php echo $cc;?>" class="tr_obs">
<td  width='5%'>
	<input name="codigo_obs[]" id="codigo_obs[]" type="hidden" value="<?php echo $val3[4];?>" ><?php echo $cc;?>
</td>
<td width="63%">
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
							<input type='text'   name='descuento_general' id='descuento_general' disabled value="<?php echo $obj->descuento_general; ?>" class="form-control input-sm" onkeypress="return permite(event,'num')" />
						  </div>
						  <div class="col-md-1">
							<input type='checkbox' name='_descuento' id='_descuento' <?php echo $check; ?> disabled />
						  </div>
						</div>
					</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="form-group">
						  <label class="col-md-9 control-label" for="selectbasic">Mantenimiento Preventivo: </label>
						  <div class="col-md-3">
							<input type='text'   ReadOnly="True" value="<?php echo $obj->mantenimiento;?>" class="form-control input-sm" />
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
			

			
			<div class="col-xs-12 col-sm-12 col-md-12 text-center">
					  <label class="col-md-12" for="selectbasic">Responsable: <?php echo $usuario;?></label>
			</div>
			
			<hr style="border-top: 1px solid #e5e5e5; width:100%"/>
			
			<div class="form-group">
			  <div class="col-md-12 text-center">
				<div id="msg" ></div>
			  </div>
			</div>

			
			<div class="form-group">
			  <div class="col-md-12 text-center">
				<input type="button" value="Cerrar" onclick="closeWindow();" class="btn btn-success"/>
			  </div>
			</div>
			

			</fieldset>
        </form>



       