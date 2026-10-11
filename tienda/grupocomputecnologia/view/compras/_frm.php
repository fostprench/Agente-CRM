<script type="text/javascript" src="web/js/evnt/compras.js" ></script>
        <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?></legend>
			
			<input type="hidden" name="idproveedor" id="idproveedor" />
			<input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
			<input type="hidden" name="idproducto" id="idproducto" />
			<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario'];?>"/>
			
		
			<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="col-xs-12 col-sm-5 col-md-5">
									
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Nro. factura: </label>
				  <div class="col-md-6">
					<input type="text" name='nro_comprobante' id='nro_comprobante' placeholder="Nro. factura" class="form-control input-sm">
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Tipo de Cambio: </label>
				  <div class="col-md-6">
					<input type="text" name='tipocambio' id='tipocambio' value="3.42" placeholder="Cambio" class="form-control input-sm">
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
				  <label class="col-md-2 control-label" for="selectbasic">IGV%: </label>
				  <div class="col-md-2">
					<input type='text' name='igv' id='igv' value="18" placeholder="IGV" class="form-control input-sm"/>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Precio $ </label>
				  <div class="col-md-4">                     
					<input type="text" name='sin_igv' id='sin_igv' disabled placeholder="Precio Dolares" class="form-control input-sm" onkeypress="return permite(event,'num')" >
				  </div>
				  <div class="col-md-1">    
					  <input class='radio precio_radio' type='radio' name='precio' id='precio'>
				  </div>
				  <div class="col-md-3">                     
					<input type="text" id='costo_ant_dolares' disabled placeholder="Precio Anterior" class="form-control input-sm" onkeypress="return permite(event,'num')" >
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">Precio S/. </label>
				  <div class="col-md-4">                     
					<input type="text"  name='con_igv' id='con_igv'  disabled placeholder="Precio Soles" class="form-control input-sm" onkeypress="return permite(event,'num')"  >
				  </div>
				  <div class="col-md-1">    
					  <input class='radio igv_radio' type='radio' name='precio' id='precio'>
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
					<input type="text" id="proveedor" name="proveedor" placeholder="Cargar Proveedor" class="form-control input-sm">
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
					<input type="text" name='fecha' id='fecha' value="<?php echo date("d-m-Y");  ?>" placeholder="Fecha" class="form-control input-sm">
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
						<input type='text' name='precio_v' id='precio_v' placeholder="Precio" class="form-control input-sm" onkeypress="return permite(event,'num')" />
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
						</tbody>
						<input type='hidden' id='i' name='i' value='0'/>
					</table>
					
					<div class="col-xs-12 col-sm-12 col-md-12">	
						<div class="col-xs-12 col-sm-8 col-md-8"></div>		
						<div class="col-xs-12 col-sm-4 col-md-4">	
							<table class="table">
									<tr>
										<td class="text-right subtotal_sig">Sub - Total S/.</td>
										<td class="text-center">
											<div id="totalgeneral">0.00</div>
											<input type="hidden" name="totalcompra" id="totalcompra"/>
										</td>
									</tr>
									<tr>
										<td class="text-right">I.G.V. %</td>
										<td class="text-center">
											<div id="igv_total"></div>										
											<div class="form-group">
												<div class="col-md-6">
													<input type="text" name="igv_venta" id="igv_venta" class="form-control input-sm" value='18' onkeypress="return permite(event,'num')"/>
												</div>
												<div class="col-md-1">
													<input type='checkbox' name='_igv' id='_igv'/>
												</div>
											</div>
										</td>
									</tr>
									
									<!--DESCUENTO  -->
									
									<tr>
										<td class="text-right">Descuento: </td>
										<td class="text-center">									
											<div class="form-group">
												<div class="col-md-6">
													<input type="text" name="descuento" id="descuento" class="form-control input-sm" value='0' onkeypress="return permite(event,'num')"/>
												</div>
												<div class="col-md-1">
													<input type='checkbox' name='_descuento' id='_descuento'/>
												</div>
											</div>
										</td>
									</tr>
									
									
									<tr>
										<td class="text-right total_sig">Total S/.</td>
										<td class="text-center">
											<div id="total_igv">0.00</div>
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
<script>
$("#nro_comprobante").focus();
</script>


