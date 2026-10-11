<script type="text/javascript" src="web/js/evnt/reporte_general_negocio.js" ></script>
<div class="row">
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 <div class="col-xs-12 col-sm-12 col-md-8">
		 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">REPORTE DE CAJA POR FECHA DE APERTURA</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
				  <div class="col-md-1"></div>
				  <div class="col-md-4">
							<select name="tipo_reporte" id="tipo_reporte" class="form-control">
								<option value="1">REPORTE RESUMIDO</option>
								<option value="2">REPORTE DETALLADO</option>
							</select>
				  </div>
				  <div class="col-md-4">
							<select name="caja_aperturada" id="caja_aperturada" class="form-control">
								<?php foreach($combo_mes as $key => $val){ ?>
									<option value="<?php echo $val[0]; ?>">CAJA AL <?php echo $val[1]; ?></option>
								<?php } ?>
							 </select>
				  </div>
				  <div class="col-md-2">
						<button type="button" id="reporte_general" class="btn btn-sm btn-primary " aria-label="Left Align">
						  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
						</button>
				  </div>
				  <div class="col-md-1"></div>
				</div>
            </div>
          </div>
 </div>
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
</div>

<div style="padding-top:25%">
</div>
