
<script type="text/javascript" src="web/js/evnt/reporte_soporte_tecnico.js" ></script>

<div class="row">
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 <div class="col-xs-12 col-sm-12 col-md-8">
		 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">REPORTE DE SOPORTE TECNICO</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
				<label class="col-md-5 control-label" for="textinput">Ingreso Bruto de Soporte Tecnico:</label>
				<div class="col-md-4">
					  <select name="caja_aperturada" id="caja_aperturada" class="form-control">
						<?php foreach($cajas_aperturadas as $key => $val){ ?>
							<option value="<?php echo $val[0]; ?>">CAJA AL <?php echo $val[1]; ?></option>
						<?php } ?>
					  </select>
				  </div>				
				  <div class="col-md-3">
						<button type="button" id="reporte_soporte" class="btn btn-sm btn-primary" aria-label="Left Align">
						  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
						</button>
				  </div>
				</div>
            </div>
          </div>
		  
		   <div class="panel panel-primary">
				<div class="panel-heading">
				  <h3 class="panel-title">REPORTE DE SOPORTE POR RANGO DE FECHA</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
					  <label class="col-md-2 control-label" for="textinput">Desde: </label>  
					  <div class="col-md-2">
						<input type="text" name="fecha_inicial" id="fecha_inicial" value="<?php echo date('d-m-Y'); ?>"  placeholder="Fecha Inicio" class="form-control input-md">
					  </div>
					  <label class="col-md-2 control-label" for="textinput">Hasta: </label>  
					  <div class="col-md-2">
						<input type="text" name="fecha_final" id="fecha_final" value="<?php echo date('d-m-Y'); ?>"  placeholder="Fecha Fin" class="form-control input-md">
					  </div>
					  <div class="col-md-4">
							<button type="button" id="reporte_soporte_rango" class="btn btn-sm btn-primary" aria-label="Left Align">
							  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
							</button>
					  </div>
					</div>
				</div>
			  </div>
			  
			  <div class="panel panel-primary">
				<div class="panel-heading">
				  <h3 class="panel-title">REPORTE DE SOPORTE POR DIA</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
					  <label class="col-md-4 control-label" for="textinput">Reporte del D&iacute;a:</label>  
					  <div class="col-md-4">
					  <input type="text" name="fecha_dia" id="fecha_dia" value="<?php echo date('d-m-Y'); ?>"  placeholder="Fecha de Reporte" class="form-control input-md"> 
					  </div>
					  <div class="col-md-4">
							<button type="button" id="reporte_soporte_hoy" class="btn btn-sm btn-primary" aria-label="Left Align">
							  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
							</button>
					  </div>
					</div>
				</div>
			  </div>
			  
			  
 </div>
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 
</div>

<div style="padding-top:20%">
</div>
