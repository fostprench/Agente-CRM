
	<h3 class="titulo text-center">TABLETS</h3>
			<span class="alex"></span><br/>			
				
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 text-justify">
						La tablet m&aacute;s completa te da el funcionamiento m&aacute;ximo 
						que realmente quieres. Desde el primer momento en que la enciendes, 
						comienzas a disfrutar la experiencia completa Android, una bater&iacute;a 
						de vida prolongada y gracias a sus dos c&aacute;maras puedes compartir, 
						conectar y capturar el momento de una manera m&aacute;s f&aacute;cil. 
						<br/>
						Tambi&eacute;n te ofrece opciones avanzadas de conexi&oacute;n inal&aacute;mbrica 
						y muchos puertos. As&iacute; como apoyo para la red en Adobe Flash. No importa 
						cu&aacute;l escojas, todas son &uacute;nicas en su estilo.
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<img src="images/tablet.jpg" class="img-responsive"/>
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
									<p class="text-center"><a href="javascript:_verProducto(<?php echo $val['id'];  ?>,'Tablets')" class="btn btn-xs btn-default" role="button">VER <span class="badge">+</span></a> 
								 </div>
								</div>
							</div>
							
						<?php $cont++; if($cont==3) { ?>	</div>   <?php $cont=0;  } ?>	
				<?php } ?>