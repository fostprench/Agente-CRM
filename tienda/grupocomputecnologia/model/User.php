<?php
include_once("Main.php");
//require_once("lib/class.upload.php");
//require_once("lib/funciones.php");
class User extends Main 
{
    function Start() 
	{
	    
					
		$stmt = $this->db->prepare("
		SELECT u.idusuario as id_usuario, u.nombres as usuario,u.foto as foto, p.idperfil as id_perfil,p.descripcion as perfil,u.usuario as user,u.clave
		FROM usuario as u, perfil as p, sucursal as s
		WHERE p.idperfil = u.perfil
		and s.idsucursal = u.idsucursal
		and usuario=:u and clave= :c and s.idsucursal=:s
		");					
								
		$stmt->bindParam(':u', $_POST['login'] , PDO::PARAM_STR);
		$stmt->bindParam(':c',$_POST['clave'],PDO::PARAM_STR);
		$stmt->bindParam(':s',$_POST['sucursal'],PDO::PARAM_INT);
        $stmt->execute();
		$obj = $stmt->fetchObject();
        return array('flag'=>$stmt->rowCount() , 'obj'=>$obj );
    }
	
	function datos_empresa(){
		$stmt = $this->db->prepare("select nombre,siglas,ruc,direccion,descripcion,telefono,propietario,logo,sitio_web from empresa where idempresa = 1");					
        $stmt->execute();
		$res = $stmt->fetchObject();
		return $res;
	}
	

	

	function show($id)
	{
	    $stmt = $this->db->prepare("SELECT * FROM usuario WHERE idusuario = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
	}
	
	function validar($u)//para que no tengan el mismo nombre de usuario
	{
		$sql="SELECT count(*) FROM usuario where usuario ='".$u."' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$set = $stmt->fetchAll();
		$rep=array();
		foreach( $set as $f)
		{
			$rep['rep']=$f[0];
		}
		return $rep;
	}
	
	function Validar_pass($pass, $id)//para ver si la clave coincide...
	{
	
	    $sql="SELECT count(idusuario) FROM usuario where idusuario ='".$id."' and clave='".$pass."' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$set = $stmt->fetchAll();
		$rep=array();
		foreach( $set as $f)
		{
			$rep['rep']=$f[0];
		}
		return $rep;
	}
	
	function change($c,$id)//para poder cambiar el nuevo pasword
	{
	    $sql="UPDATE  usuario set clave='".$c."'  where idusuario ='".$id."'  ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
	    $resp = array('rep'=>'1','msg'=>'su password a sido actualizado');
		return $resp;
	}
	
	function ActualizaUserFoto($id,$foto)//para poder cambiar el nuevo pasword
	{
	    $sql="UPDATE  usuario set foto='".$foto."'  where idusuario ='".$id."'  ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
	    return 1;
	}
	
	function newUser($P)
    { 
		if($P['oper']==1)
		{		 
			 $sql =$this->Query("sp_usuario(1,0,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10)");
			 $stmt =$this->db->prepare($sql);
			 try
			 {
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':p2',$P['idperfil'], PDO::PARAM_STR);
                $stmt->bindValue(':p3',$P['idsucursal'], PDO::PARAM_STR);
                $stmt->bindValue(':p4',$P['telefono'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['dni'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['nombres'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['sexo'], PDO::PARAM_INT);
                $stmt->bindValue(':p8',$P['usuario'], PDO::PARAM_INT);
                $stmt->bindValue(':p9',$P['clave'], PDO::PARAM_INT);
                $stmt->bindValue(':p10',$P['imagen_usuario'], PDO::PARAM_INT);
                $stmt->execute();
                $this->db->commit();
				  return array('rep'=>'1','str'=>'entraaa');
			}
			catch(PDOException $e) 
			{
				$this->db->rollBack();
			return array('res'=>"3",'msg'=>'no se pudo realizar la accion de insertar : '.$e->getMessage());
			} 
		
		}else{    
			
			$sql =$this->Query("sp_usuario(2,:id,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10)");
			$stmt =$this->db->prepare($sql);
			try
			{
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':id',$P['idusuario'], PDO::PARAM_STR);
                $stmt->bindValue(':p2',$P['idperfil'], PDO::PARAM_STR);
                $stmt->bindValue(':p3',$P['idsucursal'], PDO::PARAM_STR);
                $stmt->bindValue(':p4',$P['telefono'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['dni'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['nombres'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['sexo'], PDO::PARAM_INT);
                $stmt->bindValue(':p8',$P['usuario'], PDO::PARAM_INT);
                $stmt->bindValue(':p9',$P['clave'], PDO::PARAM_INT);
                $stmt->bindValue(':p10',$P['imagen_usuario'], PDO::PARAM_INT);

                $stmt->execute();
                $this->db->commit();
				$resp = array('rep'=>'2','str'=>'Ok','oper'=>$P['oper']);
				return $resp;
			}
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"4",'msg'=>'no se pudo realizar la accion de actualizar : '.$e->getMessage());
			}
		}
	}
	
	  function deleteUser($id)
    {
		
		$stmt2=$this->db->prepare("select foto from usuario WHERE idusuario = :id");
        $stmt2->bindValue(':id', $id , PDO::PARAM_INT);
       
		$stmt2->execute();
		$set = $stmt2->fetchAll();
		foreach($set as $val)
		{
		  $c=$val[0];
		}
		// $c=$c.'.jpg';
		  // unlink("view/fotos_user/". basename($c));
		 // $stmt = $this->db->prepare("delete from usuario WHERE idusuario = :id");
		  // $stmt->bindValue(':id', $id , PDO::PARAM_INT);
         // $res=$stmt->execute();
		 
		 
		$stmt = $this->db->prepare("UPDATE usuario set estado = 0 WHERE idusuario = :id");
		$stmt->bindValue(':id', $id , PDO::PARAM_INT);
        $res=$stmt->execute();
		
		 return $res;
		
			//return "hola";
          
    }
	
}
?>
