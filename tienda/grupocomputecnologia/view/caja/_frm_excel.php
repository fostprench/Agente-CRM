
<script type="text/javascript" src="web/js/evnt/reporte_excel.js" ></script>

 <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'>REPORTE DE CAJA  AL <?PHP echo $fecha; ?> <button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button></legend>
			<input type="hidden" name="_id_" id="_id_"value="<?PHP echo $idcaja; ?>">
			<input type="hidden" name="_fecha_" id="_fecha_"value="<?PHP echo $fecha; ?>">
				
				<div class="form-group">
					 <div class="col-xs-12 col-sm-12 col-md-3" ></div>	
					 <div class="col-xs-12 col-sm-12 col-md-3" >	
							<ul class="list-group">
								<li class="list-group-item"><img class="img-responsive" src="web/images/excel_2003.png" style="margin:0 auto"/></li>
								<li class="list-group-item text-center">
									<button type="button" class="btn btn-success" id="excel_2003">Microsoft Excel <span class="badge">2003</span></button>
								</li>
							</ul>
					 </div>
					<div class="col-xs-12 col-sm-12 col-md-3">
							<ul class="list-group">
								<li class="list-group-item"><img class="img-responsive" src="web/images/excel_2007.png" style="margin:0 auto"/></li>
								<li class="list-group-item text-center">
									<button type="button" class="btn btn-success" id="excel_2007">Microsoft Excel <span class="badge">2007</span></button>
								</li>
							</ul>
					</div>
					 <div class="col-xs-12 col-sm-12 col-md-3" ></div>	
				 </div>
			
				
				<div class="form-group">
				  <div class="col-md-12 text-center">
					<input type="button" value="Cerrar [ X ]" onclick="closeWindow();" class="btn btn-primary"/>
				  </div>
				</div>

	</fieldset>
</form>

<div style="padding-top:20%">
</div>
