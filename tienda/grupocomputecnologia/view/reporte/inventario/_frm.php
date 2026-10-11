
<script type="text/javascript" src="web/js/evnt/reporte_inventario.js" ></script>

<div class="row">
 <div class="col-xs-12 col-sm-12 col-md-2"></div>
 <div class="col-xs-12 col-sm-12 col-md-8">
		 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">REPORTE DE INVENTARIO</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
				<label class="col-md-3 control-label" for="textinput">Orden del Reporte:</label>  
				  <div class="col-md-4">
					  <select name="order_by" id="order_by" class="form-control">
						<option value="1">SECUENCIAL</option>
						<option value="2">ASCENDENTE</option>
						<option value="3">DESCENDENTE</option>
						<option value="4">STOCK</option>
						<option value="5">STOCK AGOTADO</option>
					  </select>
				  </div>
				  <div class="col-md-2">
						<label>Contador:</label> <input type="checkbox" name="contador" id="contador">
				  </div>
				  <div class="col-md-3">
						<button type="button" id="reporte_inventario" class="btn btn-sm btn-primary" aria-label="Left Align">
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
