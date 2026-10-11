<script>
	$(function(){
		$("#nuevo").click(function(){
		
			$("#emergente").load("index.php?controller=Cliente&action=create_ext", function(){
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
		
		});
	
		function buscar_producto(){
			q = $("#q").val();
			frm_cerrar();
			$.get('index.php','controller=Cliente&action=mostrar&q='+q,function(data){
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
        <h3 class="panel-title">CLIENTES REGISTRADOS <button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button></h3>
      </div>
      <div class="panel-body">
				
				<form class="form-horizontal" id="_form_1" name="_form_1"  method="GET" >
					<input type="hidden" name="controller" value="Cliente" />
					<input type="hidden" name="action" value="mostrar" />
					<input type="hidden" name="p" value="1" />
					<div class="form-group">
					  <label class="col-xs-12 col-sm-2 col-md-2 control-label text-center">BUSCAR:</label>
					  <div class="col-xs-12 col-sm-6 col-md-6">
						<input type="text" name="q" id="q" value="<?php echo $query?>" class="form-control" placeholder="Buscar Cliente">
					  </div>
					  <div class="col-xs-12 col-sm-4 col-md-4 text-center">
						 <input type="button" class="btn btn-primary" value="Buscar" name="Buscar" id="Buscar"/>
						 <input type="button" class="btn btn-primary" name="nuevo" id="nuevo" value="nuevo"/>
					  </div>
					</div>
				</form>
			

						<div class="table-responsive">
							<table  id="result" class='table table-bordered table-striped' align="center" style="font-size:12px">
								<thead style='background-color:#428bca;color:#FFF'>
									<?php
									foreach ($cabecera as $c)
									{
										echo "<th align='left' class='ui-widget-header'>".$c."</th>";
									}
									?>
									<th align="center" width="30" >OK</th>
								</thead>
								<?php  foreach($rows as $key => $val)
								{?>
								<tr style="border-bottom:1px solid #666; background:#F0F0F0;">

									<td align="left"><?php  echo $val[0]; ?></td>
									<td align="left"><?php  echo $val[1]; ?></td>
									<td align="left"><?php  echo $val[2]; ?></td>
									<td align="left"><?php  echo $val[3]; ?></td>
									<td><a href="javascript:devolver_cliente_proforma('<?php  echo $val[0]; ?>','<?php  echo $val[1]; ?>');" title="Aceptar"><img src="web/images/accept.png"  border="0"></a></td>
								</tr>
									<?php }?>
							</table>
						</div>
				
				
				<?php echo $pag;?>
				
			<div id="res" style="display:none;"></div>
			
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