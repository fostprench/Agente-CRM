<?php
header('Content-Type: text/html; charset=utf-8');
//ini_set('memory_limit', '1024M');
//ini_set('upload_max_filesize', '1024M');

include("../lib/SimpleImage.class.php"); 

if ($_FILES["obj"]["error"] > 0){ 
	echo "Hay alg&uacute;n error con la imagen,"; 
}
else{ 
	$var_name_img = $_FILES["obj"]["name"]; 
	if($_POST["opcion"]==1){
		$var_img_dir = "../web/images/upload/";
	}else{
		$var_img_dir = "../view/fotos_user/";
	}
	 
	$var_ancho = 375; 
	$var_alto =  258;
	if (move_uploaded_file($_FILES["obj"]["tmp_name"], $var_img_dir.$var_name_img)){
		$subida = true; 
	}
	if ($subida === true){ 
		$obj_simpleimage = new SimpleImage(); 
		$obj_simpleimage->load($var_img_dir.$var_name_img);  
		if ( ($_FILES["obj"]["type"]) != 'image/gif'){
			$var_nuevo_archivo = time().rand().$var_name_img; 
		}else{ //sino
			$var_nuevo_archivo = time().rand().$var_name_img; 
		}
		$obj_simpleimage->resize($var_ancho,$var_alto);
		$var_nuevo_archivo = strtolower(str_replace(' ', '_', $var_nuevo_archivo)); 
		$obj_simpleimage->save($var_img_dir.$var_nuevo_archivo); 
		unlink($var_img_dir . $var_name_img); 
		
		if($_POST["opcion"]==3){
			require_once '../model/UserActualizaFoto.php';
			$objeto = new  User();
			$save_foto = $objeto->ActualizaUserFoto($var_nuevo_archivo);
		}
	
		echo $var_nuevo_archivo;
	}
}


?>