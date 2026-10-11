<?php
include_once("Main.php");
require_once("lib/funciones.php");
class productos extends Main 
{
	
	public function newproducto($P)
    {
	   if($P['oper']==1)
		{    
			$sql =$this->Query("sp_producto(1,0,:p3,:p4,:p5,:p6,:p7,:p8)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                //$stmt->bindValue(':p2',$P['idproducto'], PDO::PARAM_INT);
                $stmt->bindValue(':p3',$P['idmarca'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['idtipo'], PDO::PARAM_INT);
                $stmt->bindValue(':p5',$P['descripcion'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['imagen_producto'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['web'], PDO::PARAM_INT);
                $stmt->bindValue(':p8',$P['informacion'], PDO::PARAM_STR);
                $stmt->execute();
                $this->db->commit();
				$resp = array('rep'=>'1','str'=>'Ok');
				return $resp;
			}
			catch(PDOException $e) 
			{	$this->db->rollBack();
				return array('res'=>"3",'msg'=>'OO no se pudo realizar la accion de insertar : '.$e->getMessage());
			}
		}
		else
		{  
			$sql =$this->Query("sp_producto(2,:p2,:p3,:p4,:p5,:p6,:p7,:p8)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				$stmt->bindValue(':p2',$P['idproducto'], PDO::PARAM_INT);
                $stmt->bindValue(':p3',$P['idmarca'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['idtipo'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['descripcion'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['imagen_producto'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['web'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['informacion'], PDO::PARAM_STR);
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
   
	
	function editproductos($id ) 
	{
        $stmt = $this->db->prepare("SELECT * FROM producto WHERE idproducto = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
	
	function _vermarca($id ) 
	{
        $stmt = $this->db->prepare("SELECT * FROM marca WHERE idmarca = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
	
	function deleteproducto($id)
    {
		$stmt2 = $this->db->prepare("delete from inventario WHERE idproducto = :id1");
		$stmt = $this->db->prepare("update producto set estado = 0 WHERE idproducto = :id2");
				$stmt2->bindValue(':id1', $id , PDO::PARAM_INT);
				$stmt2->execute();
				$stmt->bindValue(':id2', $id , PDO::PARAM_INT);
				$stmt->execute();
				return array('rep'=>'1','msg'=>'ELIMINADO');
    }
	
	
}
?>