<?php
include_once("Main.php");
class venta extends Main
{
	function regventa($P)
    {
		if($P['oper']==1)
		{
			
			$Caja = $this->idMax();
			$idCaja = $Caja->max;
			
			$sql =$this->Query("sp_venta(1,0,:p3,:p4,:p5,:p6,:p7,:p8,:p9)");
			$stmt =$this->db->prepare($sql);
			
			$sql2 =$this->Query("sp_detalle_venta(:d1,:d2,:d3,:d4,:d5,:d6,:d7,:d8)");
			$stmt2 =$this->db->prepare($sql2);
			
			$stmt3 = $this->db->prepare("SELECT monto_c FROM caja WHERE idcaja = :idd");
			$stmt4 =$this->db->prepare("UPDATE caja SET monto_c = :p1 WHERE idcaja = :p9");
			
			
			$sql5 =$this->Query("sp_movimiento_ventas(:m1,:m2,1,:m4,:m5,:m6,:m7,:m8,:m9)");											 
			$stmt5 =$this->db->prepare($sql5);
			
			try
			{
				if(empty(ltrim(rtrim($P['idcliente'])))){ $cliente = 72; }else{$cliente = $P['idcliente'];}
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':p3',$cliente, PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['tipo_c'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['id_usuario'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['nro_comprobante'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['fecha_'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['totalcompra'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['observacion'], PDO::PARAM_STR);
                $stmt->execute();
				
				$stmt3->bindValue(':idd',$idCaja, PDO::PARAM_STR);
				$stmt3->execute();
				$dato2 = $stmt3->fetchObject();
				$Saldo = $dato2->monto_c;
				$Saldo_antescompra = $Saldo; 
				$Saldo = $Saldo + $P['totalcompra'];
				
				$stmt4->bindValue(':p1',$Saldo, PDO::PARAM_STR);
				$stmt4->bindValue(':p9',$idCaja, PDO::PARAM_STR);
                $stmt4->execute();
				
			  $id_venta = $this->max_id("venta"); 
				
		      foreach ($P['codigo'] as $key => $value)
				{
					if($value!=0 && $P['codigo_orden'][$key]==0){//cuando es solo para productos
						$descripcion="";
						$producto = 'VENTA DE '.$P['canti'][$key].' '.$P['producto'][$key];
						$tipocontrol = 3;
					}elseif($value==0 && $P['codigo_orden'][$key]!=0){//cuando es solo para servicios
						$descripcion=$P['producto'][$key];
						$producto = $P['canti'][$key].' '.$P['producto'][$key];
						$tipocontrol = 10;
					}//elseif($value==0 && $P['codigo_orden'][$key]==0){//cuando es solo para otros servicios
						// $descripcion = $P['producto'][$key];
						// $producto = $P['producto'][$key];
					// }
					
					$stmt2->bindValue(':d1',$id_venta, PDO::PARAM_INT);
					$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
					$stmt2->bindValue(':d3',$P['precios'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d4',$P['canti'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d5',$P['sub'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d6',$P['codigo_orden'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d7',$descripcion, PDO::PARAM_INT);
					$stmt2->bindValue(':d8',$P['glosa'][$key], PDO::PARAM_INT);
					$stmt2->execute();
					
					
					
					$stmt5->bindValue(':m1',$P['id_usuario'], PDO::PARAM_INT);
					$stmt5->bindValue(':m2',$idCaja, PDO::PARAM_INT);
					//$stmt5->bindValue(':m3',$Idconcepto, PDO::PARAM_INT);
					$stmt5->bindValue(':m4',$producto, PDO::PARAM_STR);
					$stmt5->bindValue(':m5',$P['sub'][$key], PDO::PARAM_STR);
					$stmt5->bindValue(':m6',$P['fecha_'], PDO::PARAM_STR);
					$stmt5->bindValue(':m7',$id_venta, PDO::PARAM_STR);
					$stmt5->bindValue(':m8',$Saldo_antescompra, PDO::PARAM_INT);
					$stmt5->bindValue(':m9',$tipocontrol, PDO::PARAM_INT);
					$stmt5->execute();
				}
				 
				
                $this->db->commit();
				$resp = array('rep'=>'1','msg'=>'Venta Registrada Correctamente');
				return $resp;
			}
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"3",'msg'=> "data; ".$P['oper'].' no se pudo realizar la accion de insertar : '.$e->getMessage());
			}
		}
		else
		{  
			
			$edit_inventario = $this->edit_inventario($P['idventa']);
			IF($edit_inventario[0]){
			
			$Caja = $this->idMax();
			$idCaja = $Caja ->max;
			
			$sql_ =$this->Query("sp_elimina_dv1(:idd)");
			$stmt8 =$this->db->prepare($sql_);
			
			$sql =$this->Query("sp_venta(2,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9)");
			$stmt =$this->db->prepare($sql);
			
			$sql2 =$this->Query("sp_detalle_venta(:d1,:d2,:d3,:d4,:d5,:d6,:d7,:d8)");
			$stmt2 =$this->db->prepare($sql2);
			
			$stmt3 = $this->db->prepare("SELECT monto_c FROM caja WHERE idcaja = :idc");
			$stmt4 =$this->db->prepare("UPDATE caja SET monto_c = :p1 WHERE idcaja = :p9");
			
			/*sp_movimiento_ventas  (didusuario int(11),didcaja int(11),didconcepto int(11),ddescripcion varchar(300),dmonto double(10,2),
                                                             dfecha date, didventa int(11) )*/
															 
			$sql5 =$this->Query("sp_movimiento_ventas(:m1,:m2,1,:m4,:m5,:m6,:m7,:m8,:m9)");											 
			$stmt5 =$this->db->prepare($sql5);
				
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
				$stmt->bindValue(':p8',$P['totalcompra'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['observacion'], PDO::PARAM_STR);
                $stmt->execute();
				
				$stmt3->bindValue(':idc',$idCaja, PDO::PARAM_STR);
				$stmt3->execute();				
				$dato2 = $stmt3->fetchObject();
				$Saldo = $dato2->monto_c;
				$Saldo_antescompra = $Saldo; 
				$Saldo = $Saldo + $P['totalcompra'];
				
				$stmt4->bindValue(':p1',$Saldo, PDO::PARAM_STR);
				$stmt4->bindValue(':p9',$idCaja, PDO::PARAM_STR);
                $stmt4->execute();
				
				
		      foreach ($P['codigo'] as $key => $value)
				{
				
					if($value!=0 && $P['codigo_orden'][$key]==0){//cuando es solo para productos
						$descripcion="";
						$producto = 'VENTA DE '.$P['canti'][$key].' '.$P['producto'][$key];
						$tipocontrol = 3;
					}elseif($value==0 && $P['codigo_orden'][$key]!=0){//cuando es solo para servicios
						$descripcion=$P['producto'][$key];
						$producto = $P['canti'][$key].' '.$P['producto'][$key];
						$tipocontrol = 10;
					}//elseif($value==0 && $P['codigo_orden'][$key]==0){//cuando es solo para otros servicios
						// $descripcion = $P['producto'][$key];
						// $producto = $P['producto'][$key];
					// }
					
					$stmt2->bindValue(':d1',$P['idventa'], PDO::PARAM_INT);
					$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
					$stmt2->bindValue(':d3',$P['precios'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d4',$P['canti'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d5',$P['sub'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d6',$P['codigo_orden'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d7',$descripcion, PDO::PARAM_INT);
					$stmt2->bindValue(':d8',$P['glosa'][$key], PDO::PARAM_INT);
					$stmt2->execute();
					
					
					$stmt5->bindValue(':m1',$P['id_usuario'], PDO::PARAM_INT);
					$stmt5->bindValue(':m2',$idCaja, PDO::PARAM_INT);
					//$stmt5->bindValue(':m3',$Idconcepto, PDO::PARAM_INT);
					$stmt5->bindValue(':m4',$producto, PDO::PARAM_STR);
					$stmt5->bindValue(':m5',$P['sub'][$key], PDO::PARAM_STR);
					$stmt5->bindValue(':m6',$P['fecha_'], PDO::PARAM_STR);
					$stmt5->bindValue(':m7',$P['idventa'], PDO::PARAM_STR);// VERIFICAR
					$stmt5->bindValue(':m8',$Saldo_antescompra, PDO::PARAM_INT);
					$stmt5->bindValue(':m9',$tipocontrol, PDO::PARAM_INT);
					$stmt5->execute();
					
				}
			    
				
                $this->db->commit();
				$resp = array('rep'=>'1','msg'=>'ok '.$edit_inventario[1]);
				return $resp;
			 }
			
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"3",'msg'=>'no se pudo realizar la accion de insertar : '.$e->getMessage());
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
	
	function validar_comprobante_venta($id){
	$stmt =$this->db->prepare("SELECT  nro_comprobante FROM venta WHERE nro_comprobante =  :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
	return array('rep'=>$stmt->rowCount());
	}
	
	function estado_caja($id){
	$stmt = $this->db->prepare("SELECT c.estado
								FROM caja as c, movimiento_caja as m
								WHERE c.idcaja = m.idcaja and m.idventa =  :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	function estado_venta($id){
	$stmt = $this->db->prepare("SELECT tipo_venta FROM venta WHERE estado = 1 and idventa =  :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	function edit_inventario($idventa)
    {
		
       $stmt=$this->db->prepare("SELECT idproducto, cantidad, subtotal FROM detalle_venta where idventa=$idventa");
       $stmt2=$this->db->prepare("SELECT idproducto,stock FROM inventario WHERE idproducto=:id ");
       $stmt3 =$this->db->prepare("update inventario set stock=:b2 where idproducto=:b1");
	   $stmt6 = $this->db->prepare("SELECT idcaja FROM movimiento_caja WHERE idventa = :idv");
       $stmt4 = $this->db->prepare("SELECT monto_c FROM caja WHERE idcaja = :idd");
	   $stmt5 =$this->db->prepare("UPDATE caja SET monto_c = :p1 WHERE idcaja = :p9");
	   $stmt7 =$this->db->prepare("DELETE FROM movimiento_caja WHERE idventa = :vv");
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
		   
				$stmt6->bindValue(':idv',$idventa, PDO::PARAM_STR);
                $stmt6->execute();
				$idCaja=$stmt6->fetchAll();
				$idCaja = $idCaja[0][0];
		   
		        $stmt4->bindValue(':idd',$idCaja, PDO::PARAM_STR);
				$stmt4->execute();
				$dato2 = $stmt4->fetchObject();
				$Saldo = $dato2->monto_c;
				$Saldo = $Saldo - $totalcompra;
				
				$stmt5->bindValue(':p1',$Saldo, PDO::PARAM_STR);
				$stmt5->bindValue(':p9',$idCaja, PDO::PARAM_STR);
                $stmt5->execute();
		        
				$stmt7->bindValue(':vv',$idventa, PDO::PARAM_STR);
                $stmt7->execute();
		   
		   
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
	   $stmt6 = $this->db->prepare("SELECT idcaja FROM movimiento_caja WHERE idventa = :idv");
       $stmt4 = $this->db->prepare("SELECT monto_c FROM caja WHERE idcaja = :idd");
	   $stmt5 =$this->db->prepare("UPDATE caja SET monto_c = :p1 WHERE idcaja = :p9");
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
		  
		  $stmt6->bindValue(':idv',$idventa, PDO::PARAM_STR);
          $stmt6->execute();
		  $idCaja=$stmt6->fetchObject();
		  $idCaja = $idCaja->idcaja;
		  
		  $stmt4->bindValue(':idd',$idCaja, PDO::PARAM_STR);
		  $stmt4->execute();
		  $dato2 = $stmt4->fetchObject();
		  $Saldo = $dato2->monto_c;
		  $Saldo = $Saldo - $subtotal;
		  
		  $stmt5->bindValue(':p1',$Saldo, PDO::PARAM_STR);
		  $stmt5->bindValue(':p9',$idCaja, PDO::PARAM_STR);
          $stmt5->execute();
		        
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
	SELECT v.idventa, c.idcliente, c.nombres as cliente,c.ruc,c.direccion, v.idcomprobante as tipo_c, v.nro_comprobante, v.fecha,v.total,u.idusuario,u.nombres as usuario,v.observacion, c.telefono
	FROM venta as v, cliente as c, usuario as u
	WHERE c.idcliente = v.idcliente and u.idusuario = v.idusuario and v.idventa =  :id
	");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	function lista_series($id){
	$stmt =$this->db->prepare("SELECT glosa FROM `detalle_venta` WHERE glosa != 'SERIE' and glosa != 'Soporte' and idventa =  :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
    return $res;
	}

	function listaBancos(){
		$stmt =$this->db->prepare("select * from bancos where estado = 1");
   	 	$stmt->execute();
    	return $stmt->fetchAll();
	}


	// $stmt =$this->db->prepare("select * from proforma_general");
 //    $stmt->execute();
 //    return $stmt->fetchObject();
 
	
	
	function datos_d($id){//para productos UNION //para orden de servicio tecnico UNION //para cualquier servicio de mano de obra u otro servicio insertado a manera de escribir por el formulario
	$stmt =$this->db->prepare("
	SELECT p.idproducto, p.descripcion as producto, d.precio, d.cantidad, d.subtotal, d.idorden_st, d.glosa
	FROM detalle_venta as d, producto as p
	WHERE p.idproducto=d.idproducto  and d.idproducto!=0 and d.idorden_st=0 and d.idventa = :id

	UNION 

	SELECT d.idproducto,d.descripcion, d.precio, d.cantidad, d.subtotal, d.idorden_st, d.glosa
	FROM detalle_venta as d
	WHERE d.idproducto=0 and d.idorden_st!=0 and d.idventa = :id

	");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
    return $res;
	}
	


	function datos_venta($id){
	$stmt= $this->db->prepare("SELECT c.nombres, v.idcomprobante, v.nro_comprobante, v.fecha, v.total
							   FROM venta as v,cliente as c
							   WHERE c.idcliente = v.idcliente and v.idventa = :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
	return $res;
	}
	
	

	
	
	function tipo_venta($id){
		$stmt=$this->db->prepare("select tipo_venta from venta where idventa =:id");
		$stmt->bindValue(':id', $id , PDO::PARAM_STR);
		$stmt->execute();
		$tipo = $stmt->fetchObject();
		$tipo = $tipo->tipo_venta;
		return $tipo;
	}
	
    function deleteventa($id)
    {
       $tipo = $this->tipo_venta($id);
	   IF( $tipo == 1){
			
			$verifica_caja =  $this->estado_caja($id);
			if($verifica_caja->estado==0){
				$resp = array('rep'=>'0','msg'=>'No se puede eliminar por que la caja ya fue Cerrada');
				return $resp;
			}else{
				$edit_inventario = $this->edit_inventario($id);
				IF($edit_inventario[0]){
					$stmt=$this->db->prepare("update venta set estado=0 where idventa =:id");
					$stmt->bindValue(':id', $id , PDO::PARAM_STR);
					$stmt->execute();
					$resp = array('rep'=>'1','msg'=>'ELIMINADO');
					return $resp;
				}
			}
		   
	   }else{
			$resp = array('rep'=>'0','msg'=>'NO SE PUEDE ELIMINAR VENTA REGISTRADA POR COBRAR');
			return $resp;
	   }
	}
	

}
?>