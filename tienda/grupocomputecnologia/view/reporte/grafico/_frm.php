<script type="text/javascript" src="web/js/evnt/reporte_grafico_caja.js" ></script>

<div class="row">
 <div class="col-xs-12 col-sm-12 col-md-12">
		 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">REPORTES GRAFICOS ESTADISTICOS</h3>
            </div>
            <div class="panel-body">
                <div class="form-group"> 
				   <div class="col-md-3" style="padding-top: 19px;">
					  <select name="nro_reporte" id="nro_reporte" class="form-control" style="background: #428bca; border-color: #428bca; color:#fff">
						<option value="1">REPORTE CAJA</option>
						<option value="2">REPORTE INGRESOS SOPORTE</option>
						<option value="3">OTRO Y</option>
					  </select>
				  </div>
				  <div class="col-md-3">
						<a href="Javascript:void(0)" id="grafico_caja_b">
							<img src="web/images/btn_barra.png" class="img-responsive" style="margin: auto;" />
						</a>
				  </div>
				  <div class="col-md-3">
						<a href="Javascript:void(0)" id="grafico_caja_t">
							<img src="web/images/btn_torta.png" class="img-responsive" style="margin: auto;" />
						</a>
				  </div>
				  <div class="col-md-3">
						<a href="Javascript:void(0)" id="grafico_caja_d">
							<img  src="web/images/btn_donus.png" class="img-responsive" style="margin: auto;" />
						</a>
				  </div>
				</div>
            </div>
          </div>
 </div>
 
 <div class="table-responsive">
		<div class="col-xs-12 col-sm-12 col-md-12" id="load_graphic"></div>
 </div>
 
</div>

<div style="padding-top:5%">
</div>
