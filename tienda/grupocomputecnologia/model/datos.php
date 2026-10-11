<?php
include_once("Main_datos.php");


class User extends Main 
{
    function Start() 
	{
	
$user = "admin";
$admin = "123";
$sucursal = 1;

		$stmt = $this->db->prepare("
		SELECT u.idusuario as id_usuario, u.nombres as usuario, p.idperfil as id_perfil,p.descripcion as perfil,u.usuario as user
		FROM usuario as u, perfil as p, sucursal as s
		WHERE p.idperfil = u.perfil
		and s.idsucursal = u.idsucursal
		and usuario=:u and clave= :c and s.idsucursal=:s
		");					
								
		$stmt->bindParam(':u', $user , PDO::PARAM_STR);
		$stmt->bindParam(':c',$admin,PDO::PARAM_STR);
		$stmt->bindParam(':s',$sucursal,PDO::PARAM_STR);
        $stmt->execute();
		$obj = $stmt->fetchObject();
		$filas = $stmt->rowCount();
        return array('flag'=> $filas, 'obj'=>$obj ,'data'=>$_POST['login'].' '.$_POST['clave'].' '.$_POST['sucursal']);
    
}

}

$obj = new User();
$_p = $obj->Start();
$obj = $_p['obj'];
$flag = $_p['flag'];
echo 'El flag es: '.$flag.'<br/>';
echo $obj->usuario;
		
?>