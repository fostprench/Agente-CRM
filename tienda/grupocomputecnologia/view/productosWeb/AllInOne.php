
	<h3 class="titulo text-center">COMPUTADORAS TODO EN UNO</h3>
			<span class="alex"></span><br/>			
				
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-5 text-justify">
						PC All in One, Pantalla de 18.5'' WideScreen HD LED, Resoluci&oacute;n 1920x1080, 
						Procesador Intel Core i3 (3.30 GHz, Cach&eacute; L3), Memoria 4 GB DDR3 (Expandible a 16GB), 
						Disco duro 500 GB SATA, Grabador DVD SuperMulti, Video HD Graphics, LAN GigaBit Ethernet, 
						Tarjeta inal&aacute;mbrica WLAN 802.11 B/G/N, C&aacute;mara Web, Parlantes Estereo Integrados, 
						Lector de tarjetas de memoria. Sistema Operativo Windows 8 64-bit en espa&ntilde;ol.
					</div>
					<div class="col-xs-12 col-sm-6 col-md-7">
						<img src="images/all_in_one.jpg" class="img-responsive"/>
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
									<p class="text-center"><a href="javascript:_verProducto(<?php echo $val['id'];  ?>,'AllInOne')" class="btn btn-xs btn-default" role="button">VER <span class="badge">+</span></a> 
								 </div>
								</div>
							</div>
							
						<?php $cont++; if($cont==3) { ?>	</div>   <?php $cont=0;  } ?>	
					<?php } ?>