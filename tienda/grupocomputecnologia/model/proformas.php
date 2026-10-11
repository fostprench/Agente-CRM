<?php
include_once("Main.php");
class proformas extends Main
{
	function regproforma($P)
    {
		if($P['oper']==1)
		{

			$sql =$this->Query("sp_proforma(1,0,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15,:p16,:p17,:p18)");
			$stmt =$this->db->prepare($sql);
			
			$sql2 =$this->Query("sp_detalle_proforma(:d1,:d2,:d3,:d4,:d5)");
			$stmt2 =$this->db->prepare($sql2);
			
			$sql3 =$this->Query("sp_detalle_otro(:e1,:e2,:e3,:e4,:e5,:e6,:e7)");
			$stmt3 =$this->db->prepare($sql3);
			
			$sql4 =$this->Query("sp_detalle_obsequios(:f1,:f2,:f3,:f4,:f5)");
			$stmt4 =$this->db->prepare($sql4);
			
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				
				if(isset($P['_descuento'])){ $descuento = $P['descuento_general']; }else{ $descuento = 0;}
				if(isset($P['mostrar_precios'])){ $mostrar_precios = 1; }else{ $mostrar_precios = 0;}
                $stmt->bindValue(':p3',$P['fecha_emision_'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['fecha_caducidad_'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['moneda'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['MODELO'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['ganancia'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['cantidad'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['precio_unitario'], PDO::PARAM_STR);
                $stmt->bindValue(':p10',$P['mantenimiento'], PDO::PARAM_STR);
                $stmt->bindValue(':p11',$P['precio_total'] , PDO::PARAM_STR);
                $stmt->bindValue(':p12',$P['total_otros'] , PDO::PARAM_STR);
                $stmt->bindValue(':p13',$P['total_obsequios'] , PDO::PARAM_STR);
                $stmt->bindValue(':p14',$P['total_general'] , PDO::PARAM_STR);
                $stmt->bindValue(':p15',$_SESSION['id_usuario'] , PDO::PARAM_STR);
                $stmt->bindValue(':p16',$P['idcliente'] , PDO::PARAM_STR);							
                $stmt->bindValue(':p17',$descuento , PDO::PARAM_STR);		
                $stmt->bindValue(':p18',$mostrar_precios , PDO::PARAM_INT);		
                $stmt->execute();
				
				 $id_proforma = $this->max_id("proformas"); 
				
		      	if (is_array($P['codigo'])) {	
			      	foreach ($P['codigo'] as $key => $value)
					{
						$stmt2->bindValue(':d1',$id_proforma, PDO::PARAM_INT);
						$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
						$stmt2->bindValue(':d3',$P['producto'][$key], PDO::PARAM_STR);
						$stmt2->bindValue(':d4',$P['canti'][$key], PDO::PARAM_INT);
						$stmt2->bindValue(':d5',$P['monto'][$key], PDO::PARAM_INT);
						$stmt2->execute();
					}
				}
				
				if (is_array($P['codigo_otros'])) {	
					foreach ($P['codigo_otros'] as $key => $value)
					{
						$stmt3->bindValue(':e1',$id_proforma, PDO::PARAM_INT);
						$stmt3->bindValue(':e2',$value, PDO::PARAM_INT);
						$stmt3->bindValue(':e3',$P['producto_otros'][$key], PDO::PARAM_STR);
						$stmt3->bindValue(':e4',$P['canti_otros'][$key], PDO::PARAM_INT);
						$stmt3->bindValue(':e5',$P['precios_otros'][$key], PDO::PARAM_INT);
						$stmt3->bindValue(':e6',$P['descuento'][$key], PDO::PARAM_INT);
						$stmt3->bindValue(':e7',$P['garantia'][$key], PDO::PARAM_INT);
						$stmt3->execute();
					}
				}
				
				if (is_array($P['codigo_obs'])) {	
					foreach ($P['codigo_obs'] as $key => $value)
					{
						$stmt4->bindValue(':f1',$id_proforma, PDO::PARAM_INT);
						$stmt4->bindValue(':f2',$value, PDO::PARAM_INT);
						$stmt4->bindValue(':f3',$P['producto_obs'][$key], PDO::PARAM_STR);
						$stmt4->bindValue(':f4',$P['canti_obs'][$key], PDO::PARAM_INT);
						$stmt4->bindValue(':f5',$P['precios_obs'][$key], PDO::PARAM_INT);
						$stmt4->execute();
					}
				}
			    
				
                $this->db->commit();
				$resp = array('rep'=>'1','msg'=>'GUARDADO CORRECTAMENTE');
				return $resp;
			}
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"3",'msg'=>'no se pudo realizar la accion de insertar : '.$e->getMessage());
			}
			
		}else{  
		
			$sql_ =$this->Query("sp_elimina_detallesproforma(:idd)");
	        $stmt5 =$this->db->prepare($sql_);
			
			$sql =$this->Query("sp_proforma(2,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15,:p16,:p17,:p18)");
			$stmt =$this->db->prepare($sql);

			if (is_array($P['codigo'])) {			
				$sql2 =$this->Query("sp_detalle_proforma(:d1,:d2,:d3,:d4,:d5)");
				$stmt2 =$this->db->prepare($sql2);
			}
			
			if (is_array($P['codigo_otros'])) {	
				$sql3 =$this->Query("sp_detalle_otro(:e1,:e2,:e3,:e4,:e5,:e6,:e7)");
				$stmt3 =$this->db->prepare($sql3);
			}
			
			if (is_array($P['codigo_obs'])) {	
				$sql4 =$this->Query("sp_detalle_obsequios(:f1,:f2,:f3,:f4,:f5)");
				$stmt4 =$this->db->prepare($sql4);
			}
			

				
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				
				
				$id_proformas = $P['idproformas'];
				
				$stmt5->bindValue(':idd',$id_proformas, PDO::PARAM_INT);
                $stmt5->execute();
				
				if(isset($P['_descuento'])){ $descuento = $P['descuento_general']; }else{ $descuento = 0;}
				if(isset($P['mostrar_precios'])){ $mostrar_precios = 1; }else{ $mostrar_precios = 0;}
				
                $stmt->bindValue(':p2',$id_proformas, PDO::PARAM_INT);
                $stmt->bindValue(':p3',$P['fecha_emision_'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['fecha_caducidad_'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['moneda'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['MODELO'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['ganancia'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['cantidad'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['precio_unitario'], PDO::PARAM_STR);
                $stmt->bindValue(':p10',$P['mantenimiento'], PDO::PARAM_STR);
                $stmt->bindValue(':p11',$P['precio_total'] , PDO::PARAM_STR);
                $stmt->bindValue(':p12',$P['total_otros'] , PDO::PARAM_STR);
                $stmt->bindValue(':p13',$P['total_obsequios'] , PDO::PARAM_STR);
                $stmt->bindValue(':p14',$P['total_general'] , PDO::PARAM_STR);
                $stmt->bindValue(':p15',$_SESSION['id_usuario'] , PDO::PARAM_STR);
                $stmt->bindValue(':p16',$P['idcliente'] , PDO::PARAM_STR);				
                $stmt->bindValue(':p17',$descuento , PDO::PARAM_STR);					
                $stmt->bindValue(':p18',$mostrar_precios , PDO::PARAM_INT);					
                $stmt->execute();
				

                if (is_array($P['codigo'])) {	
					foreach ($P['codigo'] as $key => $value)
					{
						$stmt2->bindValue(':d1',$id_proformas, PDO::PARAM_INT);
						$stmt2->bindValue(':d2',$value, PDO::PARAM_INT);
						$stmt2->bindValue(':d3',$P['producto'][$key], PDO::PARAM_STR);
						$stmt2->bindValue(':d4',$P['canti'][$key], PDO::PARAM_INT);
						$stmt2->bindValue(':d5',$P['monto'][$key], PDO::PARAM_INT);
						$stmt2->execute();
					}
				}
				
				if (is_array($P['codigo_otros'])) {	
					foreach ($P['codigo_otros'] as $key => $value)
					{
						$stmt3->bindValue(':e1',$id_proformas, PDO::PARAM_INT);
						$stmt3->bindValue(':e2',$value, PDO::PARAM_INT);
						$stmt3->bindValue(':e3',$P['producto_otros'][$key], PDO::PARAM_STR);
						$stmt3->bindValue(':e4',$P['canti_otros'][$key], PDO::PARAM_INT);
						$stmt3->bindValue(':e5',$P['precios_otros'][$key], PDO::PARAM_INT);
						$stmt3->bindValue(':e6',$P['descuento'][$key], PDO::PARAM_INT);
						$stmt3->bindValue(':e7',$P['garantia'][$key], PDO::PARAM_INT);
						$stmt3->execute();
					}
				}
				
				if (is_array($P['codigo_obs'])) {	
					foreach ($P['codigo_obs'] as $key => $value)
					{
						$stmt4->bindValue(':f1',$id_proformas, PDO::PARAM_INT);
						$stmt4->bindValue(':f2',$value, PDO::PARAM_INT);
						$stmt4->bindValue(':f3',$P['producto_obs'][$key], PDO::PARAM_STR);
						$stmt4->bindValue(':f4',$P['canti_obs'][$key], PDO::PARAM_INT);
						$stmt4->bindValue(':f5',$P['precios_obs'][$key], PDO::PARAM_INT);
						$stmt4->execute();
					}
				}
				
				$this->db->commit();
				$resp = array('rep'=>'1','msg'=>'Editado Correctamente');
				return $resp;
				
				
				
			 }
			
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"3",'msg'=>'no se pudo realizar la accion de editar : '.$e->getMessage());
			}
		  
		}
	}
	
	
	public function newproforma_general($P)
    {
	   if($P['oper']==2)
		{    
			$sql =$this->Query("sp_proforma_general(:p2,:p3,:p4,:p5,:p6)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				$stmt->bindValue(':p2',$P['garantia'], PDO::PARAM_INT);
                $stmt->bindValue(':p3',$P['cheque'], PDO::PARAM_INT);
                $stmt->bindValue(':p4',$P['entrega'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['descripcion'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['mensaje'], PDO::PARAM_STR);
				$stmt->execute();
				$this->db->commit();
				$resp = array('rep'=>'1','str'=>'Ok');
				return $resp;
			}
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"4",'msg'=>'no se pudo realizar la accion de actualizar : '.$e->getMessage());
			}
		}
	}
	


	
	
	function contador_proformas(){
	$stmt =$this->db->prepare("select count(idproformas) as total from proformas");
    $stmt->execute();
    $cont = $stmt->fetchObject();
	return $cont->total;
	}
	
	function formato_proforma($correlativo){
		if($correlativo<10){
				$num_proforma = "00000000";
			}elseif($correlativo>9 and $correlativo<100){
				$num_proforma = "0000000";
			}elseif($correlativo>99 and $correlativo<1000){
				$num_proforma = "000000 ";
			}elseif($correlativo>999 and $correlativo<10000){
				$num_proforma = "00000";
			}elseif($correlativo>9999 and $correlativo<100000){
				$num_proforma = "0000";
			}elseif($correlativo>99999 and $correlativo<1000000){
				$num_proforma = "000";
			}elseif($correlativo>999999 and $correlativo<10000000){
				$num_proforma = "00";
			}elseif($correlativo>9999999 and $correlativo<100000000){
				$num_proforma = "0";
			}elseif($correlativo>99999999 and $correlativo<1000000000){
				$num_proforma = "";
			}
			
			$num_proforma .= $correlativo;
			return $num_proforma;
	}
	
	
	function usuario($id){
	$stmt =$this->db->prepare("select nombres from usuario	where idusuario = :id ");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	
	function datos_proforma($id){
	$stmt =$this->db->prepare("select * from proformas	where idproformas = :id ");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	function cliente($id){
	$stmt =$this->db->prepare("select nombres,direccion,telefono,idcliente from cliente where idcliente = :id ");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	function datos_detalle($id){
	$stmt =$this->db->prepare("select t.descripcion as tipo, p.descripcion, p.informacion, d.idproducto, d.cantidad,d.monto from detalle_proforma as d inner join producto as p on (p.idproducto=d.idproducto) inner join tipo as t on (t.idtipo=p.idtipo) where p.estado=1 and d.idproformas = :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
     return array('total_pcs'=>$stmt->rowCount() , 'obj'=>$res );
	}	
	
	function datos_otros($id){
	$stmt =$this->db->prepare("select t.descripcion as tipo, d.descripcion, d.cantidad, d.monto, d.idproducto, d.descuento, d.garantia from detalle_otro as d inner join producto as p on (p.idproducto=d.idproducto) inner join tipo as t on (t.idtipo=p.idtipo) where p.estado=1 and d.idproformas = :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
    return $res;
	}

	function datos_obsequios($id){
	$stmt =$this->db->prepare("select t.descripcion as tipo, d.descripcion, d.cantidad, d.monto, d.idproducto from detalle_obsequios as d inner join producto as p on (p.idproducto=d.idproducto) inner join tipo as t on (t.idtipo=p.idtipo) where p.estado=1 and d.idproformas = :id");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
    return array('flag'=>$stmt->rowCount() , 'obj'=>$res );
	//return $res;
	}	
	
	function proforma_general(){
	$stmt =$this->db->prepare("select * from proforma_general");
    $stmt->execute();
    return $stmt->fetchObject();
	}

	function listaBancos(){
		$stmt =$this->db->prepare("select * from bancos where estado = 1");
   	 	$stmt->execute();
    	return $stmt->fetchAll();
	}
	
	

    function deleteproforma($id)
    {  
	   $stmt=$this->db->prepare("update proformas set estado=0 where idproformas =:id");
	   $stmt->bindValue(':id', $id , PDO::PARAM_STR);
       $stmt->execute();
	}
	

}
?>