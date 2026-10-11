<script type="text/javascript" src="web/js/evnt/reporte_hoy_general.js" ></script>
<div class="row">
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 <div class="col-xs-12 col-sm-12 col-md-8">
 
 		  <form id="_form" name="_form" class="form-horizontal" >
			  <div class="panel panel-primary">
				<div class="panel-heading">
				  <h3 class="panel-title">REPORTE DE COMPRAS POR RANGO DE FECHA</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
					  <label class="col-md-4 control-label" for="textinput">Desde: </label>  
					  <div class="col-md-2">
						<input type="text" name="fecha_i" id="fecha_i" value="<?php echo date('d-m-Y'); ?>"  placeholder="Fecha Inicio" class="form-control input-md">
					  </div>
					  <label class="col-md-1 control-label" for="textinput">Hasta: </label>  
					  <div class="col-md-2">
						<input type="text" name="fecha_f" id="fecha_f" value="<?php echo date('d-m-Y'); ?>"  placeholder="Fecha Fin" class="form-control input-md">
					  </div>
					</div>
					
					<div class="form-group">
					  <div class="col-md-6 text-right">
							<button type="button" id="reporte_compras_rango_pdf" class="btn btn-sm btn-primary" aria-label="Left Align">
							  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
							</button>
					  </div>
					  <div class="col-md-6 text-left"> 
							
							<button type="button" id="reporte_compras_rango_excel" class="btn btn-sm btn-primary" aria-label="Left Align">
							  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar EXCEL
							</button>
					  </div>
					</div>
				</div>
			  </div>
		</form>
			  

 </div>
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 
</div>

<div style="padding-top:20%">
</div>
