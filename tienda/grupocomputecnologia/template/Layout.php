<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="empresa" content="siscomp" />
	<meta name="keywords" content="Pagina  web,moyobamba,san martin, siscomp, computadoras, soporte"/>
	<meta name="author" content="siscomp" />
	<META name="Revisit" content="30 days">
	<META name="Copyright" content="AlexDelgadoAltamirano">
	<meta name="robots" content="all" />
	
		<title>COMPUTECNOLOG&Iacute;A  E.I.R.L</title>

		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/style.css" >
		<link rel="stylesheet" href="web/css/bootstrap-datepicker.css" />
		<link rel="stylesheet" href="web/css/bootstrap-datetimepicker.min.css" />
		

		<link rel="stylesheet" type="text/css" href="web/css/stilos.css" />
		<link rel="stylesheet" type="text/css" href="web/css/grilla.css" />
		<link rel="stylesheet" type="text/css" href="web/css/progress_bar.css" />

		
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="web/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="web/js/bootstrap-datepicker.es.min.js"></script>
		
		<script type="text/javascript" src="web/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
		<script type="text/javascript" src="web/js/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
		
	   
		<script type="text/javascript" src="web/js/loader.js"></script>
		<script type="text/javascript" src="web/js/utiles.js"></script>
		<script type="text/javascript" src="web/js/required.js"></script>
		<script type="text/javascript" src="web/js/menu.js"></script>
		<script type="text/javascript" src="web/js/funciones.js"></script>
		<script type="text/javascript" src="web/js/jquery.blockUI.js"></script>
		<script type="text/javascript" src="web/js/ver.js"></script>
		<script type="text/javascript" src="web/js/cerrar_caja.js"></script>
		<script type="text/javascript" src="web/js/reporte_caja.js"></script>
		
		<script type="text/javascript" src="web/js_graficos/highcharts.js"></script>
		<script type="text/javascript" src="web/js_graficos/highcharts-3d.js"></script>
		<script type="text/javascript" src="web/js_graficos/drilldown.js"></script>
		
		<!-- Este archivo es para darle un estilo (Este archivo es Opcional) -->
	    <script type="text/javascript" src="web/js_graficos/themes/grid.js"></script>
		<!-- Este archivo es para poder exportar losd atos que obtengamos -->
		<script type="text/javascript" src="web/js_graficos/modules/exporting.js"></script>
		
		  <!--[if lt IE 9]>
		  <script src="js/html5shiv.min.js"></script>
		  <script src="js/respond.min.js"></script>
		<![endif]-->

		<script type="text/javascript">
		$(document).ready(function() 
				{       
					$.get('index.php','controller=Sistema&action=Menu',function(menu)
					{      
						var opciones_menu=menu;
						$(".menu_sistema").Menu(opciones_menu);
						// var html = '';
						// $(".menu_sistema").html("hola");
						
					},'json');
				});		  
		</script>
	</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">MENU SISTEMA</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav menu_sistema">
                <li class="active"><a href="."><span class="glyphicon glyphicon-home" aria-hidden="true"><!---INICIO--></span></a></li>
              </ul>
			  <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;<span class="caret"><!---SALIR--></span></a>
				  <ul class="dropdown-menu">
					
					<li>
							<div class="col-xs-12 col-sm-2 col-md-2"></div>
							<div class="col-xs-12 col-sm-8 col-md-8">
									<img src="view/fotos_user/<?php echo $_SESSION['foto']; ?>" class="img-circle img-responsive"/>
							</div>
							<div class="col-xs-12 col-sm-2 col-md-2"></div>
					</li>
					
					
					<li><a href="javascript:void(0);" onclick="paginacion('controller=User&action=Panel')">
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Configuracion de Cuenta</a></li>
					<li><a href="javascript:void(0);" onclick="paginacion('controller=User&action=logout')"> <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Cerrar Session</a></li>
				  </ul>
				</li>
			  </ul>
            </div>
        </div>
</nav>


<div class="container" id="container">
    <div class="jumbsotron" id="jumbotron">
        <div id="fondotable" class='text-center' style="padding:30px;"></div>
		<div id="cont">
					
					<div style='padding-top: 5%;padding-bottom:9%;font-size:24px;font-weight:bold;color:#0053d0;' >
					<img style='border:0;margin:0 auto' src='web/images/hola.jpg' class="img-responsive"/><br/>
					<p><?php echo $_SESSION['empresa']; ?></p>
					</div>

		</div>
		
	
		
	</div>
</div>	
<footer>
			<div class="container">
			 <div class="row">	
					<div class="col-xs-12 col-sm-12 col-md-4"></div>
					<div class="col-xs-12 col-sm-12 col-md-4 text-center">
						<div class="social facebook">
							<a href="https://www.facebook.com/computecnologianc/"></a>
						</div>
						<div class="social twitter">
							<a href="#"></a>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4"></div>
			 </div>
			 <div class="row">
			  <hr>
				<div class="col-xs-12 col-sm-12 col-md-12">
						
				
					<p class="copy pull-left">
						  &copy; COMPUTECNOLOG&Iacute;A  E.I.R.L &copy;  <?php echo date('Y');?> 
					</p>
					<p class="copy pull-right">
						By <a class="_link" href="http://programacionwebenphp.blogspot.com/2015/02/desarrollo-de-sistemas-de-informacion-y.html" target="_blank" > A&D System </a>
					</p>
				</div>
			</div>
		  </div>
		</footer>
		
		<div id="ventana"></div> <!--para mostrar ventana emergente -->
		<div id="capa"></div><!-- para mostrar transfondo oscuro -->
		<div class="blockUI" style="display: none;"></div>
		<div id="emergente"></div>
		
	</body>
</html>