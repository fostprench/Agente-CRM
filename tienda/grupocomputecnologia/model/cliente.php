<?php
include_once("Main.php");
class cliente extends Main
{
	function newcliente($P)
    {
		if($P['oper']==1)
		{
            if($P['tipo_c']==1){
			$nombres = $P['nombres'];
			$ruc = $P['dni'];
			}
			if($P['tipo_c']==2){
			$nombres = $P['raz_social'];
			$ruc = $P['ruc'];
			}
			
			$stmt = $this->db->prepare("SELECT max(idcliente) as max FROM cliente");
			$stmt->execute();
			$res = $stmt->fetchObject();
			$idMax = $res->max; 
			$idMax = $idMax +1;
			$sql = "insert into cliente (idcliente, ubigeo, nombres,tipo_cliente,ruc,direccion,telefono,email,fecha,observaciones)
         			values (".$idMax.",'".$P['ubigeo']."','".$nombres."',".$P['tipo_c'].",'".$ruc."','".$P['direccion']."','".$P['telefono']."','".$P['email']."','".$P['fecha_']."','".$P['observaciones']."') ";
			$stmt2 = $this->db->prepare($sql);
            $stmt2->execute();
			$resp = array('rep'=>'1','str'=>'Okote');
			return $resp;
			
		}
		else
		{  
			if($P['tipo_c']==1){
			$nombres = $P['nombres'];
			$ruc = $P['dni'];
			}
			if($P['tipo_c']==2){
			$nombres = $P['raz_social'];
			$ruc = $P['ruc'];
			}
			
			$sql = "update  cliente set  ubigeo = '".$P['ubigeo']."', nombres = '".$nombres."',tipo_cliente = ".$P['tipo_c'].",ruc = '".$ruc."',direccion = '".$P['direccion']."',telefono = '".$P['telefono']."',email = '".$P['email']."',fecha = '".$P['fecha_']."',observaciones = '".$P['observaciones']."'
         			where idcliente=".$P['idcliente']."";
			$stmt2 = $this->db->prepare($sql);
            $stmt2->execute();
			$resp = array('rep'=>'1','str'=>'Ok');
			return $resp;
		}
	}

	function edit($id ) 
	{
	    $stmt = $this->db->prepare("SELECT * FROM cliente WHERE idcliente = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
		
    }
      
    function deletecliente($id)
    {     $stmt = $this->db->prepare("delete   FROM cliente WHERE idcliente = :id");
          $stmt->bindValue(':id', $id , PDO::PARAM_STR);
          $res=$stmt->execute();
        return $res;
    }
	
}
?>