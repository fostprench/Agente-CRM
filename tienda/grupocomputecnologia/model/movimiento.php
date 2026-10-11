<?php
include_once("Main.php");
class movimiento extends Main
{
	function newmovimiento ($P)
    {
		if($P['oper']==1)
		{    
			$sql =$this->Query("sp_movimiento(1,0,:p2,:p3,1,:p5,:p6,:p7,:p8,:p9,:obs,:idcontrol)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':p2',$P['id_usuario'], PDO::PARAM_STR);
                $stmt->bindValue(':p3',$P['idcaja'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['tipo_movimiento'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['descripcion'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['monto'], PDO::PARAM_STR);
                $stmt->bindValue(':p8',$P['fecha_'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['operacion'], PDO::PARAM_STR);
                $stmt->bindValue(':obs',$P['observaciones'], PDO::PARAM_STR);
                $stmt->bindValue(':idcontrol',$P['idcontrolcaja'], PDO::PARAM_STR);
                $stmt->execute();
                $this->db->commit();
				$resp = array('rep'=>'1','str'=>'Ok');
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
			
			$SQL = "SELECT monto FROM movimiento_caja WHERE idmovimiento = ".$P['idmovimiento'];
			$stmt =$this->db->prepare($SQL);
		    $stmt->execute();
			$dato = $stmt->fetchObject();
			$Monto = $dato->monto;
			
			
			$SQL2 = "SELECT monto_c FROM caja WHERE idcaja = ".$P['idcaja'];
			$stmt2 =$this->db->prepare($SQL2);
			$stmt2->execute();
			$dato2 = $stmt2->fetchObject();
			$Saldo = $dato2->monto_c;
			
			if($P['tipo_movimiento']==1){
				$Saldo = $Saldo - $Monto;
				$Saldo_Original = $Saldo;
				$Saldo = $Saldo + $P['monto'];				
				}else if($P['tipo_movimiento']==2){
				$Saldo = $Saldo + $Monto;
				$Saldo_Original = $Saldo;
				$Saldo = $Saldo - $P['monto'];
			}
			
			
			$SQL3 = "UPDATE caja SET monto_c = $Saldo WHERE idcaja = ".$P['idcaja'];
			$stmt3 =$this->db->prepare($SQL3);
			$stmt3->execute();
			
			$SQL4 = "UPDATE movimiento_caja SET saldo_caja=$Saldo_Original  WHERE idmovimiento = ".$P['idmovimiento'];
			$stmt4 =$this->db->prepare($SQL4);
			$stmt4->execute();
			
				
			$SQL4 =$this->Query("sp_movimiento(2,:id_,:p2,:p3,1,:p5,:p6,:p7,:p8,:p9,:obs,:idcontrol)");
			$stmt4 =$this->db->prepare($SQL4);
			
			try
			{
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->beginTransaction();
			
				$stmt4->bindValue(':id_',$P['idmovimiento'], PDO::PARAM_STR);
				$stmt4->bindValue(':p2',$P['id_usuario'], PDO::PARAM_STR);
                $stmt4->bindValue(':p3',$P['idcaja'], PDO::PARAM_STR);
                $stmt4->bindValue(':p5',$P['tipo_movimiento'], PDO::PARAM_STR);
                $stmt4->bindValue(':p6',$P['descripcion'], PDO::PARAM_STR);
                $stmt4->bindValue(':p7',$P['monto'], PDO::PARAM_STR);
				$stmt4->bindValue(':p8',$P['fecha_'], PDO::PARAM_STR);
				$stmt4->bindValue(':p9',$P['operacion'], PDO::PARAM_STR);
				$stmt4->bindValue(':obs',$P['observaciones'], PDO::PARAM_STR);
				$stmt4->bindValue(':idcontrol',$P['idcontrolcaja'], PDO::PARAM_STR);
                $stmt4->execute();
				
				$this->db->commit();
				$resp = array('rep'=>'2','msg'=>'Movimiento Editado Correctamente');
				return $resp;
			}
			catch(PDOException $e) 
			{
				$this->db->rollBack();
				return array('res'=>"4",'msg'=>'no se pudo realizar la accion de actualizar : '.$e->getMessage());
			}
			
			
		}
	}
	
	function edit($id ) 
	{
        $stmt = $this->db->prepare("SELECT m.idventa,m.idmovimiento,u.idusuario,u.nombres,m.idcaja,m.idconcepto,m.tipo_movimiento,m.descripcion,m.monto,m.fecha,m.operacion,m.observaciones,m.idcontrolcaja
									FROM movimiento_caja as m, usuario as u
								    WHERE u.idusuario = m.idusuario and m.idmovimiento = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
      

    function deletemovimiento ($idmovimiento,$idcaja,$tipo_movimiento)
    {
			$mov = $this->edit($idmovimiento);
			
			if($mov->idventa==NULL){
				$SQL = "SELECT monto FROM movimiento_caja WHERE idmovimiento = $idmovimiento";
				$stmt =$this->db->prepare($SQL);
				$stmt->execute();
				$dato = $stmt->fetchObject();
				$Monto = $dato->monto;
				
				$SQL2 = "SELECT monto_c FROM caja WHERE idcaja = $idcaja";
				$stmt2 =$this->db->prepare($SQL2);
				$stmt2->execute();
				$dato2 = $stmt2->fetchObject();
				$Saldo = $dato2->monto_c;
				
					if($tipo_movimiento==1){
					$Saldo = $Saldo - $Monto;
					}else if($tipo_movimiento==2){
					$Saldo = $Saldo + $Monto;
					}
				
				$SQL3 = "UPDATE caja SET monto_c = $Saldo WHERE idcaja = $idcaja";
				$stmt3 =$this->db->prepare($SQL3);
				$stmt3->execute();
				
				$SQL4 = "UPDATE movimiento_caja SET estado = 0 WHERE idmovimiento = $idmovimiento";
				$stmt4 =$this->db->prepare($SQL4);
				$stmt4->execute();
		
				$resp = array('rep'=>'1','msg'=>'ELIMINADO');
				return $resp;
			}else{
				$resp = array('rep'=>'0','msg'=>'No se Puede Editar un Registro de Venta');
				return $resp;
			}	
			
    }
	
	function idcaja(){
	     $stmt = $this->db->prepare("SELECT idcaja as max FROM caja where estado = 1");
         $stmt->execute();
         $max=$stmt->fetchObject();
         return $max;
	 }
	 
	 function tipo_movimiento($id){
	     $stmt = $this->db->prepare("select idcaja,tipo_movimiento from movimiento_caja where idmovimiento = :id");
         $stmt->bindValue(':id', $id , PDO::PARAM_STR);
		 $stmt->execute();
         $tipo=$stmt->fetchObject();
         return $tipo;
	 }
	
}
?>