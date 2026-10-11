<?php
include_once("Main.php");
require_once("lib/funciones.php");
class garantia extends Main 
{
	
	public function newgarantia($P)
    {   
			$sql =$this->Query("sp_garantia(0,:p2,:p3,:p4,:p5,:p6,:p7)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':p2',$P['idfalla'], PDO::PARAM_INT);
                $stmt->bindValue(':p3',$P['idproducto'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['serie'], PDO::PARAM_INT);
                $stmt->bindValue(':p5',$P['detalle_falla'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',date('Y-m-d'), PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['idventa'], PDO::PARAM_INT);
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
   
	
	function buscar_serie($serie) 
	{
        $stmt = $this->db->prepare("
		SELECT dv.glosa as serie, dv.idproducto as idproducto,  p.descripcion as producto, v.nro_comprobante as comprobante, v.fecha as f_comprobante, v.tipo_venta as tipo_venta,v.idcliente as idcliente, c.nombres as cliente, v.idventa as idventa, p.idtipo as tipo
		FROM venta as v
		inner join detalle_venta as dv on (v.idventa=dv.idventa) 
		inner join producto as p on (p.idproducto = dv.idproducto)
		inner join cliente as c on (c.idcliente=v.idcliente)
		WHERE dv.glosa like '%$serie%'		
		");
        $stmt->execute();
        $obj = $stmt->fetchObject();
		
		
		if($stmt->rowCount()==0){
			$msg = false;
			$text = "SERIE  NO EXISTE EN LA BASE DE DATOS";
		}elseif($stmt->rowCount()==1){
			$msg = true;
			$text = "SERIE ENCONTRADA EN LA BASE DE DATOS";
		}elseif($stmt->rowCount()>1){
			$msg = false;
			$text = "EXISTE MAS DE UNA COINCIDENCIA DE LA EN LA BASE DE DATOS";
		}
		$data = array();
		$data['obj']= $obj;
		$data['msg']= $msg;
		$data['text']= $text;
		return $data;
    }
	
	function deletegarantia($id)
    {
		$stmt2 = $this->db->prepare("delete from garantia WHERE idgarantia = :id1");
		$stmt2->bindValue(':id1', $id , PDO::PARAM_INT);
		$stmt2->execute();
		return array('rep'=>'1','msg'=>'ELIMINADO');
    }
	
	
}
?>