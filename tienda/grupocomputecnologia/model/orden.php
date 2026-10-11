<?php
include_once("Main_st.php");
class orden extends Main
{
	function regorden($P)
    {
		if($P['oper']==1)
		{	
			$sql =$this->Query("sp_orden(1,0,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13)");
			$stmt =$this->db->prepare($sql);
			
			$sql2 =$this->Query("sp_detalle_orden(:d1,:d2,:d3,:d4)");
			$stmt2 =$this->db->prepare($sql2);
			
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				
				if(empty($P['idcliente'])){ $cliente = 1;  }else{ $cliente = $P['idcliente']; }
				
                $stmt->bindValue(':p3',$cliente, PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['id_usuario'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['idtipo'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['idmarca'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['desc_equipo'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['desc_falla'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['accesorios'], PDO::PARAM_STR);
                $stmt->bindValue(':p10',$P['fecha_'], PDO::PARAM_STR);
                $stmt->bindValue(':p11',$P['atendido'], PDO::PARAM_STR);
                $stmt->bindValue(':p12',$P['total_servicio'], PDO::PARAM_STR);
                $stmt->bindValue(':p13',0, PDO::PARAM_STR);
                $stmt->execute();
				
				
			    $id_orden = $this->max_id("orden_st");
				
		      foreach ($P['codigo'] as $key => $value)
				{
					$stmt2->bindValue(':d1',$id_orden, PDO::PARAM_INT);
					$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
					$stmt2->bindValue(':d3',$P['precio_real'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d4',$P['cant_s'][$key], PDO::PARAM_INT);
					$stmt2->execute();
				}
			    
				
                $this->db->commit();
				$resp = array('rep'=>'1','msg'=>'REGISTRADO CORRECTAMENTE');
				return $resp;
			}
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"3",'msg'=>'no se pudo realizar la accion de insertar : '.$e->getMessage());
			}
		}
		else
		{  

			$sql =$this->Query("sp_orden(2,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13)");
			$stmt =$this->db->prepare($sql);
			
			$stmt4 =$this->db->prepare(" DELETE FROM detalle_orden WHERE idorden_st= :idd ");
			
			$sql2 =$this->Query("sp_detalle_orden(:d1,:d2,:d3,:d4)");
			$stmt2 =$this->db->prepare($sql2);
			
		
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':p2',$P['idorden_st'], PDO::PARAM_INT);
                $stmt->bindValue(':p3',$P['idcliente'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['id_usuario'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['idtipo'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['idmarca'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['desc_equipo'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['desc_falla'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['accesorios'], PDO::PARAM_STR);
                $stmt->bindValue(':p10',$P['fecha_'], PDO::PARAM_STR);
                $stmt->bindValue(':p11',$P['atendido'], PDO::PARAM_STR);
                $stmt->bindValue(':p12',$P['total_servicio'], PDO::PARAM_STR);
				$stmt->bindValue(':p13',0, PDO::PARAM_STR);
                $stmt->execute();
				
				
				
				$stmt4->bindValue(':idd',$P['idorden_st'], PDO::PARAM_INT);
                $stmt4->execute();
				
				foreach ($P['codigo'] as $key => $value)
				{
					$stmt2->bindValue(':d1',$P['idorden_st'], PDO::PARAM_INT);
					$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
					$stmt2->bindValue(':d3',$P['precio_real'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d4',$P['cant_s'][$key], PDO::PARAM_STR);
					$stmt2->execute();
				}
			    
				
                $this->db->commit();
				$resp = array('rep'=>'1','msg'=>'EDITADO CORRECTAMENTE');
				return $resp;
			 }
			
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"3",'msg'=>'no se pudo realizar la accion de insertar : '.$e->getMessage());
			}
		  
		}
	}
	
	function num_orden(){
		$stmt =$this->db->prepare("SELECT count(idorden_st) as total FROM orden_st ");
		$stmt->execute();
		return $stmt->fetchObject();
	}
	
	function datos_s($id){
		$stmt =$this->db->prepare("
		SELECT o.* , c.nombres , u.nombres as usuario, c.idcliente as idcliente, c.telefono, c.direccion
		FROM orden_st as o 
		INNER JOIN cliente AS c on (o.idcliente = c.idcliente)
		INNER JOIN usuario as u on (o.idusuario = u.idusuario)
		WHERE o.idorden_st = :id");
		$stmt->bindValue(':id', $id , PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchObject();
	}
	
	function datos_d($id){
		$stmt =$this->db->prepare("SELECT d.idservicio, s.descripcion, d.precio_real, d.idorden_st, d.cant FROM detalle_orden as d INNER JOIN servicio as s on (d.idservicio = s.idservicio) WHERE d.idorden_st = :id	");
		$stmt->bindValue(':id', $id , PDO::PARAM_STR);
		$stmt->execute();
		$res=$stmt->fetchAll();
		return $res;
	}	
	
	function marca($id){
		$stmt =$this->db->prepare("SELECT descripcion FROM marca where idmarca = :id ");
		$stmt->bindValue(':id', $id , PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchObject();
	}
	
	function tipo($id){
		$stmt =$this->db->prepare("SELECT descripcion FROM tipo where idtipo = :id ");
		$stmt->bindValue(':id', $id , PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchObject();
	}
	

    function deleteorden($id){  
	   $stmt=$this->db->prepare("update orden_st set estado=0 where idorden_st =:id");
	   $stmt->bindValue(':id', $id , PDO::PARAM_STR);
       $stmt->execute();
	}
	
	function cambia_Estado($id){// cambia estado para a 2 para no volver a mostrar  
	   $stmt=$this->db->prepare("update orden_st set atendido=2 where idorden_st =:id");
	   $stmt->bindValue(':id', $id , PDO::PARAM_STR);
       $stmt->execute();
	}
	
	function elimina_item_venta($id){  
	   $stmt=$this->db->prepare("update orden_st set atendido=1 where idorden_st =:id");
	   $stmt->bindValue(':id', $id , PDO::PARAM_STR);
       $stmt->execute();
	   return array('rep'=>'1','msg'=>'ELIMINADO CORRECTAMENTE');
	}
	

}
?>