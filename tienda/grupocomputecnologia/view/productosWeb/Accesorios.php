
	<h3 class="titulo text-center">ACCESORIOS</h3>
			<span class="alex"></span><br/>			
				
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-4 text-justify">
						Comercializamos <b>suministros</b> para impresoras tales como tintas originales, 
						tintas para sistemas continuos, cintas de impresi&oacute;n, toners originales y compatibles,
						papel fotogr&aacute;fico de alta calidad.<br/><br/>
						<b>Accesorios</b> para computadoras: teclados,
						mouse, parlantes con sub woofer y lector de memorias USB, camaras web, auriculares 
						con microfono, tarjetas de red inal&aacute;mbricas, adaptadores de corriente para laptop,
						fundas, maletines para laptops y tablets, coolers para laptops, memorias USB, 
						cables de conectividad para equipos inform&aacute;ticos y otros.
					</div>
					<div class="col-xs-12 col-sm-6 col-md-8">
						<img src="images/accesorios.jpg" class="img-responsive"/>
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
									<!--<p> <span class="label label-primary"><?PHP echo 'STOCK: '.$val['stock']; ?></span> </p>-->
									<p class="descripcion acortar"><span><?PHP echo $val['informacion']; ?></span></p>
									<p> <span class="badge"><?PHP echo 'STOCK: '.$val['stock']; ?></span> </p>
									<p class="text-center"><a href="javascript:_verProducto(<?php echo $val['id'];  ?>,'Accesorios')" class="btn btn-xs btn-primary" role="button">VER <span class="badge">+</span></a> 
								 </div>
								</div>
							</div>
							
						<?php $cont++; if($cont==3) { ?>	</div>   <?php $cont=0;  } ?>	
				<?php } ?>