<?php 
	//if(!isset($_GET['key'])) { $n=rand(1000,9999); } else { $n = base64_decode($_GET['key']); }
	$n = $_GET['key'];
	header('Content-Type: image/png');
	$grafico = @imagecreate(60, 20) or die("No se puede inicializar img");;
	$backgroundColor = array(255, 255, 255);
	$fondo = imagecolorallocate($grafico,$backgroundColor[0],$backgroundColor[1],$backgroundColor[2]);
	
	 $colors = array(
        array(27,78,181), // blue
        array(22,163,35), // green
        array(214,36,7),//red
	);
	$color2= $colors[mt_rand(0, sizeof($colors)-1)];
        $color = imagecolorallocate($grafico, $color2[0], $color2[1], $color2[2]);
		
	//$color = imagecolorallocate($grafico, 255, 255, 255);
	// $margen =3;
	// for($x = 0; $x < strlen($n); $x++) {
		// $c = substr($n,$x,1);
		// if(($x % 2)==0) { $rend = 10; } else { $rend = -10; }
		// imagettftext($grafico, 14, $rend, $margen, 16, $color, 'arial.ttf', $c);
		// $margen += 14;
	// }
	
	imagestring($grafico, 5, 10, 2,$n, $color); //SACAR ESTA LINEA CUANDO SE UTILIZA UNA FUENTE PARA LA IMAGEN GENERADA
	
	imagepng($grafico);
	imagedestroy($grafico);
?>