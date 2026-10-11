<?php
include_once("Main.php");
class inventario extends Main
{
	function edit_inventario($P)
    { 
			$sql =$this->Query("sp_inventario(:id,:p2,:p3,:p4)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				$stmt->bindValue(':id',$P['idinventario'], PDO::PARAM_INT);
				$stmt->bindValue(':p2',$P['stock'], PDO::PARAM_STR);
				$stmt->bindValue(':p3',$P['precio_c'], PDO::PARAM_STR);
				$stmt->bindValue(':p4',$P['precio_v'], PDO::PARAM_STR);
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

	function edit($id) 
	{
        $stmt = $this->db->prepare("SELECT idinventario, p.descripcion as producto, i.stock,i.precio_c, i.precio_v
									FROM inventario as i, producto as p
									WHERE i.idproducto = p.idproducto and i.idinventario =  :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
      
}
?>