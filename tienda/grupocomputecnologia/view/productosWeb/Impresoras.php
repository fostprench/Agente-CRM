
	<h3 class="titulo text-center">IMPRESORAS</h3>
			<span class="alex"></span><br/>			
				
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 text-justify">
						En Siscomp encontraras Impresoras a tinta convencionales y con
						sistema continuo multifuncionales, impresoras matriciales de 
						alta velocidad, impresoras l&aacute;ser, impresoras de gran formato, 
						plotters, scaners, camaras digitales.
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<img src="images/impresoras.jpg" class="img-responsive"/>
					</div>
				</div> 
				  
				<h3 class="noticia text-uppercase text-center"><span>NUESTROS PRODUCTOS</span></h3>
				
				<?php $cont=0; foreach($productos as $key=>$val) { ?>
					   <?php if($cont==0) { ?>	<div class="row">   <?php } ?>	
					   
							 <div class="col-xs-12 col-sm-6 col-md-4">
								<div class="thumbnail">
									<img class="img-responsive" alt="descripcion" src="web/images/upload/<?PHP echo $val['foto']; ?>">
								  <div class="caption">
									<h5 class="title text-uppercase text-center"><?PHP echo $val['descripcion']; ?></h5>
									<p class="descripcion acortar"><span><?PHP echo $val['informacion']; ?></span></p>
									<p> <span class="label label-primary"><?PHP echo 'STOCK: '.$val['stock']; ?></span> </p>
									<p class="text-center"><a href="javascript:_verProducto(<?php echo $val['id'];  ?>,'Impresoras')" class="btn btn-xs btn-default" role="button">VER <span class="badge">+</span></a> 
								 </div>
								</div>
							</div>
							
						<?php $cont++; if($cont==3) { ?>	</div>   <?php $cont=0;  } ?>	
				<?php } ?>