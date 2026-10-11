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
<script type="text/javascript" src="web/js/evnt/proformas.js" ></script>

		 <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?php echo $titulo; ?></legend>
			
			<input type="hidden" name="idproformas" id="idproformas"/>
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
					<span class='descripcion'><?php echo $_SESSION['direccion'];?><br/><?php echo $_SESSION['telefono'];?><br/>Moyobamba-San Martin</span>
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
								<option value="1">Soles</option>
								<option value="2">Dolares</option>
							</select>
						  </div>
						</div>
						
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">F. Emisi&oacute;n </label>
						  <div class="col-md-3">
							<input type="text" name='fecha_emision' id='fecha_emision' value="<?php echo date("d-m-Y");  ?>" placeholder="Fecha Emision" class="form-control input-sm">
						  </div>
						   <label class="col-md-2 control-label" for="selectbasic">F. Venc  </label>
						  <div class="col-md-3">
							<input type="text" name='fecha_caducidad' id='fecha_caducidad' value="<?php 
							
							$fecha_c = date("d-m-Y"); 
							$nuevafecha = strtotime ( '+7 day' , strtotime ( $fecha_c ) ) ;
							$nuevafecha = date ( 'd-m-Y' , $nuevafecha );
							echo $nuevafecha;


							?>" placeholder="Fecha Caducidad" class="form-control input-sm">
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
									<input type="text" id="cliente" name="cliente" placeholder="Cliente" class="form-control input-sm">
									<span class="input-group-btn">
										<button type="button" class="btn btn-sm btn-primary" aria-label="Left Align" id="buscar_cli" title="Buscar Cliente">
										  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
										</button>
									</span>
						 </div>
					 </div>
					 <div class="col-xs-12 col-sm-6 col-md-6"> 
						    <label for="primary" class="btn btn-primary">Mostrar Precios <input type="checkbox" id="primary" name="mostrar_precios" class="badgebox"><span class="badge">&check;</span></label>

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
										<input type="text" id="MODELO" name="MODELO" placeholder="MODELO" class="form-control input-sm">
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
							  <label class="col-md-4 control-label" for="selectbasic">% Ganancia: </label>
							  <div class="col-md-6">
									<input type="text" id="ganancia" name="ganancia" value="0" class="form-control input-sm" placeholder="Descuento">
							  </div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="form-group">
							  <label class="col-md-4 control-label" for="selectbasic">Cantidad: </label>
							  <div class="col-md-6">
									<input type="number" min="1" max="9" step="1" id="cantidad" name="cantidad" value="1" class="form-control input-sm" placeholder="Cantidad">
							  </div>
							</div>					
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="form-group">
							  <label class="col-md-5 control-label" for="selectbasic">Precio Unitario: </label>
							  <div class="col-md-6">
									<input type="text"  id="precio_unitario" name="precio_unitario" ReadOnly="True" value="0" class="form-control input-sm" placeholder="Precio Unit.">
									<input type="hidden"  id="precio_unitario_hidden" name="precio_unitario_hidden" value="0">
							  </div>
							</div>					
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
								<div class="form-group">
							  <label class="col-md-5 control-label" for="selectbasic">Precio Total: </label>
							  <div class="col-md-6">
									<input type="text"  id="precio_total" name="precio_total" ReadOnly="True" value="0" class="form-control input-sm" placeholder="Total">
							  </div>
							</div>				
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-12">
								
								<div class="col-xs-4 col-sm-2 col-md-1">
								   <div class="thumbnail">
									  <img src="images/procesador.jpg" alt="Procesador" class="buscar_componente pointer" id="focus1" data-cat="1">
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
									<input type='text' name='precio_pc' id='precio_pc'  placeholder="Precio" class="form-control input-sm"/>
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
					<!--<div class="col-xs-12 col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">% Ganancia:</label>
						  <div class="col-md-6">
							<input type='text' name='ganancia_otro' id='ganancia_otro' value="0" placeholder="Ganacia %" class="form-control input-sm"/>
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
							</tbody>
						</table>
						
						<div class="col-xs-12 col-sm-12 col-md-12">	
							<div class="col-xs-12 col-sm-8 col-md-6"></div>		
							<div class="col-xs-12 col-sm-4 col-md-4">	
								<table class="table">
										<tr>
											<td class="text-right">TOTAL S/.</td>
											<td class="text-left">
												<div id="txttotal_otros">0.00</div>
												<input type="hidden" name="total_otros" id="total_otros" value="0"/>
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
												<div id="txttotal_obsequios">0.00</div>
												<input type="hidden" name="total_obsequios" id="total_obsequios" value="0"/>
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
						  <label class="col-md-4 control-label" for="selectbasic">Descuento: </label>
						  <div class="col-md-5">
							<input type='text'   name='descuento_general' id='descuento_general' value="0" ReadOnly="True" class="form-control input-sm" onkeypress="return permite(event,'num')" />
						  </div>
						  <div class="col-md-1">
							<!-- <input type='checkbox' name='_descuento' id='_descuento'/> -->
						  </div>
						</div>
					</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="form-group">
						  <label class="col-md-10 control-label" for="selectbasic">Mantenimiento Preventivo: </label>
						  <div class="col-md-2">
							<input type='number'   name='mantenimiento' id='mantenimiento' min="1" max="9" step="1" value="3" class="form-control input-sm" onkeypress="return permite(event,'num')" />
						  </div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-5 col-md-5"></div>
					<div class="col-xs-12 col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="col-md-4 control-label" for="selectbasic">Total General: </label>
						  <div class="col-md-6">
							<input type='text'   name='total_general' id='total_general' ReadOnly="True" value="0" class="form-control input-sm" onkeypress="return permite(event,'num')" />
							<input type="hidden" name="general_hidden" id="general_hidden" value="0">
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



       