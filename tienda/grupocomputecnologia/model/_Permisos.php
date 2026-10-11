<?php
include_once("Main.php");
class _Permisos extends Main
{
   function index($query , $p ) {
        $sql = "select * from boletin  where titulo ilike :query";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }

    function Modulos($p)
    {
        $stmt = $this->db->prepare("
		select m.idmodulo,m.descripcion,p.acceder,p.insertar,p.editar,p.delet,c.descripcion,p.idpermiso
FROM
permiso as p
right outer join perfil as c ON  p.perfil = c.idperfil
right outer join modulo as m on p.modulo=m.idmodulo and c.idperfil=:p1 WHERE m.submodulo is null and m.estado=1
");
        $stmt->bindValue(':p1', $p , PDO::PARAM_INT);
        $stmt->execute();        
        $items = $stmt->fetchAll();
        $cont = 0; 
        $cont2 = 0;
        foreach ($items as $valor)
        {
            $stmt = $this->db->prepare("
			select m.idmodulo,m.descripcion,p.acceder,p.insertar,p.editar,p.delet,c.descripcion,p.idpermiso
FROM
permiso as p
right outer join perfil as c ON  p .perfil = c.idperfil
right outer join modulo as m on p.modulo=m.idmodulo and c.idperfil=:p1 WHERE m.submodulo=:p2 and m.estado=1
               
                 ");
            $stmt->bindValue(':p1', $p , PDO::PARAM_INT);
            $stmt->bindValue(':p2', $valor[0] , PDO::PARAM_INT);
            $stmt->execute();
            $hijos = $stmt->fetchAll();
            $menu[$cont] = array(
			'idmodulo' => $valor[0],
			'descripcion' => $valor[1],
		    'acceder' => $valor[2],
		    'insertar' => $valor[3],
		    'modificar' => $valor[4],
		    'eliminar' => $valor[5],
            'cargo' => $valor[6],
            'idpermiso' => $valor[7],
            
            
            'hijos' => array()
                );
            $cont2 = 0;
            foreach($hijos as $h)
            {
              $menu[$cont]['hijos'][$cont2] = array(
			  'idmodulo' => $h[0],
			  'descripcion' => $h[1],
			  'acceder' => $h[2],
		      'insertar' => $h[3],
		      'modificar' => $h[4],
		      'eliminar' => $h[5],
			  'cargo'=>$h[6],
			  'idpermiso'=>$h[7],
			  
			  );
              $cont2 ++;
            }
            $cont ++;
        }
        return $menu;
    }
	
	

	public function _Save($G)
	{ 
	   $stmt1 = $this->db->prepare("DELETE FROM permiso where perfil = :q1");
	   $stmt2 = $this->db->prepare("SELECT max(idpermiso) as max FROM permiso");
	   $sql =$this->Query("sp_permiso(:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
	   $stmt= $this->db->prepare($sql) ;
	        try
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
			
			$stmt1->bindValue(':q1',$G['id_perfil'] , PDO::PARAM_INT);
			$stmt1->execute();
			
			$id=$G['id_perfil'];
		
		    $stmt2->execute();
			$idMax=$stmt2->fetchObject();
			$Max = $idMax->max;
					
					
           foreach ($G['codigo'] as $key => $value)
            {
			    $Max++;

		        if ($G['acceder'][$key]=='on'){$acceder=1;}else{$acceder=0;}
			    if ($G['insertar'][$key]=='on'){$insertar=1;}else{$insertar=0;}
                if ($G['modificar'][$key]=='on'){$modificar=1;}else{$modificar=0;}
                if ($G['eliminar'][$key]=='on'){$eliminar=1;}else{$eliminar=0;}
		
                $stmt->bindValue(':p1',$id, PDO::PARAM_INT);
				$stmt->bindValue(':p2',$value, PDO::PARAM_INT);
                $stmt->bindValue(':p3',$modificar, PDO::PARAM_INT);
                $stmt->bindValue(':p4',$eliminar, PDO::PARAM_INT);
                $stmt->bindValue(':p5',$insertar, PDO::PARAM_INT);
                $stmt->bindValue(':p6',$acceder, PDO::PARAM_INT);
                $stmt->bindValue(':p7',$Max, PDO::PARAM_INT);
            
                $stmt->execute();
				
				
             }
            $this->db->commit();
            return array('res'=>"1",'msg'=>'Sus Cambios fueron guardados Correctamente!');
        
        }
        catch(PDOException $e)
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'No se pudo realizar la accion de insertar : '.$e->getMessage());
        }
	}

    
}
?>