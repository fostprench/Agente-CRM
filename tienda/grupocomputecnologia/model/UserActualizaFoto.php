<?php
session_start();
include_once("Main2.php");
class User extends Main 
{
	function ActualizaUserFoto($foto)//para poder cambiar el nuevo pasword
	{
		$id = $_SESSION['id_usuario'];
	    $sql="UPDATE  usuario set foto='".$foto."'  where idusuario ='".$id."'  ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
	    return $sql;
	}
	
	
	
}
?>
