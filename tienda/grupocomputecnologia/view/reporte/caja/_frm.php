<script type="text/javascript" src="web/js/evnt/reporte_hoy_general.js" ></script>
<?php if($_SESSION['perfil']=='su'){ ?>
<script type="text/javascript" src="web/js/evnt/reporte_hoy_su.js" ></script>
<?php }else{ ?>
<script type="text/javascript" src="web/js/evnt/reporte_hoy_otro.js" ></script>
<?php } ?>
<div class="row">
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 <div class="col-xs-12 col-sm-12 col-md-8">
		 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">REPORTE DE CAJA POR FECHA DE APERTURA</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">Reporte de Caja</label>  
				  <div class="col-md-4">
							<select name="caja_aperturada" id="caja_aperturada" class="form-control">
								<?php foreach($combo_mes as $key => $val){ ?>
									<option value="<?php echo $val[0]; ?>">CAJA AL <?php echo $val[1]; ?></option>
								<?php } ?>
							 </select>
				  </div>
				  <div class="col-md-4">
						<button type="button" id="reporte_caja_mes" class="btn btn-sm btn-primary " aria-label="Left Align">
						  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
						</button>
				  </div>
				</div>
            </div>
          </div>
		  
		  <?php if($_SESSION['perfil']=='su'){ ?>
		  
			  <div class="panel panel-primary">
				<div class="panel-heading">
				  <h3 class="panel-title">REPORTE DE CAJA POR RANGO DE FECHA</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
					  <label class="col-md-2 control-label" for="textinput">Desde: </label>  
					  <div class="col-md-2">
						<input type="text" name="fecha_i" id="fecha_i" value="<?php echo date('d-m-Y'); ?>"  placeholder="Fecha Inicio" class="form-control input-md">
					  </div>
					  <label class="col-md-2 control-label" for="textinput">Hasta: </label>  
					  <div class="col-md-2">
						<input type="text" name="fecha_f" id="fecha_f" value="<?php echo date('d-m-Y'); ?>"  placeholder="Fecha Fin" class="form-control input-md">
					  </div>
					  <div class="col-md-4">
							<button type="button" id="reporte_caja_rango" class="btn btn-sm btn-primary" aria-label="Left Align">
							  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
							</button>
					  </div>
					</div>
				</div>
			  </div>
			  
			  
			   <div class="panel panel-primary">
				<div class="panel-heading">
				  <h3 class="panel-title">REPORTE DE CAJA POR DIA</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
					  <label class="col-md-4 control-label" for="textinput">Reporte del D&iacute;a:</label>  
					  <div class="col-md-4">
					  <input type="text" name="fecha_r" id="fecha_r" value="<?php echo date('d-m-Y'); ?>"  placeholder="Fecha de Reporte" class="form-control input-md"> 
					  </div>
					  <div class="col-md-4">
							<button type="button" id="reporte_hoy" class="btn btn-sm btn-primary" aria-label="Left Align">
							  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
							</button>
					  </div>
					</div>
				</div>
			  </div>
			  
		  <?php }else{ ?>
			  <div class="panel panel-primary">
				<div class="panel-heading">
				  <h3 class="panel-title">REPORTE DE CAJA POR DIA</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
					  <label class="col-md-4 control-label" for="textinput">Reporte del D&iacute;a:</label>  
					  <div class="col-md-4">
					  <input type="text" name="fecha_r" id="fecha_r" value="<?php echo date('d-m-Y'); ?>"  placeholder="Fecha de Reporte" class="form-control input-md"> 
					  </div>
					  <div class="col-md-4">
							<button type="button" id="reporte_hoy" class="btn btn-sm btn-primary" aria-label="Left Align">
							  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
							</button>
					  </div>
					</div>
				</div>
			  </div>
		  <?php } ?>
 </div>
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 
</div>

<div style="padding-top:20%">
</div>
