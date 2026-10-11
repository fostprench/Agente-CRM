
<script type="text/javascript" src="web/js/evnt/arqueo_inventario.js" ></script>

 <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim" class="form-horizontal">
            <fieldset>
			
			<legend class='text-center'><?PHP echo $titulo; ?> <button type="button" class="close" onclick="closeWindow();" aria-hidden="true">&times;</button></legend>
			<input type="hidden" name="_idventa" id="_idventa"value="<?PHP echo $idventa; ?>">
			
			<div class="form-group">
					 <div class="col-xs-12 col-sm-12 col-md-12 text-center" >				 
					 <div class="alert alert-success" id="msg-parte" class="text-center" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Realmente desea dar salida a este comprobante de pago:</div>		
					 </div>		
			</div>

				<div class="form-group">
					 <div class="col-xs-12 col-sm-12 col-md-4" ></div>	
					 <div class="col-xs-12 col-sm-12 col-md-4" >	
							<ul class="list-group">
								<li class="list-group-item"><img class="img-responsive" src="web/images/inventario.jpg" style="margin:0 auto"/></li>
								<li class="list-group-item text-center">
								
									
									<div class="form-group">
										  <div class="col-md-12 text-center">
											<div id="msg" >
													<button type="button" class="btn btn-success" id="liberar_comp">Liberar Comprobante <span class="badge"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </span></button>
										
											</div>
										  </div>
									</div>
								
								
								</li>
							</ul>
					 </div>
					 <div class="col-xs-12 col-sm-12 col-md-4" ></div>	
				 </div>
			
				
				<div class="form-group">
				  <div class="col-md-12 text-center">
					<input type="button" value="Cerrar [ X ]" onclick="closeWindow();" class="btn btn-primary"/>
				  </div>
				</div>

	</fieldset>
</form>

