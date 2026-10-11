<?php
include_once("Main.php");
class Perfil extends Main
{
  function newperfil($P)
    {
        if($P['oper']==1)
	   {    if(isset($P['estado']) && $P['estado']== "on"){$estado="1";}else{$estado="0";}
	           $sql =$this->Query("usp_perfil(1,:p2,0,:p3)");
               $stmt =$this->db->prepare($sql);
           try{
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $this->db->beginTransaction();
                $stmt->bindValue(':p2',$P['descripcion'], PDO::PARAM_INT);
                $stmt->bindValue(':p3',$estado, PDO::PARAM_INT);
                $stmt->execute();
                $this->db->commit();
                  $resp = array('rep'=>'1','str'=>'Ok');
                  return $resp;
        }
        catch(PDOException $e) {
            $this->db->rollBack();
            return array('res'=>"3",'msg'=>'no se pudo realizar la accion de insertar : '.$e->getMessage());
        }
		}else
		{  if(isset($P['estado']) && $P['estado']== "on"){$estado="1";}else{$estado="0";}
		    $sql =$this->Query("usp_perfil(2,:p2,:id,:p3)");//operador-desc-id-estado
               $stmt =$this->db->prepare($sql);
           try{
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $this->db->beginTransaction();
                 $stmt->bindValue(':p2',$P['descripcion'], PDO::PARAM_STR);
				 $stmt->bindValue(':id',$P['idperfil'], PDO::PARAM_INT);
                 $stmt->bindValue(':p3',$estado, PDO::PARAM_INT);
                 $stmt->execute();
                 $this->db->commit();
                  $resp = array('rep'=>'2','str'=>'Ok');
                  return $resp;
          }
          catch(PDOException $e) {
            $this->db->rollBack();
            return array('res'=>"4",'msg'=>'no se pudo realizar la accion de actualizar : '.$e->getMessage());
          }
		
		}
     }



   function edit($id ) {//Esta funcion es para actualizar en el formuladio de la tabla seleccionada
        $stmt = $this->db->prepare("SELECT * FROM perfil WHERE idperfil = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
      

    function deleteperfil($id)
    {
	     $stmt = $this->db->prepare("update perfil set estado = 0 where idperfil=:id");
          $stmt->bindValue(':id', $id , PDO::PARAM_STR);
          $res=$stmt->execute();
        return $res;
    }
}
?>