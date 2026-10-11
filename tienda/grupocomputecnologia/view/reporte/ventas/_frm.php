<!-- reporte_ventas_cxc = Contado y X Cobrar-->
<script type="text/javascript" src="web/js/evnt/reporte_ventas_cxc.js" ></script>

<div class="row">
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 <div class="col-xs-12 col-sm-12 col-md-8">
		 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">REPORTE DE VENTAS AL CONTADO</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
				<label class="col-md-4 control-label" for="textinput">Seleccione Caja aperturada: </label>  
				  <div class="col-md-4">
					  <select name="caja_aperturada" id="caja_aperturada" class="form-control">
						<?php foreach($cajas_aperturadas as $key => $val){ ?>
							<option value="<?php echo $val[0]; ?>">CAJA AL <?php echo $val[1]; ?></option>
						<?php } ?>
					  </select>
				  </div>
				  <div class="col-md-4">
						<button type="button" id="reporte_ventas_c" class="btn btn-sm btn-primary" aria-label="Left Align">
						  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
						</button>
				  </div>
				</div>
            </div>
          </div>
 </div>
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 
</div>

<div class="row">
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 <div class="col-xs-12 col-sm-12 col-md-8">
		 <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">REPORTE DE VENTAS POR COBRAR</h3>
            </div>
            <div class="panel-body">
                <div class="form-group"><!--
				<label class="col-md-4 control-label" for="textinput">Seleccione Caja aperturada:</label>  
				  <div class="col-md-4">
					  <select name="caja_aperturada_2" id="caja_aperturada_2" class="form-control">
						<?php //foreach($cajas_aperturadas as $key => $val){ ?>
							<option value="<?php //echo $val[0]; ?>">CAJA AL <?php //echo $val[1]; ?></option>
						<?php //} ?>
					  </select>
				  </div>-->
				  <div class="col-md-12">
						<button type="button" id="reporte_ventas_xc" class="btn btn-sm btn-danger" aria-label="Left Align">
						  &nbsp;ACTIVAS&nbsp; <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
						</button>
						<button type="button" id="reporte_ventas_xc_All" class="btn btn-sm btn-success" aria-label="Left Align">
						 GENERAL <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
						</button>
				  </div>
				</div>
            </div>
          </div>
 </div>
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 
</div>
<?php if($_SESSION['perfil']=='su'){ ?>
<div class="row">
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 <div class="col-xs-12 col-sm-12 col-md-8">
		 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">REPORTE DE VENTA  DE PRODUCTOS - MARGEN BRUTO</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
				<label class="col-md-4 control-label" for="textinput">Seleccione Caja aperturada: </label>  
				  <div class="col-md-4">
					  <select name="caja_aperturada_2" id="caja_aperturada_2" class="form-control">
						<?php foreach($cajas_aperturadas as $key => $val){ ?>
							<option value="<?php echo $val[0]; ?>">CAJA AL <?php echo $val[1]; ?></option>
						<?php } ?>
					  </select>
				  </div>
				  <div class="col-md-4">
						<button type="button" id="reporte_ventas_margenbruto" class="btn btn-sm btn-primary" aria-label="Left Align">
						  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Generar PDF
						</button>
				  </div>
				</div>
            </div>
          </div>
 </div>
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 
</div>

<?php } ?>

<div style="padding-top:10%">
</div>
