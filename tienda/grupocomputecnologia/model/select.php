<?php
include_once("../lib/PGSQL_spdo.php ");

$id = $_GET['id'];
$name = $_GET['name'];

$sql = "SELECT  mo.idmodelo,mo.descripcion
		FROM marca as ma, modelo as mo
		WHERE ma.idmarca = mo.idmarca and ma.idmarca =".$id;

try{
$bd = new PGSQL_spdo();
 $data = $bd->query($sql);

		if(!empty($data)) {
		$select = "<select name='$name' id='$name'><option value=''>::Seleccione::</option>";
                    foreach ($data as $key=>$val) {
                        $select .= "<option value='$val[0]'>".$val[1]."</option>";
				}
			
		$select .= "</select>";
		echo $select;
		}
 
    }
    catch (PDOException $e)
    {
      echo $e;
    }


	
?>