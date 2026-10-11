<?php
include_once("Main.php");
class modelo extends Main
{
	function newmodelo($P)
    {
		if($P['oper']==1)
		{    
			$sql =$this->Query("usp_modelo(1,:p1,0,p2)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':p1',$P['idmarca'], PDO::PARAM_STR);
                $stmt->bindValue(':p2',$P['descripcion'], PDO::PARAM_STR);
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
			$sql =$this->Query("usp_modelo(2,:p1,:id,:p2)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				$stmt->bindValue(':p1',$P['idmarca'], PDO::PARAM_STR);
				$stmt->bindValue(':id',$P['idmodelo'], PDO::PARAM_INT);
				$stmt->bindValue(':p2',$P['descripcion'], PDO::PARAM_INT);
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

	function edit($id ) //Esta funcion es para actualizar en el formulario de la tabla seleccionada
	{
        $stmt = $this->db->prepare("SELECT * FROM modelo WHERE idmodelo = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
      

    function deletemodelo($id)
    {
	     $stmt = $this->db->prepare("delete FROM modelo WHERE idmodelo=:id");
          $stmt->bindValue(':id', $id , PDO::PARAM_STR);
          $res=$stmt->execute();
        return $res;
    }
}
?>