<html>
<head>
	<title>LISTAS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>SOFTWARE DE VENTAS</title>
	<link rel="stylesheet" type="text/css" href="web/css/stilos.css" />
	<link rel="stylesheet" type="text/css" href="web/css/grilla.css" />
	<link rel="stylesheet" type="text/css" href="web/css/jquery-ui-1.8.1.custom.css" />
	<script type="text/javascript" src="web/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="web/js/jquery-ui-1.8.17.custom.min.js"></script>
	<script type="text/javascript" src="web/js/jquery.ui.datepicker-es.js"></script>
	<script type="text/javascript" src="web/js/loader.js"></script>
	<script type="text/javascript" src="web/js/required.js"></script>
	<script type="text/javascript" src="web/js/menu.js"></script>
	<script type="text/javascript" src="web/js/funciones.js"></script>
	<style type="text/css">
<!--
#ventana_foto {
	position:absolute;
	left:4%;
	top:2%;
	width:650px;
	height:370px;
	z-index:2;
	background-color: #FFFFFF;
	visibility:hidden;
	-moz-border-radius: 9px;
	-webkit-border-radius: 9px;
	border-radius: 9px;
}
#capa_foto{
	position:absolute;
	left:0px;
	top:0px;
	width:100%;
	height:400px;
	background-color: #333333;
	opacity: .4 ;
	-moz-opacity:0.4 ;
	filter: alpha(opacity=50);	
	visibility:hidden;	
}
.title
{

background: #6386a1 url(ventana.png) 50% 50% repeat-x;
border: 1px solid #63737e;
color: #ffffff; font-weight: bold; 
	-moz-border-radius: 9px;
	-webkit-border-radius: 9px;
	border-radius: 9px;

}

-->
</style>
</head>
<body>
<div align="center">
 <div class="contenidos_listas">

            	
                
                <div id="cCont_listas">
                 <?php echo $content; ?>
                </div>
             <div  class="spacer"></div>   
            </div>
</div>
<div id="ventana_foto"></div>
<div id="capa_foto"></div>
</body>
</html>