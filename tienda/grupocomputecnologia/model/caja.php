<?php
include_once("Main.php");
class caja extends Main
{
	function Aperturar ($P)
    {
			if($P['oper']==1){
					$sql =$this->Query("sp_apertura(:p1,:p2,:p3,1,0)"); //(...,op,idcaja)
					$stmt =$this->db->prepare($sql);
					try
					{
						$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$this->db->beginTransaction();
						$stmt->bindValue(':p1',$P['fecha_'], PDO::PARAM_STR);
						$stmt->bindValue(':p2',$P['monto_a'], PDO::PARAM_STR);
						$stmt->bindValue(':p3',$P['id_usuario'], PDO::PARAM_STR);
						$stmt->execute();
						$this->db->commit();
						$resp = array('rep'=>'1','str'=>'Ok');
						return $resp;
					}
					catch(PDOException $e) 
					{
						$this->db->rollBack();
						return array('res'=>"3",'msg'=>'No se pudo realizar la accion de Insertar : '.$e->getMessage());
					}
			}else{
					$sql =$this->Query("sp_apertura(:p1,:p2,:p3,2,:p5)"); //(...,op,idcaja)
					$stmt =$this->db->prepare($sql);
					try
					{
						$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$this->db->beginTransaction();
						$stmt->bindValue(':p1',$P['fecha_'], PDO::PARAM_STR);
						$stmt->bindValue(':p2',$P['monto_a'], PDO::PARAM_STR);
						$stmt->bindValue(':p3',$P['id_usuario'], PDO::PARAM_STR);
						$stmt->bindValue(':p5',$P['id_caja'], PDO::PARAM_STR);
						$stmt->execute();
						$this->db->commit();
						$resp = array('rep'=>'1','str'=>'Ok');
						return $resp;
					}
					catch(PDOException $e) 
					{
						$this->db->rollBack();
						return array('res'=>"3",'msg'=>'No se pudo realizar la accion de Editar : '.$e->getMessage());
					}
			}
			
	}

	function edit($id ) 
	{
        $stmt = $this->db->prepare("SELECT * FROM caja WHERE idtipo = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
      

	
	 function cerrarcaja($fecha_cierre,$Idcaja)
    {
	     $stmt = $this->db->prepare("update caja set estado = 0, fecha_c = :f1 WHERE idcaja = :id");
         $stmt->bindValue(':f1', $fecha_cierre , PDO::PARAM_STR);
		 $stmt->bindValue(':id', $Idcaja, PDO::PARAM_STR); 
         $res=$stmt->execute();
        return $res;
    }
	
	function max_idcaja(){
		 $stmt = $this->db->prepare("SELECT max(idcaja) as max FROM caja");
         $stmt->execute();
         $max=$stmt->fetchObject();
		 return $max;
	}
	
	function verifica_caja($max){
		 if($max!=null){
		 $stmt2 = $this->db->prepare("SELECT estado FROM caja where idcaja = :max");
		 $stmt2->bindValue(':max', $max , PDO::PARAM_INT);
         $stmt2->execute();
         $estado=$stmt2->fetchObject();
         return $estado;
		 }else{
		 return null;
		 }
	}
	
	function saldo_caja($max){
		 $stmt2 = $this->db->prepare("SELECT monto_c as saldo FROM caja where idcaja = :max");
		 $stmt2->bindValue(':max', $max , PDO::PARAM_INT);
         $stmt2->execute();
         $saldo=$stmt2->fetchObject();
         return $saldo;
	}
	
	function idcaja_activa(){
		 $stmt = $this->db->prepare("SELECT idcaja as max FROM caja where estado = 1");
         $stmt->execute();
         $max=$stmt->fetchObject();
		 
		 return $max;
	}
	
	function fecha_max_mov($idCaja){
		 $stmt3 = $this->db->prepare("SELECT max(fecha) as fecha FROM movimiento_caja WHERE estado=1 and idcaja = :id_max");
		 $stmt3->bindValue(':id_max', $idCaja, PDO::PARAM_INT);
         $stmt3->execute();
         $fecha_max=$stmt3->fetchObject();
         return $fecha_max;
	}
	
	function saldo_caja_apertura($idCaja){
	     		 
		 $stmt2 = $this->db->prepare("SELECT monto_a,fecha_a,fecha_c,idusuario,idcaja  FROM caja where idcaja = :max");
		 $stmt2->bindValue(':max', $idCaja , PDO::PARAM_INT);
         $stmt2->execute();
         $saldo=$stmt2->fetchObject();
         return $saldo;
	
	}
	
	function user_nombre($id_user){
	     		 
		 $stmt2 = $this->db->prepare("SELECT nombres  FROM usuario where idusuario = :max");
		 $stmt2->bindValue(':max', $id_user , PDO::PARAM_INT);
         $stmt2->execute();
         $nombre=$stmt2->fetchObject();
         return $nombre;
	
	}
	
	function ingreso($id){
		 $stmt2 = $this->db->prepare("select fecha,descripcion, monto from movimiento_caja where estado = 1 and tipo_movimiento = 1 and idcaja = $id");
         $stmt2->execute();
         $ingreso=$stmt2->fetchAll();
         return $ingreso;
	}
	
	function egreso($id){
		 $stmt2 = $this->db->prepare("select fecha,descripcion, monto, operacion, observaciones from movimiento_caja where estado = 1 and tipo_movimiento = 2 and idcaja = $id");
         $stmt2->execute();
         $egreso=$stmt2->fetchAll();
         return $egreso;
	}
	
	function SUM_ingresos($id){
		 $stmt2 = $this->db->prepare("SELECT SUM(monto) as total FROM movimiento_caja WHERE estado = 1 and tipo_movimiento = 1 and idcaja = $id");
         $stmt2->execute();
         $Sum_ingreso=$stmt2->fetchObject();
         return $Sum_ingreso;
	}
	
	function SUM_egresos($id){
		 $stmt2 = $this->db->prepare("SELECT SUM(monto) as total FROM movimiento_caja WHERE estado = 1 and tipo_movimiento = 2 and idcaja = $id");
         $stmt2->execute();
         $Sum_egreso=$stmt2->fetchObject();
         return $Sum_egreso;
	}
}


?>