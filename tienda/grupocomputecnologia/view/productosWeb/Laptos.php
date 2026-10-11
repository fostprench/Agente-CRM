
	<h3 class="titulo text-center">LAPTOPS</h3>
			<span class="alex"></span><br/>			
				
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 text-justify">
						En Siscomp comercializamos Laptops de las marcas reconocidas en el mercado peruano.<br/>
						Contamos con equipos port&aacute;tiles de alto desempe&ntilde;o, en nuestras tiendas 
						hacemos la recomendaci&oacute;n a conciencia de las necesidades espec&iacute;ficas 
						de cada cliente antes de decidir la compra.<br/><br/>
						
						Pon tu vida en marcha. Mantente en contacto cu&aacute;ndo y d&oacute;nde quieras. 
						Ponte al corriente en tu trabajo. Estudia y socializa. Juega o disfruta de una pel&iacute;cula
						lejos de tu casa. Si lo puedes so&ntilde;ar, nosotros te facilitamos hacerlo de forma virtual. <br/><br/>
						
						Escoge de nuestra enorme selecci&oacute;n de laptops vers&aacute;tiles y estilizadas o bien 
						dec&iacute;dete por la comodidad de nuestras netbooks, que son las mejores en su clase.<br/><br/>
						Tenemos a su disposici&oacute;n laptops con procesadores Intel Core I3, I5, I7. Procesadores AMD de 2 y 4 n&uacute;cleos con pantallas de 13.3 pulgadas, 14'' y 15.6''.Todos nuestros productos incluyen Malet&iacute;n para laptops y Mouse USB gratis.

					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<img src="images/laptop.jpg" class="img-responsive"/>
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
									<p class="text-center"><a href="javascript:_verProducto(<?php echo $val['id'];  ?>,'Laptos')" class="btn btn-xs btn-default" role="button">VER <span class="badge">+</span></a> 
								 </div>
								</div>
							</div>
							
						<?php $cont++; if($cont==3) { ?>	</div>   <?php $cont=0;  } ?>	
					<?php } ?>