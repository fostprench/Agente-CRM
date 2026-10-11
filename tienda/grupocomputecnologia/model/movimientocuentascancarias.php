<?php
include_once("Main.php");
class movimientocuentascancarias extends Main
{
	function newmovimiento($P)
    {
		if($P['oper']==1)
		{  
			$stmt2 =$this->db->prepare("UPDATE cuentas_bancarias set monto=:monto WHERE idcuentas_bancarias = :id");			
			$sql =$this->Query("sp_cuentas_bancarias(:p1,:p2,:p3,:p4,:p5,:p6,:p7,1,0)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				
				$saldo_banco = $this->saldo_banco_model($P['idcuentas_bancarias']);
				
				if($P['tipo_ingreso']==1){ 
					//ingreso suma MONTO la cuenta del banco
					$nuevo_monto = $saldo_banco->monto + $P['monto'];
				}else{
					//egreso resta MONTO la cuenta del banco
					$nuevo_monto = $saldo_banco->monto - $P['monto'];
				}
				
				
				$stmt2->bindValue(':monto', $nuevo_monto , PDO::PARAM_STR);
				$stmt2->bindValue(':id', $P['idcuentas_bancarias'] , PDO::PARAM_INT);
				$stmt2->execute();
				
				
				
                $stmt->bindValue(':p1',$P['idmotivo_movimiento'], PDO::PARAM_STR);
                $stmt->bindValue(':p2',$P['idcuentas_bancarias'], PDO::PARAM_STR);
                $stmt->bindValue(':p3',$P['tipo_ingreso'], PDO::PARAM_STR);
                $stmt->bindValue(':p4',$P['monto'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['referencia'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['observacion'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['fecha_'], PDO::PARAM_STR);
                $stmt->execute();
                $this->db->commit();
				$resp = array('rep'=>'1','str'=>'Ok'.$nuevo_monto);
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
			$stmt2 =$this->db->prepare("UPDATE cuentas_bancarias set monto=:monto WHERE idcuentas_bancarias = :id");
			
			$sql =$this->Query("sp_cuentas_bancarias(:p1,:p2,:p3,:p4,:p5,:p6,:p7,2,:p9)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				
			
				$datos_mov = $this->edit($P['idmovimiento_cuentas']); 	//consultar datos del movimiento
				
				if($P['idcuentas_bancarias']==$datos_mov->idcuentas_bancarias){
					
					$saldo_banco = $this->saldo_banco_model($P['idcuentas_bancarias']); // saldo cuenta bancaria
				
					if($datos_mov->tipo_movimiento==1){//ingreso					
						$nuevo_monto = $saldo_banco->monto - $datos_mov->monto;					
					}else{//egreso
						$nuevo_monto = $saldo_banco->monto + $datos_mov->monto;
					}					
					
					if($P['tipo_ingreso']==1){ 
						//ingreso suma MONTO la cuenta del banco
						$nuevo_monto2 = $nuevo_monto + $P['monto'];
					}else{
						//egreso resta MONTO la cuenta del banco
						$nuevo_monto2 = $nuevo_monto - $P['monto'];
					}

					$stmt2->bindValue(':monto', $nuevo_monto2 , PDO::PARAM_STR);
					$stmt2->bindValue(':id', $P['idcuentas_bancarias'] , PDO::PARAM_INT);
					$stmt2->execute();		
				
				}else{ // edita banco, lo cambia por otro
				
					$saldo_banco = $this->saldo_banco_model($datos_mov->idcuentas_bancarias); // saldo cuenta bancaria
				
					if($datos_mov->tipo_movimiento==1){//ingreso					
						$nuevo_monto = $saldo_banco->monto - $datos_mov->monto;					
					}else{//egreso
						$nuevo_monto = $saldo_banco->monto + $datos_mov->monto;
					}
					
					$stmt2->bindValue(':monto', $nuevo_monto, PDO::PARAM_STR);
					$stmt2->bindValue(':id', $datos_mov->idcuentas_bancarias , PDO::PARAM_INT);
					$stmt2->execute();
					
					$saldo_banco_nuevo = $this->saldo_banco_model($P['idcuentas_bancarias']); // saldo cuenta bancaria
					
					if($P['tipo_ingreso']==1){ 
						//ingreso suma MONTO la cuenta del banco
						$nuevo_monto2 = $saldo_banco_nuevo->monto + $P['monto'];
					}else{
						//egreso resta MONTO la cuenta del banco
						$nuevo_monto2 = $saldo_banco_nuevo->monto - $P['monto'];
					}
					
					$stmt2->bindValue(':monto', $nuevo_monto2, PDO::PARAM_STR);
					$stmt2->bindValue(':id', $P['idcuentas_bancarias'] , PDO::PARAM_INT);
					$stmt2->execute();
					
				}
				
                $stmt->bindValue(':p1',$P['idmotivo_movimiento'], PDO::PARAM_STR);
                $stmt->bindValue(':p2',$P['idcuentas_bancarias'], PDO::PARAM_STR);
                $stmt->bindValue(':p3',$P['tipo_ingreso'], PDO::PARAM_STR);
                $stmt->bindValue(':p4',$P['monto'], PDO::PARAM_STR);
                $stmt->bindValue(':p5',$P['referencia'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['observacion'], PDO::PARAM_STR);
                $stmt->bindValue(':p7',$P['fecha_'], PDO::PARAM_STR);
                $stmt->bindValue(':p9',$P['idmovimiento_cuentas'], PDO::PARAM_STR);
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
	}
	
	function saldo_banco_model($idbanco) 
	{
        $stmt = $this->db->prepare("SELECT monto FROM cuentas_bancarias WHERE idcuentas_bancarias = :id");
        $stmt->bindValue(':id', $idbanco , PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchObject();
		return $data;
    }
	
	function saldo_banco($X) 
	{
        $stmt = $this->db->prepare("SELECT monto FROM cuentas_bancarias WHERE idcuentas_bancarias = :id");
        $stmt->bindValue(':id', $X['idbanco'] , PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchObject();
		$resp = array('monto'=>$data->monto);
		return $resp;
    }
	
	function Updatesaldo_banco($Y) 
	{
        $stmt = $this->db->prepare("UPDATE cuentas_bancarias set monto=:monto WHERE idcuentas_bancarias = :id");
        $stmt->bindValue(':monto', $Y['monto'] , PDO::PARAM_STR);
        $stmt->bindValue(':id', $Y['idbanco'] , PDO::PARAM_STR);
        $stmt->execute();
        $stmt->fetchObject();
		$resp = array('mensaje'=>'Saldo Actualizado Correctamente');
		return $resp;
    }
	
	function edit($id) 
	{
        $stmt = $this->db->prepare("SELECT * FROM movimiento_cuentas WHERE idmovimiento_cuentas = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
      

    function deletemovimiento ($id)
    {
		 $datos_mov = $this->edit($id); 	//consultar datos del movimiento
		 $saldo_banco = $this->saldo_banco_model($datos_mov->idcuentas_bancarias); // saldo cuenta bancaria				
		 if($datos_mov->tipo_movimiento==1){//ingreso					
				$nuevo_monto = $saldo_banco->monto - $datos_mov->monto;					
		 }else{//egreso
				$nuevo_monto = $saldo_banco->monto + $datos_mov->monto;
		 }
		
		 $stmt2 = $this->db->prepare("UPDATE cuentas_bancarias set monto=:monto WHERE idcuentas_bancarias = :id");
         $stmt2->bindValue(':id', $datos_mov->idcuentas_bancarias , PDO::PARAM_INT);
         $stmt2->bindValue(':monto', $nuevo_monto , PDO::PARAM_INT);
         $stmt2->execute();
		 
		 
	     $stmt = $this->db->prepare("UPDATE movimiento_cuentas set estado = 0 WHERE idmovimiento_cuentas = :id");
         $stmt->bindValue(':id', $id , PDO::PARAM_INT);
         $res=$stmt->execute();
         return $res;
    }
}
?>