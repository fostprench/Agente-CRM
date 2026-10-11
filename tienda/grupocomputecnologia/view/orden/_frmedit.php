<script type="text/javascript" src="web/js/evnt/orden_edit.js" ></script>
        <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?></legend>
			<input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
			<input type="hidden" name="idorden_st" id="idorden_st" value="<?php echo $obj->idorden_st;?>"/>
			<input type="hidden" name="idcliente" id="idcliente" value="<?php echo $obj->idcliente;?>"/>
			<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario'];?>"/>
			
			
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
				  <label class="col-md-4 control-label" for="selectbasic">Fecha: </label>
				  <div class="col-md-7">
						<input type="text" name='fecha' id='fecha'  placeholder="Fecha" value="<?php echo $fecha;  ?>" class="form-control input-sm">
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Cliente: </label>
				  <div class="col-md-7">
						<div class="input-group">
							<input type="text" id="cliente" name="cliente" value="<?php echo $obj->nombres;  ?>" readonly="true" placeholder="Cliente" class="form-control input-sm">
							<span class="input-group-btn">
								<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_cli">
								  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								</button>
							</span>
						</div>
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
					<select id="atendido" name="atendido" class="form-control <?php if($obj->atendido==0){echo "alert-danger";}else{echo "alert-success";}?>">
						<option value="0" <?php if($obj->atendido==0){echo "Selected='selected'";}?>> ATENDIENDO </option>
						<option value="1" <?php if($obj->atendido==1){echo "Selected='selected'";}?>> ATENDIDO </option>
					</select>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Descripci&oacute;n Equipo: </label>
				  <div class="col-md-7">                     
					<textarea class="form-control" id="desc_equipo" name="desc_equipo"><?php echo $obj->desc_equipo;  ?></textarea>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Descripci&oacute;n Falla: </label>
				  <div class="col-md-7">                     
					<textarea class="form-control" id="desc_falla" name="desc_falla"><?php echo $obj->desc_falla;  ?></textarea>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Accesorios: </label>
				  <div class="col-md-7">                     
					<textarea class="form-control" id="accesorios" name="accesorios"><?php echo $obj->accesorios;  ?></textarea>
				  </div>
				</div>
				
					
            </div>
            </div>
			
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="col-xs-12 col-sm-1 col-md-1"></div>
				<div class="col-xs-12 col-sm-5 col-md-10">
					<div class="form-group">
					  <label class="col-md-3 control-label" for="selectbasic">Servicio: </label>
					  <div class="col-md-4">
						<?php echo $servicio;?>
					  </div>
					  <div class="col-md-1">
						<input type="text" id="cant_s" name="cant_s" placeholder="Cant" class="form-control input-sm">
					  </div>

					  <div class="col-md-1">
						<input type="text" id="precio_s" name="precio_s" placeholder="Costo" class="form-control input-sm">
					  </div>
					  <div class="col-md-1">
						<button type="button" id="agregar_serv" class="btn btn-sm btn-primary" aria-label="Left Align">
						  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</button>
					  </div>
					</div>
				</div>

            </div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="alert alert-danger" id="msg-parte" style="display:none;" class="text-center" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Falta Ingresar Item de Servicio de Soporte T&eacute;cnico.
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
<td width="5%">
<input name="codigo[]" id="codigo[]" type="hidden" value="<?php echo $val[0];?>" >
<input name="cant_s[]" id="cant_s[]" type="hidden" value="<?php echo $val[4];?>" >
<input type="hidden" id="precio_real[]"  name="precio_real[]" value="<?php echo $val[2];?>">
<?php echo $val[4];?>
</td>
<td width="70%"><?php echo $val[1];?></td><!--descripcion del producto-->
<td width="5%"><?php echo $val[2];?></td>
<td width="5%"><?php echo number_format(($val[4]*$val[2]), 2, '.', ' ') ;?></td>
<td width="5%">
<a class="btn btn-xs btn-danger" href="javascript:eliminar_p(<?php echo $c;?>,<?php echo $val[4]*$val[2];?>);"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>
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
				<input type="submit" name="grabar" id="grabar" value="registrar" class="btn btn-success"/>
				<?php }if($p==2){?>
				<input type="submit" name="grabar" id="grabar" value="Actualizar" class="btn btn-success"/>
				<?php }?>
				<input type="button" name="regresar" id="regresar" value="Atras"  onclick="atras();" class="btn btn-warning"/>
			  </div>
			</div>
			

			</fieldset>
        </form>



