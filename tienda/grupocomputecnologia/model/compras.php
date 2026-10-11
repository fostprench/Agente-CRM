<?php
include_once("Main.php");
class compras extends Main
{
	function regcompra($P)
    {
		if($P['oper']==1)
		{

			$sql =$this->Query("sp_compra(1,0,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12)");
			$stmt =$this->db->prepare($sql);
			
			$sql2 =$this->Query("sp_detalle_compra(:d1,:d2,:d3,:d4,:d5,:d6,:d7,:d8,:d9)");
			$stmt2 =$this->db->prepare($sql2);
			
			try
			{
				if($P['tipocompra']==2){ $monto_soles = $P['totalcompra_igv']*$P['tipocambio'];}else{ $monto_soles = $P['totalcompra_igv'];}
				if(isset($P['_descuento']) && $P['_descuento']== "on"){ $descuento = $P['descuento']; }else{ $descuento = 0;}
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':p3',$P['id_usuario'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['idproveedor'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['nro_comprobante'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['fecha_'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['totalcompra_igv'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['tipocambio'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['tipocompra'], PDO::PARAM_STR);
                $stmt->bindValue(':p10',$descuento, PDO::PARAM_STR);
                $stmt->bindValue(':p11',$monto_soles , PDO::PARAM_STR);
                $stmt->bindValue(':p12',$P['observacion'] , PDO::PARAM_STR);
                $stmt->execute();
				
				
			    $id_compra = $this->max_id("compra"); 
				
		      foreach ($P['codigo'] as $key => $value)
				{
					$stmt2->bindValue(':d1',$id_compra, PDO::PARAM_INT);
					$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
					$stmt2->bindValue(':d3',$P['precios'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d4',$P['canti'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d5',$P['sub'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d6',$P['precio_c'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d7',$P['precio_v'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d8',$P['fecha_'], PDO::PARAM_INT);
					$stmt2->bindValue(':d9',$P['glosa'][$key], PDO::PARAM_INT);
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
		
		    $edit_inventario = $this->edit_inventario($P['idcompra']);
			IF($edit_inventario[0]){
			
			$sql_ =$this->Query("sp_elimina_dc1(:idd)");
	        $stmt4 =$this->db->prepare($sql_);
			
			$sql =$this->Query("sp_compra(2,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12)");
			$stmt =$this->db->prepare($sql);
			
			$sql2 =$this->Query("sp_detalle_compra(:d1,:d2,:d3,:d4,:d5,:d6,:d7,:d8,:d9)");
			$stmt2 =$this->db->prepare($sql2);
			
	
				
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				
				$stmt4->bindValue(':idd',$P['idcompra'], PDO::PARAM_INT);
                $stmt4->execute();
				
				if($P['tipocompra']==2){ $monto_soles = $P['totalcompra_igv']*$P['tipocambio'];}else{ $monto_soles = $P['totalcompra_igv'];}
				if(isset($P['_descuento']) && $P['_descuento']== "on"){ $descuento = $P['descuento']; }else{ $descuento = 0;}
				
                $stmt->bindValue(':p2',$P['idcompra'], PDO::PARAM_INT);
                $stmt->bindValue(':p3',$P['id_usuario'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['idproveedor'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['nro_comprobante'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['fecha_'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['totalcompra_igv'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['tipocambio'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['tipocompra'], PDO::PARAM_STR);
				$stmt->bindValue(':p10',$descuento, PDO::PARAM_STR);
                $stmt->bindValue(':p11',$monto_soles , PDO::PARAM_STR);
                $stmt->bindValue(':p12',$P['observacion'] , PDO::PARAM_STR);
                $stmt->execute();
				
				// $data = "";
		      foreach ($P['codigo'] as $key => $value)
				{
					// $data .= $value.' - ';
					$stmt2->bindValue(':d1',$P['idcompra'], PDO::PARAM_INT);
					$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
					$stmt2->bindValue(':d3',$P['precios'][$key], PDO::PARAM_STR);
					$stmt2->bindValue(':d4',$P['canti'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d5',$P['sub'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d6',$P['precio_c'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d7',$P['precio_v'][$key], PDO::PARAM_INT);
					$stmt2->bindValue(':d8',$P['fecha_'], PDO::PARAM_INT);
					$stmt2->bindValue(':d9',$P['glosa'][$key], PDO::PARAM_INT);
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
		  }else{ return array('rep'=>'3','msg'=>'no se pudo actualizar el inventario : '.$edit_inventario[1]);
			}
		}
	}
	
	function edit_inventario($idcompra)
    {
		$stmt=$this->db->prepare("SELECT idproducto, cantidad FROM detalle_compra where idcompra=$idcompra");
		$stmt->execute();
	    $rows=$stmt->fetchAll();
		
		foreach($rows as $key=>$val)
	       {
	          $id_producto=$val[0];
	          $cant=$val[1];
			  
			  $stmt2=$this->db->prepare("SELECT idproducto,stock FROM inventario WHERE idproducto = $id_producto");
			  $stmt2->execute();
			  $prod=$stmt2->fetchAll();
			  $id_prod=$prod[0][0];
			  $stock=$prod[0][1];
			
			  $stock=$stock-$cant;
			  
			  $stmt3 =$this->db->prepare("update inventario set stock=$stock where idproducto=$id_prod");
			  $stmt3->execute();

           }
		$resp = array(true,'ok');
		return $resp;

}

	function elimina_item($datos){
		//modificar stock producto en el inventario
		//eliminar el detalle de venta (idcompra,producto)
	   
	   $idcompra = $datos['idcompra'];
	   $idproducto = $datos['idproducto'];
		
	   $stmt=$this->db->prepare("SELECT cantidad FROM detalle_compra where idcompra=$idcompra and idproducto = $idproducto");
       $stmt2=$this->db->prepare("SELECT stock FROM inventario WHERE idproducto=:id_prod ");
       $stmt3 =$this->db->prepare("update inventario set stock=:b1 where idproducto=:b2");
	   $stmt7 =$this->db->prepare("DELETE FROM detalle_compra WHERE idcompra=$idcompra and idproducto = $idproducto");
	   
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
		  $stock = $stock_inventario->stock;
		  $stock=$stock-$cantidad;
		  
		  $stmt3->bindValue(':b1',$stock, PDO::PARAM_INT);
		  $stmt3->bindValue(':b2',$idproducto, PDO::PARAM_STR);
	      $stmt3->execute();
		        
          $stmt7->execute();

            $this->db->commit();
			$resp = array('rep'=>'1','msg'=>'ITEM DE COMPRA ELIMINADO CORRECATMENTE');
			return $resp;
        }
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				$resp = array('rep'=>'0','msg'=>'ERROR AL ELIMINAR ITEM DE COMPRA: '.$e->getMessage());
				return $resp;
			}
		
	}
	
	
	
	function datos_c($id){
	$stmt =$this->db->prepare("
	SELECT c.idcompra, c.idusuario, c.idproveedor, u.nombres as usuario, p.descripcion as proveedor,p.direccion as direccion,c.nro_factura,c.fecha, c.totalD as total_d, c.tipocambio, c.tipocompra, c.descuento, c.monto_soles, c.observacion
    FROM compra as c, usuario as u, proveedor as p
    WHERE c.idusuario=u.idusuario and c.idproveedor = p.idproveedor and c.idcompra =  :id
	");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	
	function devolver_costo_producto($id){
	$stmt =$this->db->prepare("SELECT  precio_c,precio_v FROM inventario WHERE idproducto =  :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetchObject();
	return array('rep'=>$data->precio_c,'venta'=>$data->precio_v);
	}
	
	function validar_comprobante_compra($id){
	$stmt =$this->db->prepare("SELECT  nro_factura FROM compra WHERE nro_factura =  :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
	return array('rep'=>$stmt->rowCount());
	}
	
	function datos_d($id){
	$stmt =$this->db->prepare("
	SELECT p.idproducto, p.descripcion as producto, d.precio, d.cantidad, d.subtotal,i.precio_c,i.precio_v, d.glosa
	FROM detalle_compra as d, producto as p, inventario as i
	WHERE p.idproducto=d.idproducto and p.idproducto=i.idproducto and d.idcompra = :id
	");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
    return $res;
	}	
	
	

    function deletecompra($id)
    {  
	   $edit_inventario = $this->edit_inventario($id);
	   IF($edit_inventario[0]){
	   $stmt=$this->db->prepare("update compra set estado=0 where idcompra =:id");
	   $stmt->bindValue(':id', $id , PDO::PARAM_STR);
       $stmt->execute();
	   }
	}
	

}
?>