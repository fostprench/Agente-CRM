<?php
include_once("Main.php");
class concepto extends Main
{
	function newtipo ($P)
    {
		if($P['oper']==1)
		{    
			$sql =$this->Query("sp_concepto(1,0,:p2,:p3,1)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
                $stmt->bindValue(':p2',$P['cuenta'], PDO::PARAM_STR);
                $stmt->bindValue(':p3',$P['descripcion'], PDO::PARAM_STR);
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
			$sql =$this->Query("sp_concepto(2,:id,:p2,:p3,1)");
			$stmt =$this->db->prepare($sql);
			try
			{
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->beginTransaction();
				$stmt->bindValue(':id',$P['idconcepto'], PDO::PARAM_INT);
				$stmt->bindValue(':p2',$P['cuenta'], PDO::PARAM_INT);
				$stmt->bindValue(':p3',$P['descripcion'], PDO::PARAM_STR);
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

	function edit($id ) 
	{
        $stmt = $this->db->prepare("SELECT * FROM concepto WHERE idconcepto = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
      

    function delete_concepto ($id)
    {
	     $stmt = $this->db->prepare("delete   FROM concepto WHERE idconcepto = :id");
          $stmt->bindValue(':id', $id , PDO::PARAM_STR);
          $res=$stmt->execute();
        return $res;
    }
}
?>