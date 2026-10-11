<?php
include_once("Main.php");
class reporte_grafico extends Main
{

    function data_Caja(){
		  $stmt2 = $this->db->prepare("select fecha_a,monto_c,monto_a,idcaja,fecha_c from caja order by fecha_a desc limit 12");
		 $stmt2->execute();
         $caja=$stmt2->fetchAll();
         return $caja;
	}
	
	function soporte_tecnico($f_inicio,$f_fin){
		 $stmt2 = $this->db->prepare("			
			SELECT   SUM(dv.cantidad*dv.subtotal) as total
			FROM venta as v 
			inner join detalle_venta as dv on (dv.idventa = v.idventa)
			WHERE v.tipo_venta = 1  and v.estado = 1 and dv.idproducto = 0 and v.fecha BETWEEN :fecha1 and :fecha2		
		 ");
         $stmt2->bindValue(':fecha1', $f_inicio , PDO::PARAM_INT);
         $stmt2->bindValue(':fecha2', $f_fin , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso_soporte=$stmt2->fetchObject();
		 
		 $stmt3 = $this->db->prepare(" SELECT SUM(monto) as total2 FROM movimiento_caja where fecha  BETWEEN :fecha_i and :fecha_f and estado = 1 and idcontrolcaja = 7 ");
         $stmt3->bindValue(':fecha_i', $f_inicio , PDO::PARAM_STR);
         $stmt3->bindValue(':fecha_f', $f_fin , PDO::PARAM_STR);
		 $stmt3->execute();
		 $egreso_soporte=$stmt3->fetchObject();
		 
		 $dif = $ingreso_soporte->total-$egreso_soporte->total2;
		 
         return  $dif;
	}
	
	 function total_ingreso($fecha){
		 $stmt2 = $this->db->prepare("select SUM(monto) as total from movimiento_caja where estado = 1 and tipo_movimiento = 1 and DATE_FORMAT( fecha, '%Y/%m/%d' ) LIKE :fecha");
         $stmt2->bindValue(':fecha', $fecha , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso=$stmt2->fetchObject();
         return $ingreso;
	}
	
	function egreso($fecha){
		 $stmt2 = $this->db->prepare("select descripcion, monto from movimiento_caja where estado = 1 and tipo_movimiento = 2 and DATE_FORMAT( fecha, '%Y/%m/%d' ) LIKE :fecha");
         $stmt2->bindValue(':fecha', $fecha , PDO::PARAM_INT);
		 $stmt2->execute();
         $egreso=$stmt2->fetchAll();
         return $egreso;
	}
	
	function total_egreso($fecha){
		 $stmt2 = $this->db->prepare("select SUM(monto) as total from movimiento_caja where estado = 1 and tipo_movimiento = 2 and DATE_FORMAT( fecha, '%Y/%m/%d' ) LIKE :fecha");
         $stmt2->bindValue(':fecha', $fecha , PDO::PARAM_INT);
		 $stmt2->execute();
         $egreso=$stmt2->fetchObject();
         return $egreso;
	}
	
	function inventario($order){
		if($order=='1'){ $order_by = "id asc";}
		if($order=='2'){ $order_by = "stock asc";}
		if($order=='3'){ $order_by = "stock desc";}
		$sql = "select * from v_inventario_p order by ".$order_by;
		$stmt2 = $this->db->prepare($sql);
		$stmt2->execute();
        $inventario=$stmt2->fetchAll();
        return $inventario;
	}
	
	function apertura_caja(){
		 $stmt2 = $this->db->prepare("select * from v_caja order by id desc limit 24");
		 $stmt2->execute();
         $caja=$stmt2->fetchAll();
         return $caja;
	}
	
	function data_venta_c($idcaja){
		 $stmt2 = $this->db->prepare("SELECT v.idventa as id, c.nombres as cliente, v.nro_comprobante as comprobante, v.fecha as fecha_venta, v.total
FROM venta as v 
inner join movimiento_caja as mc on (v.idventa = mc.idventa)
inner join cliente as c on (c.idcliente = v.idcliente)
WHERE v.tipo_venta = 1 and mc.idcaja = :id and v.estado = 1
group by v.idventa ");
		 $stmt2->bindValue(':id', $idcaja , PDO::PARAM_INT);
		 $stmt2->execute();
         $caja=$stmt2->fetchAll();
         return $caja;
	}
	
	function data_venta_xc(){
		 $stmt2 = $this->db->prepare("SELECT v.idventa as id, c.nombres as cliente, v.nro_comprobante as comprobante, v.fecha as fecha_venta, v.total
		FROM venta as v 
		inner join cliente as c on (c.idcliente = v.idcliente)
		WHERE v.estado = 2 and v.tipo_venta = 2");
		 $stmt2->execute();
         $caja=$stmt2->fetchAll();
         return $caja;
	}
	
	function data_venta_xc_All(){
		$anio = date('Y'); 
		$stmt2 = $this->db->prepare("SELECT v.idventa as id, c.nombres as cliente, v.nro_comprobante as comprobante, v.fecha as fecha_venta, v.total
		FROM venta as v 
		inner join cliente as c on (c.idcliente = v.idcliente)
		WHERE v.tipo_venta = 2 and DATE_FORMAT( v.fecha, '%Y' ) LIKE '$anio' ");
		 $stmt2->execute();
         $caja=$stmt2->fetchAll();
         return $caja;
	}
	

}
?>