<?php
include_once("Main.php");
class reporte extends Main
{
	function reporte_general(){
		 $stmt2 = $this->db->prepare("select idcontrolcaja as id, descripcion, tipo from controlcaja order by tipo asc");
		 $stmt2->execute();
         $control_caja=$stmt2->fetchAll();
         return $control_caja;
	}
	
	function suma_total_movimientos($idcaja,$idcontrol){
		 $stmt2 = $this->db->prepare("select SUM(monto) as total from movimiento_caja where estado=1 and idcaja = :id1 and idcontrolcaja = :id2");
		 $stmt2->bindValue(':id1', $idcaja , PDO::PARAM_INT);
		 $stmt2->bindValue(':id2', $idcontrol , PDO::PARAM_INT);
		 $stmt2->execute();
         $total_monto = $stmt2->fetchObject();
         return $total_monto->total;
	}
	
	function detalle_movimientoXidcontrol($idcaja,$idcontrol){
		 $stmt2 = $this->db->prepare("select descripcion,monto,fecha from movimiento_caja where estado=1 and idcaja = :id1 and idcontrolcaja = :id2 order by fecha asc");
		 $stmt2->bindValue(':id1', $idcaja , PDO::PARAM_INT);
		 $stmt2->bindValue(':id2', $idcontrol , PDO::PARAM_INT);
		 $stmt2->execute();
         $detalle_movimiento = $stmt2->fetchAll();
         return $detalle_movimiento;
	}
	
	function ingreso_soporte_rango($f_inicio,$f_fin){ //c.telefono obviado por falta de espacio
		 $stmt2 = $this->db->prepare("
			SELECT   dv.descripcion, c.nombres, dv.cantidad*dv.subtotal as total,v.fecha, c.idcliente, st.desc_equipo as detalle
			FROM venta as v 
			inner join detalle_venta as dv on (dv.idventa = v.idventa)
			inner join orden_st as st on (st.idorden_st = dv.idorden_st)
			inner join cliente as c on (c.idcliente = v.idcliente) 
			WHERE v.tipo_venta = 1  and v.estado = 1 and dv.idproducto = 0 and v.fecha BETWEEN :fecha1 and :fecha2
			order by dv.idventa asc
		 ");
         $stmt2->bindValue(':fecha1', $f_inicio , PDO::PARAM_INT);
         $stmt2->bindValue(':fecha2', $f_fin , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso_soporte=$stmt2->fetchAll();
         return $ingreso_soporte;
	}
	
	function ingreso_soporte_dia($fecha){
		 $stmt2 = $this->db->prepare("
			SELECT   dv.descripcion, c.nombres, dv.cantidad*dv.subtotal as total,v.fecha, c.idcliente, st.desc_equipo as detalle
			FROM venta as v 
			inner join detalle_venta as dv on (dv.idventa = v.idventa)
			inner join orden_st as st on (st.idorden_st = dv.idorden_st)
			inner join cliente as c on (c.idcliente = v.idcliente) 
			WHERE v.tipo_venta = 1  and v.estado = 1 and dv.idproducto = 0 and v.fecha = :fecha2
			order by dv.idventa asc
		 ");
         $stmt2->bindValue(':fecha2', $fecha , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso_soporte=$stmt2->fetchAll();
         return $ingreso_soporte;
	}
	
	
	function CAJA_AL($id){
		 $stmt2 = $this->db->prepare(" SELECT fecha_a as fecha, monto_a, fecha_c FROM caja where idcaja = :max ");
         $stmt2->bindValue(':max', $id , PDO::PARAM_INT);
		 $stmt2->execute();
         $caja_al=$stmt2->fetchObject();
         return $caja_al;
	}
	
	function data_egresos_soporte($id){
		 $stmt2 = $this->db->prepare(" SELECT descripcion, monto, fecha FROM movimiento_caja where idcaja = :max and estado = 1 and idcontrolcaja = 7 ");
         $stmt2->bindValue(':max', $id , PDO::PARAM_INT);
		 $stmt2->execute();
         $egresos_soporte = $stmt2->fetchAll();
         return $egresos_soporte;
	}
	
	function data_egresos_soporte_rango($fecha_i,$fecha_f){
		 $stmt2 = $this->db->prepare(" SELECT descripcion, monto, fecha FROM movimiento_caja where fecha  BETWEEN :fecha_i and :fecha_f and estado = 1 and idcontrolcaja = 7 ");
         $stmt2->bindValue(':fecha_i', $fecha_i , PDO::PARAM_STR);
         $stmt2->bindValue(':fecha_f', $fecha_f , PDO::PARAM_STR);
		 $stmt2->execute();
         $egresos_soporte = $stmt2->fetchAll();
         return $egresos_soporte;
	}
	
	function saldo_caja_inicio_fecha($fecha_i){
		 $stmt2 = $this->db->prepare(" SELECT idcaja FROM movimiento_caja where fecha = :f ");
         $stmt2->bindValue(':f', $fecha_i , PDO::PARAM_INT);
		 $stmt2->execute();
         $idcaja=$stmt2->fetchAll();
		 $id = $idcaja[0][0];
		 $stmt3 = $this->db->prepare(" SELECT monto_a, fecha_a FROM caja where idcaja = :id ");
         $stmt3->bindValue(':id', $id , PDO::PARAM_INT);
		 $stmt3->execute();
         $monto_a=$stmt3->fetchObject();
		 //return array('flag'=>$stmt3->rowCount() , 'monto'=>$monto_a );
         return $monto_a;
	}
	
	// INGRESO DE CAJA POR APERTURA DE CAJA
	function ingreso_idcaja($id){
		 $stmt2 = $this->db->prepare("select descripcion, monto from movimiento_caja where estado = 1 and tipo_movimiento = 1 and idcaja = :idcaja");
         $stmt2->bindValue(':idcaja', $id , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso_caja=$stmt2->fetchAll();
         return $ingreso_caja;
	}
	
	function total_ingreso_caja($id){
		 $stmt2 = $this->db->prepare("select SUM(monto) as total from movimiento_caja where estado = 1 and tipo_movimiento = 1 and idcaja = :idcaja");
         $stmt2->bindValue(':idcaja', $id , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso=$stmt2->fetchObject();
         return $ingreso;
	}
	
	// EGRESO DE CAJA POR APERTURA DE CAJA
	function egreso_idcaja($id){
		 $stmt2 = $this->db->prepare("select descripcion, monto from movimiento_caja where estado = 1 and tipo_movimiento = 2 and idcaja = :idcaja");
         $stmt2->bindValue(':idcaja', $id , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso_caja=$stmt2->fetchAll();
         return $ingreso_caja;
	}
	
	function total_egreso_caja($id){
		 $stmt2 = $this->db->prepare("select SUM(monto) as total from movimiento_caja where estado = 1 and tipo_movimiento = 2 and idcaja = :idcaja");
         $stmt2->bindValue(':idcaja', $id , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso=$stmt2->fetchObject();
         return $ingreso;
	}
	
	// INGRESO DE CAJA POR RANGO DE FECHA
    function ingreso_rango($fecha1,$fecha2){
		 $stmt2 = $this->db->prepare("select descripcion, monto from movimiento_caja where estado = 1 and tipo_movimiento = 1 and fecha BETWEEN :fecha1 and :fecha2");
         $stmt2->bindValue(':fecha1', $fecha1 , PDO::PARAM_INT);
         $stmt2->bindValue(':fecha2', $fecha2 , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso=$stmt2->fetchAll();
         return $ingreso;
	}
	
	// EGRESO DE CAJA POR RANGO DE FECHA
    function egreso_rango($fecha1,$fecha2){
		 $stmt2 = $this->db->prepare("select descripcion, monto from movimiento_caja where estado = 1 and tipo_movimiento = 2 and fecha BETWEEN :fecha1 and :fecha2");
         $stmt2->bindValue(':fecha1', $fecha1 , PDO::PARAM_INT);
         $stmt2->bindValue(':fecha2', $fecha2 , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso=$stmt2->fetchAll();
         return $ingreso;
	}
	
	// INGRESO DE CAJA POR RANGO DE FECHA
    function total_ingreso_rango($fecha1,$fecha2){
		 $stmt2 = $this->db->prepare("select SUM(monto) as total from movimiento_caja where estado = 1 and tipo_movimiento = 1 and fecha BETWEEN :fecha1 and :fecha2");
         $stmt2->bindValue(':fecha1', $fecha1 , PDO::PARAM_INT);
         $stmt2->bindValue(':fecha2', $fecha2 , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso=$stmt2->fetchObject();
         return $ingreso;
	}
	
	// INGRESO DE CAJA POR RANGO DE FECHA
    function total_egreso_rango($fecha1,$fecha2){
		 $stmt2 = $this->db->prepare("select SUM(monto) as total from movimiento_caja where estado = 1 and tipo_movimiento = 2 and fecha BETWEEN :fecha1 and :fecha2");
         $stmt2->bindValue(':fecha1', $fecha1 , PDO::PARAM_INT);
         $stmt2->bindValue(':fecha2', $fecha2 , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso=$stmt2->fetchObject();
         return $ingreso;
	}
	
	
	// INGRESO DE CAJA POR FECHA DETERMINADA
    function ingreso($fecha){
		 $stmt2 = $this->db->prepare("select descripcion, monto from movimiento_caja where estado = 1 and tipo_movimiento = 1 and DATE_FORMAT( fecha, '%Y/%m/%d' ) LIKE :fecha");
         $stmt2->bindValue(':fecha', $fecha , PDO::PARAM_INT);
		 $stmt2->execute();
         $ingreso=$stmt2->fetchAll();
         return $ingreso;
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
		if($order=='1'){ $order_by = "order by id asc"; }
		if($order=='2'){ $order_by = "order by stock asc"; }
		if($order=='3'){ $order_by = "order by stock desc"; }
		if($order=='4'){ $order_by = "where stock>0"; }
		if($order=='5'){ $order_by = "where stock=0"; }
		$sql = "select * from v_inventario_p  ".$order_by;
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
	
	function Saldo_Apertura_caja($idcaja){
		$stmt = $this->db->prepare("SELECT monto_a as apertura FROM caja where idcaja = :id");
		$stmt->bindValue(':id', $idcaja , PDO::PARAM_INT);
		$stmt->execute();
		$max=$stmt->fetchObject();
		return $max->apertura;
	}
	
	//v.estado = 1  v.tipo_venta = 1 => cuando es venta al contado 
	//v.estado = 2  v.tipo_venta = 2 => cuando es venta al x pagar 
	function data_venta_c($idcaja){
		 $stmt2 = $this->db->prepare("SELECT * FROM v_reporte_ventas WHERE idcaja = :id order by fecha_venta");
		 $stmt2->bindValue(':id', $idcaja , PDO::PARAM_INT);
		 $stmt2->execute();
         $caja=$stmt2->fetchAll();
         return $caja;
	}
	
	function data_venta_margenbruto($idcaja){
		 $stmt2 = $this->db->prepare("SELECT * FROM v_margenbruto WHERE idcaja = :id order by fecha asc");
		 $stmt2->bindValue(':id', $idcaja , PDO::PARAM_INT);
		 $stmt2->execute();
         $caja=$stmt2->fetchAll();
         return $caja;
	}

	
	function data_venta_xc(){
		 $stmt2 = $this->db->prepare("select * from v_ventaxcobrar order by id desc");
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

	function reporte_compras($desde, $hasta){
		$stmt2 = $this->db->prepare("SELECT * FROM v_reporte_compras WHERE fecha between :desde and :hasta order by fecha asc");
		$stmt2->bindValue(':desde', $desde , PDO::PARAM_INT);
		$stmt2->bindValue(':hasta', $hasta , PDO::PARAM_INT);
		$stmt2->execute();
        $compras=$stmt2->fetchAll();
        return $compras;
	}
	

}
?>