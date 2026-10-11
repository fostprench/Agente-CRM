<?php
include_once("Main.php");
class proveedores extends Main
{
	function newproveedor($P)
    {
		if($P['oper']==1)
		{    
			$sql =$this->Query("sp_proveedor(1,0,:p3,:p4,:p5,:p6,:p7,:p8,:p9)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                //$stmt->bindValue(':p2',$P['idproveedor'], PDO::PARAM_STR);
                $stmt->bindValue(':p3',$P['descripcion'], PDO::PARAM_STR);
                $stmt->bindValue(':p4',$P['ruc'], PDO::PARAM_INT);
                $stmt->bindValue(':p5',$P['telefono'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['lugar'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['direccion'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['contacto'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['email'], PDO::PARAM_STR);
                $stmt->execute();
                $this->db->commit();
				$resp = array('rep'=>'1','str'=>'Ok');
				return $resp;
			}
			catch(PDOException $e) 
			{	$this->db->rollBack();
				return array('res'=>"3",'msg'=>'no se pudo realizar la accion de insertar : '.$e->getMessage());
			}
		}
		else
		{  
			$sql =$this->Query("sp_proveedor(2,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				$stmt->bindValue(':p2',$P['idproveedor'], PDO::PARAM_STR);
                $stmt->bindValue(':p3',$P['descripcion'], PDO::PARAM_STR);
                $stmt->bindValue(':p4',$P['ruc'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['telefono'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['lugar'], PDO::PARAM_STR);
				$stmt->bindValue(':p7',$P['direccion'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['contacto'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['email'], PDO::PARAM_STR);
				$stmt->execute();
				$this->db->commit();
				$resp = array('rep'=>'2','str'=>'Ok');
				return $resp;
			}
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"4",'msg'=>'no se pudo realizar la accion de actualizar : '.$e->getMessage());
			}
		}
	}

	function edit($id ) 
	{
	    $stmt = $this->db->prepare("SELECT * FROM proveedor WHERE idproveedor = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
		
    }
      
    function deleteproveedor($id)
    {     $stmt = $this->db->prepare("delete   FROM proveedor WHERE idproveedor = :id");
          $stmt->bindValue(':id', $id , PDO::PARAM_STR);
          $res=$stmt->execute();
        return $res;
    }
	
}
?>