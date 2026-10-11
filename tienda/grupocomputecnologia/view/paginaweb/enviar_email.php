<?php

if($_POST){
		
		$nombre= trim($_POST['nombre']);
		$email= trim($_POST['email']);
		$asunto=trim($_POST['asunto']);
		$comentario=trim($_POST['comentario']);
		
		$emailTo = 'cliente@siscomp.comlu.com';
		$subject = $asunto;
		$body = "Nombre: $nombre \n\nEmail: $email \n\nAsunto: $asunto \n\nComentario: $comentario\n";
		$cabecera ='Para: Siscomp@hotmail.com' ."\r\n".
		'Enviado Por: ' . $email. "\r\n" .
		'Para:Siscomp@hotmail.com';
		mail($emailTo, $subject, $body, $cabecera);
}else{
	
	echo "nop";
}


?>