<?php
include_once("Main.php");
class Ventasxpedir extends Main
{
	function regventa($P)
    {
		if($P['oper']==1)
		{
			
			$Caja = $this->idMax();
			$idCaja = $Caja->max;
			
			$sql =$this->Query("sp_ventaxpedir(1,0,:p3,:p4,:p5,:p6,:p7,:p8,:p9)");
			$stmt =$this->db->prepare($sql);
			
			$sql2 =$this->Query("sp_detalle_venta_xpedir(:d1,:d2,:d3,:d4,:d5,0,0,:d6)"); 
			$stmt2 =$this->db->prepare($sql2);

			
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':p3',$P['idcliente'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['tipo_c'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['id_usuario'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['nro_comprobante'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['fecha_'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['totalcompra'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['observacion'], PDO::PARAM_STR);
                $stmt->execute();
				
				
			  $id_venta = $this->max_id("venta"); 
				
		      foreach ($P['codigo'] as $key => $value)
				{
					$stmt2->bindValue(':d1',$id_venta, PDO::PARAM_INT);
					$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
					$stmt2->bindValue(':d3',$P['precios'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d4',$P['canti'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d5',$P['sub'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d6',$P['glosa'][$key], PDO::PARAM_STR);
					$stmt2->execute();
				}
			    
				
                $this->db->commit();
				$resp = array('rep'=>'1','msg'=>'ok '.$id_compra);
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
			
			
			
			$sql_ =$this->Query("sp_elimina_dv1(:idd)");
			$stmt8 =$this->db->prepare($sql_);
			
			$sql =$this->Query("sp_ventaxpedir(2,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9)");
			$stmt =$this->db->prepare($sql);
			
			$sql2 =$this->Query("sp_detalle_venta_xpedir(:d1,:d2,:d3,:d4,:d5,0,0,:d6)"); 
			$stmt2 =$this->db->prepare($sql2);

			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				
				$stmt8->bindValue(':idd',$P['idventa'], PDO::PARAM_INT);
                $stmt8->execute();
				
                $stmt->bindValue(':p2',$P['idventa'], PDO::PARAM_INT);
                $stmt->bindValue(':p3',$P['idcliente'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['tipo_c'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['id_usuario'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['nro_comprobante'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['fecha_'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['totalcompra'], PDO::PARAM_STR);
				$stmt->bindValue(':p9',$P['observacion'], PDO::PARAM_STR);
                $stmt->execute();
				
				
				
		      foreach ($P['codigo'] as $key => $value)
				{
					$stmt2->bindValue(':d1',$P['idventa'], PDO::PARAM_INT);
					$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
					$stmt2->bindValue(':d3',$P['precios'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d4',$P['canti'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d5',$P['sub'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d6',$P['glosa'][$key], PDO::PARAM_STR);
					$stmt2->execute();
				}
			    
				
                $this->db->commit();
				$resp = array('rep'=>'1','msg'=>'ok '.$P['totalcompra']);
				return $resp;
			 }
			
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"3",'msg'=>'no se pudo realizar la accion de insertar : '.$e->getMessage());
			}
		 
			
			
		}
	}
	
	function idMax(){
	 $stmt = $this->db->prepare("SELECT max(idcaja) as max FROM caja where estado = 1");
     $stmt->execute();
     $max=$stmt->fetchObject();
     return $max;
	}
	
	
	function estado_caja($id){
	$stmt = $this->db->prepare("SELECT c.estado
								FROM caja as c, movimiento_caja as m
								WHERE c.idcaja = m.idcaja and m.idventa =  :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	
	

	
	function datos_v($id){
	$stmt =$this->db->prepare("
	SELECT v.idventa, c.idcliente, c.nombres as cliente,c.ruc,c.direccion, v.idcomprobante as tipo_c, v.nro_comprobante, v.fecha,v.total,u.idusuario,u.nombres as usuario, v.observacion, c.telefono
	FROM venta as v, cliente as c, usuario as u
	WHERE c.idcliente = v.idcliente and u.idusuario = v.idusuario and v.idventa =  :id
	");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	function datos_d($id){
	$stmt =$this->db->prepare("
	SELECT p.idproducto, p.descripcion as producto, d.precio, d.cantidad, d.subtotal, d.glosa
	FROM detalle_venta as d, producto as p
	WHERE p.idproducto=d.idproducto and d.idventa = :id
	");

	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
    return $res;
	}
	
	function detalle_amortizaciones($id){
	$stmt =$this->db->prepare("SELECT m.idmovimiento,m.fecha,u.usuario,m.monto
							  FROM movimiento_caja as m inner join usuario as u on(u.idusuario = m.idusuario) WHERE m.estado=1 and m.idventa = :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
    return $res;
	}
	

	function datos_venta($id){
	$stmt= $this->db->prepare("SELECT c.nombres, v.idcomprobante, v.nro_comprobante, v.fecha, v.total
							   FROM venta as v,cliente as c
							   WHERE c.idcliente = v.idcliente and v.idventa = :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_INT);
    $stmt->execute();
    $res=$stmt->fetchAll();
	return $res;
	}
	
	function total_amortizacion($id){
	$stmt= $this->db->prepare(" SELECT sum(mc.monto) AS pago
							    FROM venta v join movimiento_caja mc on (mc.idventa = v.idventa)
								WHERE v.estado = 3 and mc.estado = 1 and v.idventa =:id");
	$stmt->bindValue(':id', $id , PDO::PARAM_INT);
    $stmt->execute();
    $res=$stmt->fetchObject();
	return $res->pago;
	}
	
	function datos_amortizaciones($id){
	$stmt= $this->db->prepare(" SELECT mc.idmovimiento as Id,mc.fecha,mc.monto AS Monto
							    FROM venta v join movimiento_caja mc on (mc.idventa = v.idventa)
								WHERE v.estado = 2 and mc.estado = 1 and v.idventa =:id");
	$stmt->bindValue(':id', $id , PDO::PARAM_INT);
    $stmt->execute();
    $res=$stmt->fetchAll();
	return $res;
	}
	
	function verificar_inv($idventa){
	
			$inventario = $this->datos_d($idventa);
			$existe = true;
			foreach($inventario as $key=>$val){
				$stmt=$this->db->prepare("select stock from inventario where idproducto = :id"); //seleccionar el stock por idproducto
				$stmt->bindValue(':id', $val[0] , PDO::PARAM_INT);
				$stmt->execute();
				$data=$stmt->fetchObject();
				$stock_inv = $data->stock;
				if($stock_inv<$val[3]){ $existe=false;}
			}
			return $existe;
	}
	
	
    function actualizar_inv($idproducto,$cant){
			$stmt=$this->db->prepare("select stock from inventario where idproducto = :id"); //seleccionar el stock por idproducto
			$stmt->bindValue(':id', $idproducto , PDO::PARAM_STR);
			$stmt->execute();
			$data=$stmt->fetchObject();
			$stock_inv = $data->stock;
			
			$stock_inv = $stock_inv - $cant; //restar stock con $cant
			
		   $stmt2=$this->db->prepare("update inventario set stock=$stock_inv where idproducto =:idp"); //editar stock con la resta sacada
		   $stmt2->bindValue(':idp', $idproducto , PDO::PARAM_STR);
		   $stmt2->execute();
	}
	
	function actualizar_estado($idventa){			
		   $stmt2=$this->db->prepare("update venta set estado=1 where idventa =:id");
		   $stmt2->bindValue(':id', $idventa , PDO::PARAM_STR);
		   $stmt2->execute();		   
	}

	
    function deleteventa($id)
    {
		   $stmt2=$this->db->prepare("update venta set estado=0 where idventa =:id");
		   $stmt2->bindValue(':id', $id , PDO::PARAM_STR);
		   $stmt2->execute();
		   $msg = array('rep'=>'1','msg'=>'ELIMINADO');  
	}
	

}
?>