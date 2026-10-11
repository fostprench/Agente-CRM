<?php
include_once("Main.php");
class Index extends Main{
    public function error_1()
    {
		$stmt = $this->db->prepare("SELECT max(idcaja) as max FROM caja");
		$stmt->execute();
        $max=$stmt->fetchObject();
		$id = $max->max;
		
		$stmt2 = $this->db->prepare("SELECT fecha_a FROM caja where idcaja = :id and estado = 1");
		$stmt2->bindValue(':id', $id , PDO::PARAM_INT);
        $stmt2->execute();
        $dato=$stmt2->fetchObject();
		return $dato;
    }    
}
?>
