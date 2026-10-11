
	<h3 class="titulo text-center">DETALLE DE PRODUCTO</h3>
			<span class="alex"></span><br/>			
				
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4"></div>
					<div class="col-xs-12 col-sm-4 col-md-4">
								<div class="thumbnail">
									<img class="img-responsive" alt="descripcion" src="web/images/upload/<?php echo $obj->foto; ?>">
								  <div class="caption">
									<h5 class="title text-uppercase text-center"><?php echo $obj->descripcion; ?></h5>
									<p class="descripcion"><span> <?php echo $obj->informacion; ?></span></p>
									<p> <span class="label label-primary"><?php echo 'MARCA: '.$obj->marca; ?></span> </p>
									<p> <span class="label label-primary"><?php echo 'STOCK: '.$obj->stock; ?></span> </p>
									<p  CLASS="text-center"><a href="javascript:load_productos('<?php echo $atras;  ?>')" class="btn btn-xs btn-primary" role="button"> ATRAS <span class="badge"> <= </span></a> 
								 </div>
								</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4"></div>
				</div> 
				  
