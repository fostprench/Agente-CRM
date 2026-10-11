
        <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?><button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button></legend>

			<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="col-xs-12 col-sm-1 col-md-1"></div>
			<div class="col-xs-12 col-sm-5 col-md-5">					
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Orden Nro: </label>
				  <div class="col-md-7">
					<input type="text" name='nro_orden' id='nro_orden' Readonly placeholder="Nro. Orden" value="<?php echo $num_orden;?>" class="form-control input-sm">
				  </div>
				</div>
			</div>
			</div>
	
		
			<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="col-xs-12 col-sm-1 col-md-1"></div>
			<div class="col-xs-12 col-sm-5 col-md-5">
									
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Nro Recibo: </label>
				  <div class="col-md-7">
					<input type="text" name='nro_recibo' id='nro_recibo' ReadOnly placeholder="Nro. Recibo" value="<?php echo $obj->nro_recibo;?>" class="form-control input-sm">
				  </div>
				</div>
	
		
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Fecha: </label>
				  <div class="col-md-7">
						<input type="text" disabled   placeholder="Fecha" value="<?php echo $fecha;  ?>" class="form-control input-sm">
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Cliente: </label>
				  <div class="col-md-7">
						<input type="text" id="cliente" name="cliente" value="<?php echo $obj->nombres;  ?>" readonly="true" placeholder="Cliente" class="form-control input-sm">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Telefono: </label>
				  <div class="col-md-7">
						<input type="text" id="cliente" name="cliente" value="<?php echo $obj->telefono;  ?>" readonly="true" placeholder="Telefono" class="form-control input-sm">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Categoria: </label>
				  <div class="col-md-7">
					<?php echo $tipo;?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Marca: </label>
				  <div class="col-md-7">
					<?php echo $marca;?>
				  </div>
				</div>

            </div>
			<div class="col-xs-12 col-sm-1 col-md-1"></div>
            <div class="col-xs-12 col-sm-5 col-md-5">
			
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Estado: </label>
				  <div class="col-md-7">
					<select id="atendido" name="atendido" disabled class="form-control <?php if($obj->atendido==0){echo "alert-danger";}else{echo "alert-success";}?>">
						<option value="0" <?php if($obj->atendido==0){echo "Selected='selected'";}?>> ATENDIENDO </option>
						<option value="1" <?php if($obj->atendido==1 || $obj->atendido==2){echo "Selected='selected'";}?>> ATENDIDO </option>
					</select>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Descripci&oacute;n Equipo: </label>
				  <div class="col-md-7">                     
					<textarea class="form-control" id="desc_equipo" name="desc_equipo" disabled ><?php echo $obj->desc_equipo;  ?></textarea>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Descripci&oacute;n Falla: </label>
				  <div class="col-md-7">                     
					<textarea class="form-control" id="desc_falla" name="desc_falla" disabled><?php echo $obj->desc_falla;  ?></textarea>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Accesorios: </label>
				  <div class="col-md-7">                     
					<textarea class="form-control" id="accesorios" name="accesorios" disabled><?php echo $obj->accesorios;  ?></textarea>
				  </div>
				</div>
				
					
            </div>
            </div>

			
			<div class="col-xs-12 col-sm-2 col-md-2">	</div>		
			<div class="col-xs-12 col-sm-8 col-md-8">			
				<div class="table-responsive">
					<table class="table table-hover">
						<thead style='background-color:#428bca;color:#fff'>
							<tr>
								<td>CANT</td>
								<td>SERVICIO</td>
								<td>PRECIO</td>
								<td>SUB.TOTAL</td>
								<td>ACCION</td>
							</tr>
						</thead>
						<tbody id='detalle_servicio'>
												
<?php $c=0;$total_pago=0;foreach ($detalle as $key=>$val) { $c++;$total_pago = $total_pago + $val[4]*$val[2]; ?>							
<tr id="<?php echo $c;?>" class="tr_p">
<td width="5%"><?php echo $val[4];?></td>
<td width="70%"><?php echo $val[1];?><!--descripcion del producto--></td>
<td width="15%"><?php echo $val[2];?></td>
<td width="15%"><?php echo number_format(($val[4]*$val[2]), 2, '.', ' ') ;?></td>
<td width="5%">
<label class="btn btn-sm btn-default" ><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></label>
</td>

</tr>
					<?php } $total_pago = number_format($total_pago,2,'.',' ');  ?>	
					
					
					
						</tbody>
						<input type='hidden' id='i' name='i' value='<?php echo $c;?>'/>
					</table>
					
					<div class="col-xs-12 col-sm-12 col-md-12">	
						<div class="col-xs-12 col-sm-6 col-md-6"></div>		
						<div class="col-xs-12 col-sm-6 col-md-6">	
							<table class="table">
									<tr>
										<td class="text-right">TOTAL S/.</td>
										<td class="text-center">
											<div id="totalgeneral"><?php echo $total_pago;?></div>
											<input type="hidden" name="total_servicio" id="total_servicio" value="<?php echo $total_pago;?>"/>
										</td>
									</tr>
							</table>
						</div>
					</div>	
				</div>
            </div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 text-center">
					  <label class="col-md-12" for="selectbasic">Responsable: <?php echo $obj->usuario;?></label>
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



