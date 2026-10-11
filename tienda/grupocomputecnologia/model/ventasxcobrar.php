<?php
include_once("Main.php");
class ventasxcobrar extends Main
{
	function regventa($P)
    {
		if($P['oper']==1)
		{
			
			$Caja = $this->idMax();
			$idCaja = $Caja->max;
			
			$sql =$this->Query("sp_ventaxcobrar(1,0,:p3,:p4,:p5,:p6,:p7,:p8,:p9)");
			$stmt =$this->db->prepare($sql);
			
			$sql2 =$this->Query("sp_detalle_venta(:d1,:d2,:d3,:d4,:d5,:d6,:d7,:d8)");
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
				
					if($value!=0 && $P['codigo_orden'][$key]==0){//cuando es solo para productos
						$descripcion="";
						$producto = 'VENTA DE '.$P['canti'][$key].' '.$P['producto'][$key];
					}elseif($value==0 && $P['codigo_orden'][$key]!=0){//cuando es solo para servicios
						$descripcion=$P['producto'][$key];
						$producto = $P['canti'][$key].' '.$P['producto'][$key];
					}
					
					$stmt2->bindValue(':d1',$id_venta, PDO::PARAM_INT);
					$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
					$stmt2->bindValue(':d3',$P['precios'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d4',$P['canti'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d5',$P['sub'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d6',$P['codigo_orden'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d7',$descripcion, PDO::PARAM_STR);
					$stmt2->bindValue(':d8',$P['glosa'][$key], PDO::PARAM_STR);
					$stmt2->execute();
					

				}
			    
				
                $this->db->commit();
				$resp = array('rep'=>'1','msg'=>'ok ');
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
			
			 $edit_inventario = $this->edit_inventario($P['idventa']);
			IF($edit_inventario[0]){
			
			$Caja = $this->idMax();
			$idCaja = $Caja->max;
			
			$sql_ =$this->Query("sp_elimina_dv1(:idd)");
			$stmt8 =$this->db->prepare($sql_);
			
			$sql =$this->Query("sp_ventaxcobrar(2,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9)");
			$stmt =$this->db->prepare($sql);
			
			$sql2 =$this->Query("sp_detalle_venta(:d1,:d2,:d3,:d4,:d5,:d6,:d7,:d8)");
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
				
					if($value!=0 && $P['codigo_orden'][$key]==0){//cuando es solo para productos
						$descripcion="";
						$producto = 'VENTA DE '.$P['canti'][$key].' '.$P['producto'][$key];
					}elseif($value==0 && $P['codigo_orden'][$key]!=0){//cuando es solo para servicios
						$descripcion=$P['producto'][$key];
						$producto = $P['canti'][$key].' '.$P['producto'][$key];
					}
					
					$stmt2->bindValue(':d1',$P['idventa'], PDO::PARAM_INT);
					$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
					$stmt2->bindValue(':d3',$P['precios'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d4',$P['canti'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d5',$P['sub'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d6',$P['codigo_orden'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d7',$descripcion, PDO::PARAM_INT);
					$stmt2->bindValue(':d8',$P['glosa'][$key], PDO::PARAM_INT);
					$stmt2->execute();
				}
			    
				
                $this->db->commit();
				$resp = array('rep'=>'1','msg'=>'ok '.$edit_inventario[1]);
				return $resp;
			 }
			
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"3",'msg'=>'no se pudo realizar la accion de editar : '.$e->getMessage());
			}
		  }else{ return array('rep'=>'3','msg'=>'no se pudo actualizar el inventario : '.$edit_inventario[1]);
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
	
	function edit_inventario($idventa)
    {
		
       $stmt=$this->db->prepare("SELECT idproducto, cantidad, subtotal FROM detalle_venta where idventa=$idventa");
       $stmt2=$this->db->prepare("SELECT idproducto,stock FROM inventario WHERE idproducto=:id ");
       $stmt3 =$this->db->prepare("update inventario set stock=:b2 where idproducto=:b1");
	   try
		{
		  $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  $this->db->beginTransaction();
	      $stmt->execute();
	      $rows=$stmt->fetchAll();
		  $totalcompra = 0;
	       foreach($rows as $key=>$val)
	       {
	          $id_producto=$val[0];
	          $cant=$val[1];
			  $subtotal = $val[2];

				$stmt2->bindValue(':id',$id_producto, PDO::PARAM_INT);
				$stmt2->execute();
				$prod=$stmt2->fetchAll();
				$id_prod=$prod[0][0];
				$stock=$prod[0][1];
				
				$stock=$stock+$cant;
				$totalcompra = $totalcompra + $subtotal;
				
	            $stmt3->bindValue(':b1',$id_prod, PDO::PARAM_INT);
				$stmt3->bindValue(':b2',$stock, PDO::PARAM_STR);
	            $stmt3->execute();

           }

                $this->db->commit();
				$resp = array(true,'INVENTARIO EDITADO CORRECTAMENTE');
				return $resp;
        }
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array(false,$e->getMessage());
			}
      
	}
	
	function elimina_item($datos){
		//modificar stock producto en el inventario
		//eliminar el detalle de venta (idventa,producto)
		//descuento monto_c de la caja
	   
	   $idventa = $datos['idventa'];
	   $idproducto = $datos['idproducto'];
		
	   $stmt=$this->db->prepare("SELECT cantidad, subtotal FROM detalle_venta where idventa=$idventa and idproducto = $idproducto");
       $stmt2=$this->db->prepare("SELECT stock FROM inventario WHERE idproducto=:id_prod ");
       $stmt3 =$this->db->prepare("update inventario set stock=:b1 where idproducto=:b2");
	   $stmt7 =$this->db->prepare("DELETE FROM detalle_venta WHERE idventa=$idventa and idproducto = $idproducto");
	   
	   try
		{
		  $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  $this->db->beginTransaction();
	      
		  $stmt->execute();
	      $rows=$stmt->fetchObject();
		  $cantidad = $rows->cantidad;
		  $subtotal = $rows->subtotal;
		  
		  $stmt2->bindValue(':id_prod',$idproducto, PDO::PARAM_INT);
		  $stmt2->execute();
		  $stock_inventario=$stmt2->fetchObject();
		  $stock_inv = $stock_inventario->stock;
		  $stock=$stock_inv+$cantidad;
		  
		  $stmt3->bindValue(':b1',$stock, PDO::PARAM_INT);
		  $stmt3->bindValue(':b2',$idproducto, PDO::PARAM_STR);
	      $stmt3->execute();
		  
	
		        
          $stmt7->execute();

            $this->db->commit();
			$resp = array('rep'=>'1','msg'=>'ITEM DE VENTA ELIMINADO CORRECATMENTE STOCK ');
			return $resp;
        }
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				$resp = array('rep'=>'0','msg'=>'ERROR AL ELIMINAR ITEM DE VENTA: '.$e->getMessage());
				return $resp;
			}
		
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
	SELECT p.idproducto, p.descripcion as producto, d.precio, d.cantidad, d.subtotal, d.idorden_st, d.glosa
	FROM detalle_venta as d, producto as p
	WHERE p.idproducto=d.idproducto  and d.idproducto!=0 and d.idorden_st=0 and d.idventa = :id

	UNION 

	SELECT d.idproducto,d.descripcion as producto, d.precio, d.cantidad, d.subtotal, d.idorden_st, d.glosa
	FROM detalle_venta as d
	WHERE d.idproducto=0 and d.idorden_st!=0 and d.idventa = :id
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
	
	function lista_series($id){
	$stmt =$this->db->prepare("SELECT glosa FROM `detalle_venta` WHERE glosa != 'SERIE' and glosa != 'Soporte' and idventa =  :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
    return $res;
	}
	
	function total_amortizacion($id){
	$stmt= $this->db->prepare(" SELECT sum(mc.monto) AS pago
							    FROM venta v join movimiento_caja mc on (mc.idventa = v.idventa)
								WHERE v.estado = 2 and mc.estado = 1 and v.idventa =:id");
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
	
	

	
	function _printf1($id){
	$stmt =$this->db->prepare("
	select
	c.razon_social,
	c.ruc,
	c.direccion,
	c.telefono,
	v.idventa as IdVenta,
	v.fecha as Fecha,
	dv.cant_kg,
	dv.cant_q,
	dv.precio,
	v.total_pago,
	v.total_q,
	v.tipo_comprobante,
	v.nro_comprobante,
	u.nombres as Usuario

	from venta as v,cliente as c, usuario as u, detalle_venta as dv

	where v.cliente_idcliente = c.idcliente and u.idusuario = v.usuario_idusuario and v.idventa = dv.venta and v.idventa = :id
	");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
    return $res;	
	}
	
	
    function deleteventa($id)
    {
	   $stmt=$this->db->prepare("SELECT count(*) cantidad FROM movimiento_caja WHERE idventa = :idx");
	   $stmt->bindValue(':idx', $id , PDO::PARAM_STR);
       $stmt->execute();
	   $cantidad=$stmt->fetchObject();
	   if ($cantidad->cantidad == 0){
			$edit_inventario = $this->edit_inventario($id);
		   IF($edit_inventario[0]){
		   $stmt2=$this->db->prepare("update venta set estado=0 where idventa =:id");
		   $stmt2->bindValue(':id', $id , PDO::PARAM_STR);
		   $stmt2->execute();
		   }
		   $msg = array('rep'=>'1','msg'=>'ELIMINADO');
	   }else{
	   $msg = array('rep'=>'0','msg'=>'NO SE PUEDE ELIMINAR PORQUE TIENE PAGOS REGISTRADOS');
	   }
	   
	   
	}
	

}
?>