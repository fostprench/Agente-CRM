<script type="text/javascript" src="web/js/evnt/ventasxpedir.js" ></script>

<?php if($mensaje){?>

		 <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?></legend>
			
			<input type="hidden" name="idventa" id="idventa"/>
			<input type="hidden" name="idcliente" id="idcliente"/>
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
							<input type="text" name='nro_comprobante' id='nro_comprobante' placeholder="Nro. Comprobante" class="form-control input-sm">
						  </div>
						   <label class="col-md-2 control-label" for="selectbasic">Fecha: </label>
						  <div class="col-md-3">
							<input type="text" name='fecha' id='fecha' value="<?php echo date("d-m-Y");  ?>" placeholder="Fecha" class="form-control input-sm">
						  </div>
						</div>
				
				</div>
			</div>
			<div style="padding-top:20px;">&nbsp;</div>

			<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="col-xs-12 col-sm-8 col-md-8">
									
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Cliente: </label>
				  <div class="col-md-5">
					<input type="text" id="cliente" name="cliente" placeholder="Cliente" class="form-control input-sm">
				  </div>
				  <div class="col-md-3">   
						<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_cli" itle="Buscar Cliente">
						  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_prof" title="Buscar Proforma">
						  <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
						</button>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Producto: </label>
				  <div class="col-md-6">  
					<input type="hidden" name="idproducto" id="idproducto" value="<?php echo $obj->idproducto;?>"/>
					<input type="hidden" name="stock" id="stock">
					<textarea class="form-control" id="producto" rows="3" name="producto"></textarea>
				  </div>
				  <div class="col-md-1">
						<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_producto">
						  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</button>
				  </div>
				</div>				

            </div>
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
						<input type='text' name='glosa' id='glosa' disabled placeholder="Serie de Productos" class="form-control input-sm"/>
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
						</tbody>
						<input type='hidden' id='i' name='i' value='0'/>
					</table>
					
					<div class="col-xs-12 col-sm-12 col-md-12">	
						<div class="col-xs-12 col-sm-8 col-md-8"></div>		
						<div class="col-xs-12 col-sm-4 col-md-4">	
							<table class="table">
									<tr>
										<td class="text-right">SUB - TOTAL S/.</td>
										<td class="text-center">
											<div id="totalgeneral"></div>
											<input type="hidden" name="totalcompra" id="totalcompra"/>
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
											<div id="total_igv"></div>
											<input type="hidden" name="totalcompra_igv" id="totalcompra_igv"/>
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
						<input type='text' name='observacion' id='observacion' placeholder="Observacion de Compra" class="form-control input-sm"/>
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

       