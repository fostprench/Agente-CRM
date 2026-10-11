<?php
include_once("Main.php");
class cuentasxcobrar extends Main
{
	function newamortizacion($P)
    {
		if($P['oper']==1)
		{    
			$sql =$this->Query("sp_amortizacion_vc(:p3,:p4,:p5,:p6,:p7)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':p3',$P['idventa'], PDO::PARAM_STR);
                $stmt->bindValue(':p4',$P['fecha'], PDO::PARAM_INT);
                $stmt->bindValue(':p5',$P['monto'], PDO::PARAM_STR);
                $stmt->bindValue(':p6',$P['nro_factura'], PDO::PARAM_INT);
                $stmt->bindValue(':p7',$P['id_usuario'], PDO::PARAM_INT);
                $stmt->execute();
                $this->db->commit();
				$resp = array('rep'=>'1','str'=>'Ok');
				return $resp;
			}
			catch(PDOException $e) 
			{	$this->db->rollBack();
				return array('res'=>"3",'msg'=>'no se pudo realizar la accion de insertar : '.$e->getMessage());
			}
		}
	}

	
	function entidad($id){
	$stmt = $this->db->prepare("SELECT c.razon_social
	FROM venta as v, cliente as c
	WHERE c.idcliente = v.cliente_idcliente and v.idventa =  :id");
    $stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	function datos_p($id){
	$stmt =$this->db->prepare("
	SELECT p.idventa as Id,p.tipo_venta as Tipo_Venta,f.razon_social as Cliente, p.fecha as Fecha,sum(dv.cant_kg) as total_kg, p.total_pago as T_Deuda
FROM venta as p, cliente as f, detalle_venta as dv
where f.idcliente = p.cliente_idcliente and p.forma_pago=2 and p.idventa = dv.venta and p.idventa=:id
group by p.idventa
	");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchObject();
	}
	
	function datos_a($id){
	$stmt =$this->db->prepare("
	SELECT a.idamortizacion as Id, a.fecha_pago as F_pago,a.monto as Monto, a.nro_factura as Factura
FROM venta as v, amortizaciones_vc as a, cliente as c
WHERE c.idcliente = v.cliente_idcliente and v.idventa = a.idventa and a.idventa = :id
	");
	$stmt->bindValue(':id', $id , PDO::PARAM_STR);
    $stmt->execute();
    $res=$stmt->fetchAll();
    return $res;
	}
	
	function edit($id ) 
	{
	    $stmt = $this->db->prepare("SELECT pro.descripcion, pro.idfinanciera,pres.idprestamo, pres.fecha_prestamo, pres.monto, pres.interes, pres.deuda, pres.fecha_venc, pres.contrato, pres.moneda,pres.tipocambio,pres.comision, pres.detalle
									FROM prestamos_financieras as pres,financiera as pro
									WHERE pro.idfinanciera = pres.idfinanciera and pres.idprestamo = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
		
    }
      
	
	function deleteamortizacion($id)
    {     $stmt = $this->db->prepare("delete   FROM amortizaciones_vc WHERE idamortizacion = :id");
          $stmt->bindValue(':id', $id , PDO::PARAM_STR);
          $res=$stmt->execute();
          return $res;
    }
	
}
?>