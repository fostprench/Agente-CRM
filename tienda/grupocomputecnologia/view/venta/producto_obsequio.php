<script type="text/javascript">
	$(function(){
		
		function buscar_producto(){
			str = $("#_form_1").serialize();
			frm_cerrar();
			$("#emergente").load("index.php?"+str, function(){
			$.blockUI({
				message: $("#emergente"),
				css:{
					top: '2%',
					width: '80%',
					height: 'auto',
					left: '10%'
				},
				onBlock: function() {
							$('#q').setCursorToTextEnd();
						}
			}); 
		});
		}
		
		$("#Buscar").click(function(){
			buscar_producto();
		});

		$("#_form_1").submit(function(){
			buscar_producto();
			return false;
		});
    });
</script>

<div class="bs-example" data-example-id="contextual-panels">
    <div class="panel panel-primary">
      <div class="panel-heading text-center">
        <h3 class="panel-title">LISTA DE PRODUCTOS <button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button></h3>
      </div>
      <div class="panel-body">
				
				<form class="form-horizontal" id="_form_1" name="_form_1"  method="GET" >
					<input type="hidden" name="controller" value="Venta" />
					<input type="hidden" name="action" value="<?php echo $action?>" />
					<input type="hidden" name="p" value="1" />
					<div class="form-group">
					  <label class="col-xs-12 col-sm-2 col-md-2 control-label text-center">BUSCAR:</label>
					  <div class="col-xs-12 col-sm-8 col-md-8">
						<input type="text" name="q" id="q" value="<?php echo $query?>" class="form-control" placeholder="Buscar Producto">
					  </div>
					  <div class="col-xs-12 col-sm-2 col-md-2 text-center">
						<input type="button" id="Buscar" value="Buscar" class="btn btn-success" />
					  </div>
					</div>
				</form>
			

						<div class="table-responsive">
							<table class='table table-bordered table-striped' style="font-size:12px;" >
								<thead style='background-color:#428bca;color:#FFF'>
									<th  width="120" class='ui-widget-header'> Id </th>
									<th  width="120" class='ui-widget-header'> Categoria </th>
									<th  class='ui-widget-header'> Marca </th>
									<th  class='ui-widget-header'> Producto </th>
									<th  class='ui-widget-header'> Precio </th>
									<th  class='ui-widget-header'> Stock </th>
									<th align="center" width="30" class="ui-widget-header">OK</th>
								</thead>
								<?php  foreach($rows as $key => $val){ ?>
								<tr style="border-bottom:1px solid #666; background:#F0F0F0;">

									<td ><?php  echo $val[0]; ?></td>
									<td ><?php  echo $val[1]; ?></td>
									<td ><?php  echo $val[2]; ?></td>
									<td title="<?php  echo $val[7]; ?>"><?php  echo $val[3]; ?></td>
									<td ><?php  echo $val[6]; ?></td>
									<td ><?php  echo $val[5]; ?></td>
									<td align="center"><a href="javascript:devolver_producto_obs('<?php  echo $val[0]; ?>','<?php  echo addslashes($val[3]); ?>','<?php  echo $val[6]; ?>');" title="OBSEQUIOS A PRECIO COSTO"><img src="web/images/accept.png"  border="0"></a></td>
								</tr>
									<?php }?>
							</table>
						
				
				<div id="res" style="display:none;"></div>
				<?php echo $pag;?>
				<?php //echo $consulta;?>
				<?php //echo $query;?>
				
				</div>
		
			<form  class="form-horizontal">
				
					<hr style="border-top: 1px solid #e5e5e5; width:100%"/>
			
					<div class="form-group">
					  <div class="col-md-12 text-center">
						<input type="button" value="Cerrar" onclick="closeWindow();" class="btn btn-success"/>
					  </div>
					</div>
			</form>
			
      </div>
    </div>
</div>