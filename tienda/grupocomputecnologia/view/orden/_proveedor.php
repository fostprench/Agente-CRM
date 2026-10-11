
<script type="text/javascript">
	$(function(){	
		$("#_form_1").submit(function(){
			q = $("#q").val();
			frm_cerrar();
			$.get('index.php','controller=Compras&action=mostrar_proveedor&q='+q,function(data){
					$("#emergente").html(data);
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
		
		  return false;
		});
    });
</script>



<div class="bs-example" data-example-id="contextual-panels">
    <div class="panel panel-primary">
      <div class="panel-heading text-center">
        <h3 class="panel-title">LISTA DE PROVEEDORES</h3>
      </div>
      <div class="panel-body">
				
				<form class="form-horizontal" id="_form_1" name="_form_1"  method="GET" >
					<input type="hidden" name="controller" value="cliente" />
					<input type="hidden" name="action" value="mostrar" />
					<input type="hidden" name="p" value="1" />
					<div class="form-group">
					  <label class="col-xs-12 col-sm-2 col-md-2 control-label text-center">BUSCAR:</label>
					  <div class="col-xs-12 col-sm-8 col-md-8">
						<input type="text" name="q" id="q" value="<?php echo $query;?>" class="form-control" placeholder="Buscar Proveedor">
					  </div>
					  <div class="col-xs-12 col-sm-2 col-md-2 text-center">
						<input type="submit" value="Buscar" class="btn btn-success" />
					  </div>
					</div>
				</form>
			

						<div class="table-responsive">
							<table  id="result" class="table"  style="font-size:12px">
								<thead style="color:#fff">
									<?php
									foreach ($cabecera as $c)
									{
										echo "<th align='left' class='ui-widget-header'>".$c."</th>";
									}
									?>
									<th align="center" width="30" class="ui-widget-header">OK</th>
								</thead>
								<?php  foreach($rows as $key => $val)
								{?>
								<tr style="border-bottom:1px solid #666; background:#F0F0F0;">

									<td align="left"><?php  echo $val[0]; ?></td>
									<td align="left"><?php  echo $val[1]; ?></td>
									<td align="left"><?php  echo $val[2]; ?></td>
									<td align="left"><?php  echo $val[3]; ?></td>
									<td align="left"><?php  echo $val[4]; ?></td>
									<td align="center"><a href="javascript:devolver_proveedor('<?php  echo $val[0]; ?>','<?php  echo $val[1]; ?>');" title="Seleccionar"><img src="web/images/accept.png"  border="0"></a></td>
								</tr>
									<?php }?>
							</table>
						</div>
				
				<div id="res" style="display:none;"></div>
				<?php echo $pag;?>
		
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