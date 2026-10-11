<?php require_once('lib/funciones.php'); ?>
<script type="text/javascript" src="web/js/evnt/ventaxcobrar_edit.js" ></script>
<?php if($mensaje){?>

		 <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?></legend>
			
			<input type="hidden" name="idventa" id="idventa" value="<?php echo $obj->idventa;?>"/>
			<input type="hidden" name="idcliente" id="idcliente" value="<?php echo $obj->idcliente;?>"/>
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
						  <label class="col-md-4 control-label" for="selectbasic">Tipo Comprobante: </label>
						  <div class="col-md-8">
							<?php echo $tipo_c; ?>
						  </div>
						</div>
						
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">Nro.Comprobante: </label>
						  <div class="col-md-3">
							<input type="text" name='nro_comprobante' id='nro_comprobante' value='<?php echo $obj->nro_comprobante;?>' placeholder="Nro. Comprobante" class="form-control input-sm">
						  </div>
						   <label class="col-md-2 control-label" for="selectbasic">Fecha: </label>
						  <div class="col-md-3">
							<input type="text" name='fecha' id='fecha' value="<?php echo validar_fecha($obj->fecha);  ?>" placeholder="Fecha" class="form-control input-sm">
						  </div>
						</div>
				
				</div>
			</div>
			<div style="padding-top:20px;">&nbsp;</div>
		

		
			<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="col-xs-12 col-sm-1 col-md-1"></div>
			<div class="col-xs-12 col-sm-5 col-md-5">
									
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Cliente: </label>
				  <div class="col-md-6">
					<input type="text" id="cliente" name="cliente" value="<?php echo $obj->cliente;?>" ReadOnly="True" placeholder="Cliente" class="form-control input-sm">
				  </div>
				  <div class="col-md-1">   
						<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_cli">
						  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</button>
				  </div>
				  <div class="col-md-1">   
						<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_serv" title="Buscar Orden">
						  <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
						</button>
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Producto: </label>
				  <div class="col-md-6">  
					<input type="hidden" name="idproducto" id="idproducto" value="<?php echo $obj->idproducto;?>"/>
					<input type="hidden" name="stock" id="stock">
					<textarea class="form-control" id="producto" rows="3"  name="producto"></textarea>
				  </div>
				  <div class="col-md-1">
						<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_producto">
						  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</button>
				  </div>
				</div>
				

            </div>
			<div class="col-xs-12 col-sm-1 col-md-1"></div>
            <div class="col-xs-12 col-sm-4 col-md-4">
			
			
				
				
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
						<input type='text' name='precio' id='precio' placeholder="Precio" class="form-control input-sm"/>
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
						<input type='text' name='glosa' id='glosa' placeholder="Series de Productos" class="form-control input-sm"/>
					  </div>
					  <div class="col-md-1">
						<button type="button" id="agregarc" class="btn btn-sm btn-primary" aria-label="Left Align">
						  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</button>
					  </div>
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
													
<?php $totalcompra=0;$c=0;foreach ($detalle as $key=>$val) { $c++; $totalcompra = $totalcompra + $val[4];

if($val[0]>0){	$codigo_tr = $c; }elseif($val[5]>0){$codigo_tr = $c."_".$val[5];}

?>							
<tr id="<?php echo $codigo_tr;?>" class="tr_p">
<td><?php echo $c;?><input type="hidden" name="codigo[]" id="codigo[]"  value="<?php echo $val[0];?>" ><input type="hidden" name="codigo_orden[]" id="codigo_orden[]"  value="<?php echo $val[5];?>" ></td>

<td width="45%"><input type="hidden" name="producto[]" id="producto[]"  size="40" value="<?php echo $val[1];?>" ><?php echo $val[1];?></td>

<td width="17%"><input type="text" name="glosa[]" id="glosa[]"  value="<?php echo $val[6];?>" class='form-control input-sm' ></td>

<td width="10%">
<input type="hidden" id="canti[]"  size="5" name="canti[]" value="<?php echo $val[3];?>"><?php echo $val[3];?>
</td>

<td width="10%">
<input id="precios[]" type="hidden" size="5" value="<?php echo $val[2];?>" name="precios[]"><?php echo $val[2];?>
</td>

<td width="10%">
<input id="sub[]" type="hidden" size="10" value="<?php echo $val[4];?>" name="sub[]"><?php echo $val[4];?>
</td>
<td width="8%">

	<?php if($val[0]>0){?>
		<a class="btn btn-xs btn-danger"  href="javascript:eliminar_p('<?php echo $c;?>','<?php echo $val[4];?>','<?php echo $obj->idventa;?>','<?php echo $val[0];?>');"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>
		<a class="btn btn-xs btn-info"  href="javascript:_ver('index.php?controller=Productos&action=show&id=<?php echo $val[0];?>')"><span class='glyphicon glyphicon-zoom-in' aria-hidden='true'></span></a>
	<?php }elseif($val[5]>0){?>
		<a class="servicio btn btn-xs btn-warning" data="<?php echo $c;?>" href="javascript:eliminar_servicio('<?php echo $c;?>','<?php echo $val[5];?>')"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>
		<a class="btn btn-xs btn-info" href="javascript:_ver('index.php?controller=Orden_st&action=show&id=<?php echo $val[5];?>')"><span class='glyphicon glyphicon-zoom-in' aria-hidden='true'></span></a>
	<?php } ?>
	
</td>

</tr>
					<?php } $totalcompra = number_format($totalcompra,2,'.',''); ?>
					
						</tbody>
						<input type='hidden' id='i' name='i' value='<?php echo $c;?>'/>
					</table>
					
					<div class="col-xs-12 col-sm-12 col-md-12">	
						<div class="col-xs-12 col-sm-8 col-md-8"></div>		
						<div class="col-xs-12 col-sm-4 col-md-4">	
							<table class="table">
									<tr>
										<td class="text-right">SUB - TOTAL S/.</td>
										<td class="text-center">
											<div id="totalgeneral"><?php echo $totalcompra; ?></div>
											<input type="hidden" name="totalcompra" id="totalcompra" value='<?php echo $totalcompra; ?>'/>
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
											<div id="total_igv"><?php echo $totalcompra;?></div>
											<input type="hidden" name="totalcompra_igv" id="totalcompra_igv" value="<?php echo $totalcompra; ?>"/>
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



       