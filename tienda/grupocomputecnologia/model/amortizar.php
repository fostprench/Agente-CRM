<?php
include_once("Main.php");
class amortizar extends Main
{
	function idMax(){
	 $stmt = $this->db->prepare("SELECT max(idcaja) as max FROM caja where estado = 1");
     $stmt->execute();
     $max=$stmt->fetchObject();
     return $max;
	}
	
	function idMax_Mov(){
	 $stmt = $this->db->prepare("SELECT max(idmovimiento) as max FROM movimiento_caja where estado = 1");
     $stmt->execute();
     $max=$stmt->fetchObject();
     return $max;
	}
	
	function datos_m($id_mov){	
	 $stmt = $this->db->prepare("SELECT descripcion,monto,fecha,idventa,observaciones FROM movimiento_caja WHERE idmovimiento = :id");
	 $stmt->bindValue(':id', $id_mov , PDO::PARAM_STR);
     $stmt->execute();
     return $stmt->fetchObject();
	}
	
	function datos_v($id){
	$stmt =$this->db->prepare("
	SELECT Total, Pago
	FROM v_ventaxcobrar
	WHERE id = :id
	");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}

	
	function datos_cliente($id_venta){	
	 $stmt =$this->db->prepare(" SELECT c.nombres as cliente FROM venta as v, cliente as c	WHERE c.idcliente = v.idcliente and v.idventa =  :id");
	$stmt->bindValue(':id', $id_venta , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	function newamortizar($P)
    {

			$sql =$this->Query("sp_movimiento_vxc(1,0,:p2,:p3,1,1,:p6,:p7,:p8,:p9,:obs,:p10)");
			$stmt =$this->db->prepare($sql);
			if($P['deuda']==$P['monto'] && $P['tipo_amortizacion']=='VentasxCobrar'){
			$stmt2=$this->db->prepare("update venta set estado = 1 where idventa = :idv");
			}
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				$idMax = $this->idMax();
				$idcaja = $idMax->max;
                $stmt->bindValue(':p2',$P['idusuario'], PDO::PARAM_STR);
                $stmt->bindValue(':p3',$idcaja, PDO::PARAM_STR);
                //$stmt->bindValue(':p4',$P['idconcepto'], PDO::PARAM_STR);
                //$stmt->bindValue(':p5',$P['tipo_movimiento'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['descripcion'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['monto'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['fecha_'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['operacion'], PDO::PARAM_STR);
                $stmt->bindValue(':obs',$P['observaciones'], PDO::PARAM_STR);
                $stmt->bindValue(':p10',$P['idventa'], PDO::PARAM_INT);
                $stmt->execute();
				
				if($P['deuda']==$P['monto'] && $P['tipo_amortizacion']=='VentasxCobrar'){
				$stmt2->bindValue(':idv',$P['idventa'], PDO::PARAM_INT);
                $stmt2->execute();
				}
				
				$idMax_mov = $this->idMax_Mov();
				$idMovimiento = $idMax_mov->max;
				
                $this->db->commit();
				$resp = array('rep'=>'1','str'=>'Ok: Amortizacion Realizada Correctamente','idmov'=>$idMovimiento);
				return $resp;
			}
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"3",'msg'=>'no se pudo realizar la accion de insertar : '.$e->getMessage());
			}

	}

	
	function edit($id ) 
	{
	    $stmt = $this->db->prepare("SELECT * FROM amortizar WHERE idamortizar = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
		
    }
      
    function deleteamortizar($P)
    {     //idcaja movimiento
		  $stmt = $this->db->prepare("SELECT idusuario,idcaja,monto FROM movimiento_caja WHERE idmovimiento = :id");
          $stmt->bindValue(':id', $P['idmovimiento'] , PDO::PARAM_INT);
          $stmt->execute();
          $data = $stmt->fetchObject();
		  $idUsuario = $data->idusuario;
		  $idCaja = $data->idcaja;
		  $Monto = $data->monto;
		  
		  //idcaja activa
		  $idMax = $this->idMax();
		  $idMax = $idMax->max;
		  
		  if($idMax == $idCaja){
		      if($idUsuario==$_SESSION['id_usuario']){
			  
				  $stmt2 = $this->db->prepare("update movimiento_caja set estado=0 WHERE idmovimiento = :idm and idventa = :idv ");

				  $sql =$this->Query("sp_modificar_saldocaja(0,:m1)");
			      $stmt3 =$this->db->prepare($sql);
				  
				  try
					{
						$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$this->db->beginTransaction();
						
						$stmt2->bindValue(':idm', $P['idmovimiento'] , PDO::PARAM_INT);
						$stmt2->bindValue(':idv', $P['idventa'] , PDO::PARAM_INT);
						$stmt2->execute();
						
						$stmt3->bindValue(':m1', $Monto , PDO::PARAM_INT);
						$stmt3->execute();
						
						$this->db->commit();
						return array('rep'=>'1','msg'=>'Eliminado');
					}
					catch(PDOException $e) 
					{
						$this->db->rollBack();
						return array('res'=>"3",'msg'=>'no se pudo eliminar','error'=>"ERROR: ".$e->getMessage());
					}
				  
				  
				  
				  
			  }else{
				  return array('rep'=>'2','msg'=>'No se puede eliminar','error'=>'ERROR: No se puede eliminar amortizacion O movimiento registrado por otro usuario.');
			  }
			  
		  }else{
			  return array('rep'=>'2','msg'=>'No se puede eliminar','error'=>'ERROR: No se puede eliminar amortizacion de una caja cerrada.');
		  }
		  
    }
	
}
?>