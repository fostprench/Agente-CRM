<?php
include_once("Main.php");

class ProductosWeb extends Main
{
	function Tipo_producto($tipo) 
	{
	
		$sql_general = "SELECT p.idproducto as id, m.descripcion as marca, p.descripcion, p.foto, p.informacion, i.stock 
						FROM producto as p 
						INNER JOIN marca as m on (m.idmarca = p.idmarca)
						INNER JOIN inventario as i on (p.idproducto = i.idproducto)
						WHERE p.estado = 1 and p.web = 1 ";
						
		if($tipo == 'PCS'){	$union_sql = $sql_general." and p.idtipo = 1"; }
		if($tipo == 'AllInOne'){ $union_sql = $sql_general." and p.idtipo = 1"; }
		if($tipo == 'Laptos'){ $union_sql = $sql_general." and p.idtipo = 1 "; }
		if($tipo == 'Tablets'){ $union_sql = $sql_general." and p.idtipo = 4 "; }
		if($tipo == 'Impresoras'){ $union_sql = $sql_general." and p.idtipo = 26 "; }
		if($tipo == 'Accesorios'){ 
									$union_sql = $sql_general." and p.idtipo = 3 ";
									$union_sql .= " UNION ".$sql_general;
									$union_sql .= " and p.idtipo = 4 ";
									$union_sql .= " UNION ".$sql_general;
									$union_sql .= " and p.idtipo = 5 ";
									$union_sql .= " UNION ".$sql_general;
									$union_sql .= " and p.idtipo = 6 ";
									$union_sql .= " UNION ".$sql_general;
									$union_sql .= " and p.idtipo = 7 ";
									$union_sql .= " UNION ".$sql_general;
									$union_sql .= " and p.idtipo = 8 ";
									$union_sql .= " UNION ".$sql_general;
									$union_sql .= " and p.idtipo = 9 ";
									$union_sql .= " UNION ".$sql_general;
									$union_sql .= " and p.idtipo = 11 ";
									$union_sql .= " UNION ".$sql_general;
									$union_sql .= " and p.idtipo = 14 ";
									$union_sql .= " UNION ".$sql_general;
									$union_sql .= " and p.idtipo = 18 ";
									$union_sql .= " UNION ".$sql_general;
									$union_sql .= " and p.idtipo = 25 ";
		}
		$stmt = $this->db->prepare($union_sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
	
	function Info_producto($idX) 
	{
		$stmt = $this->db->prepare("SELECT p.idproducto as id, m.descripcion as marca, p.descripcion, p.foto, p.informacion, i.stock 
						FROM producto as p 
						INNER JOIN marca as m on (m.idmarca = p.idmarca)
						INNER JOIN inventario as i on (p.idproducto = i.idproducto)
						WHERE p.estado = 1 and p.web = 1 and p.idproducto = :id");
		$stmt->bindValue(':id', $idX , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

}
?>