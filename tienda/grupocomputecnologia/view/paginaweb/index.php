<?php
if(isset($_POST['url'])){
	
	//if (file_exists("template/".$_POST['url'].'.php')) {
	if (file_exists("template/".$_POST['url'])) {
		//include("template/".$_POST['url'].'.php');
		include("template/".$_POST['url']);
	} else {
		include("template/Error.php");
	}
	
}else{
	include("template/Error.php");
}
?>