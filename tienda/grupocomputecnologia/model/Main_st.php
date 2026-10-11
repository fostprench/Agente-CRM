<?php
require_once 'lib/PGSQL_spdo.php';

class Main
{
    protected $db;
    public $rows = 10;
    protected $pag = 5;
    protected $exec;

    public function __construct()
    {
        $this->db = PGSQL_spdo::singleton();
        $this->exec = PGSQL_spdo::getExec();
    }
    public function getQuery($sql)
    {

        try {
            $bd = new PGSQL_spdo();
            //$bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
            $data = $bd->query($sql);
            $array = array();

            if (!empty($data)) {
                foreach ($data as $row) {
                    //echo $row;
                    $array[] = $row;
                }
            }

            //return $array;
        } catch (PDOException $e) {
            echo $e;
        }

    }
    public function max_id($tabla)
    {

        try {

            $data = $this->db->query("select max(id$tabla) from $tabla");

            $r = $data->fetchAll();
            return $r[0][0];
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public static function get_enviar($pa, $datos)
    {

        $bd = new PGSQL_spdo();
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
        return self::procedimientoAlmacenado($pa, $datos, $bd);
    }
    public function procedimientoAlmacenado($pa, $datos, $bd)
    {
        //convertimos a mayusculas los datos
        $search = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $replace = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
        foreach ($datos as $key => $value) {
            $datos[$key] = str_replace($search, $replace, strtoupper($value));
        }

        $driver = 'mysql';
        /* switch ($driver) {
             case 'mssql': $sql = "execute ";
                 break;
             case 'mysql': $sql = "call ";
                 break;
             case 'pgsql': $sql = "select * from ";
                 break;
             case 'oci': $sql = "execute ";
                 break;
         }*/
        $sql = "call ";
        $sql = $sql . $pa . " (";
        /* if ($driver != 'mssql') {
             $sql = $sql . "(";
         }*/

        if ($datos != null) {
            for ($i = 1; $i <= count($datos); $i++) {
                $sql = $sql . "?";
                if ($i < count($datos)) {
                    $sql = $sql . ",";
                } else {
                    if ($driver != 'mssql') {
                        $sql = $sql . ")";
                    }
                }
            }
        } else {
            if ($driver != 'mssql') {
                $sql = $sql . ")";
            }
        }
        //die($sql);
        try {

            if ($driver == 'mysql') {
                //die('jajaja');

                $stmt = $bd->prepare($sql, array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
            } else {
                $stmt = $bd->prepare($sql);
            }
            $j = 0;
            if ($datos != null) {
                for ($i = 0; $i < count($datos); $i++) {
                    $j++;
                    if (is_int($datos[$i])) {
                        $stmt->bindValue($j, $datos[$i], PDO::PARAM_INT);
                    }
                    if (is_string($datos[$i])) {
                        $stmt->bindValue($j, $datos[$i], PDO::PARAM_STR);
                    }
                    if (is_double($datos[$i])) {
                        $stmt->bindValue($j, $datos[$i], PDO::PARAM_INT);
                    }
                    if (is_null($datos[$i])) {
                        $stmt->bindValue($j, $datos[$i], PDO::PARAM_NULL);
                    }
                }
            }
            $stmt->execute();
            $error = $stmt->errorInfo();
            if ($driver == 'mssql') {
                if ($error[2] == '(null) [0] (severity 0) [(null)]') {
                    return array($stmt, '');
                } else {
                    $url = str_replace(' ', '_', $error[2]);
                    die("<script> window.location=\"" . BASE_URL . "error/error_bd/" . $url . "\" ; </script>");
                }
            } else {
                return array($stmt, $error[2]);
                //                if($error[2]!=''){
//                    return array($stmt, $error[2]);
//                }else{
//                    $url=str_replace(' ', '_', $error[2]);
//                    die("<script> window.location=\"".BASE_URL."error/error_bd/".$url."\" ; </script>");
//                }
            }

            //            return array($stmt,$error[2]);
//            return $stmt;
        } catch (PDOException $e) {
            return false;
            echo '<script>
                alert("Fallo ejecucion!: ' . $e->getMessage() . '");
                    window.location="index.php";
                </script>';
        } catch (Exception $ex) {
            return false;
            echo '<script>
                alert("Fallo ejecucion!: ' . $ex->getMessage() . '");
                    window.location="index.php";
                </script>';
        }
    }
    public function Query($partSQL)
    {
        return $this->exec . " " . $partSQL;
    }

    public function getList()
    {
        $sth = $this->db->prepare("SELECT * FROM {$this->table}");
        $sth->execute();
        return $sth->fetchAll();
    }
    public function getmodulo($modulo)
    {
        $sth = $this->db->prepare("select idmodulo from modulo where descripcion='" . $modulo . "'");
        $sth->execute();
        foreach ($sth->fetchAll() as $id) {
            $cod = $id[0];
        }
        return $cod;
    }

    public function session($ID)
    {
        $sql = "SELECT * FROM permiso WHERE perfil=" . $_SESSION['id_perfil'] . " and modulo='$ID'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $estado = $sth->fetchObject();
        $_SESSION['editar'] = $estado->editar;
        $_SESSION['delete'] = $estado->delet;
        $_SESSION['insertar'] = $estado->insertar;
        $_SESSION['acceder'] = $estado->acceder;
    }

    public function getHead($tabla)
    {
        $col = new PGSQL_spdo();
        $bd = $col->db();
        //$sql="SELECT COLUMN_NAME FROM information_schema.COLUMNS where table_catalog='$bd' and TABLE_NAME='$tabla'";
        $sql = "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '$bd'    AND TABLE_NAME = '$tabla' ";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $data = $sth->fetchAll();
        $fields = array();
        foreach ($data as $rows) {
            array_push($fields, $rows[0]);
        }
        return $fields;
    }
    /*funcion general para la busqueda ---tipo facebook*/
    public function Search_P($query, $condicion, $table)
    {
        $query = '%' . $query . '%';
        $sql = "select * from " . $table;
        $filtro = " where ";
        $i = 0;
        while ($i < count($condicion)) {
            if ($i == (count($condicion) - 1)) {
                $filtro .= " " . $condicion[$i] . "  like  '" . strtoupper($query) . "'   ";
            } else {
                $filtro .= " " . $condicion[$i] . "  like  '" . strtoupper($query) . "' or  ";
            }
            $i++;
        }
        $filtro .= " ";
        $sql .= $filtro . " ORDER BY " . $condicion[0] . " ASC";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
    /*---------------funcion index general---------------*/
    public function index_P($query, $p, $condicion, $table, $order)
    {
        $query = '%' . $query . '%';
        $sql = "select * from " . $table;
        $filtro = " where ";
        $i = 0;
        while ($i < count($condicion)) {
            if ($i == (count($condicion) - 1)) {
                $filtro .= " " . $condicion[$i] . "  like  '" . strtoupper($query) . "'   ";
            } else {
                $filtro .= " " . $condicion[$i] . "  like  '" . strtoupper($query) . "' or  ";
            }
            $i++;
        }
        $filtro .= " ";
        if ($order == "") {
            $sql .= $filtro . " ORDER BY opc, " . $condicion[0] . " DESC";
        } else {
            $sql .= $filtro . " ORDER BY opc, " . $order . " ASC";
        }

        $data['consulta'] = $sql;
        $data['total'] = $this->getTotal($filtro, $table);
        $data['rows'] = $this->getRow($sql, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);

        return $data;
        // return $sql;
    }

    /*---------------------*/
    public function getTotal($filtro, $table /*, $param */)
    {
        $sql = "select count(*) as total from " . $table . " " . $filtro;
        $statement = $this->db->prepare($sql);
        foreach ($param as $key => $value) {
            switch ($value['type']) {
                case 'STR':
                    $statement->bindParam($value['key'], $value['value'], PDO::PARAM_STR);
                    break;
                default:
                    $statement->bindParam($value['key'], $value['value'], PDO::PARAM_INT);
                    break;
            }
        }
        $statement->execute();
        $dato = $statement->fetchObject();
        return $dato->total;
    }

    public function getRow($sql /*, $param*/ , $p)
    {
        $p = $this->rows * ($p - 1);

        $sql = $sql . " LIMIT {$this->rows} OFFSET {$p} ";
        $statement = $this->db->prepare($sql);
        foreach ($param as $key => $value) {
            switch ($value['type']) {
                case 'STR':
                    $statement->bindParam($value['key'], $value['value'], PDO::PARAM_STR);
                    break;
                default:
                    $statement->bindParam($value['key'], $value['value'], PDO::PARAM_INT);
                    break;
            }
        }
        $statement->execute();
        return $statement->fetchAll();
    }
    public function getRowPag($total_rows, $vp)
    {
        $data = array();
        if (ceil($total_rows / $this->rows) <= $this->pag) {
            for ($x = 1; $x <= ceil($total_rows / $this->rows); $x++) {
                if ($x == $vp) {
                    $data[] = array('active' => 1, 'type' => 1, 'value' => $x);
                } else {
                    $data[] = array('active' => 0, 'type' => 1, 'next' => 0, 'value' => $x);
                }
            }
        } else {
            $flag = TRUE;
            if (ceil($total_rows / $this->rows) % $this->pag != 0) {
                for ($j = ceil($total_rows / $this->rows); $j >= $this->pag; $j--) {
                    if ($j % $this->pag == 0) {
                        if ($vp > $j) {
                            $flag = FALSE;
                            for ($x = $j + 1; $x <= ceil($total_rows / $this->rows); $x++) {
                                if ($x == $j + 1) {
                                    $data[] = array('active' => 0, 'type' => 2, 'value' => $x - 1);

                                }
                                if ($x == $vp) {
                                    $data[] = array('active' => 1, 'type' => 1, 'value' => $x);
                                } else {
                                    $data[] = array('active' => 0, 'type' => 1, 'value' => $x);
                                }
                            }
                            break;
                        } else {

                            break;
                        }
                    }
                }
                if ($flag) {
                    for ($x = $vp; $x <= ceil($total_rows / $this->rows); $x++) {
                        if (($x % $this->pag) == 0) {
                            if ($x - $this->pag <= 0) {
                                $z = 1;
                            } else {
                                $z = ($x - $this->pag) + 1;
                            }
                            for ($y = $z; $y <= ($x); $y++) {
                                if ($y > $this->pag && $y == $z) {
                                    $data[] = array('active' => 0, 'type' => 2, 'value' => $y - 1);
                                }
                                if ($y == $vp) {
                                    $data[] = array('active' => 1, 'type' => 1, 'value' => $y);
                                } else {
                                    $data[] = array('active' => 0, 'type' => 1, 'value' => $y);
                                }
                                if ($y == $x && $y != ceil($total_rows / $this->rows)) {
                                    $data[] = array('active' => 0, 'type' => 3, 'value' => $y + 1);
                                }
                            }
                            break;
                        }
                    }
                }

            } else {
                for ($x = $vp; $x <= ceil($total_rows / $this->rows); $x++) {
                    if (($x % $this->pag) == 0) {
                        if ($x - $this->pag <= 0) {
                            $z = 1;
                        } else {
                            $z = ($x - $this->pag) + 1;
                        }
                        for ($y = $z; $y <= ($x); $y++) {
                            if ($y > $this->pag && $y == $z) {
                                $data[] = array('active' => 0, 'type' => 2, 'value' => $y - 1);
                            }
                            if ($y == $vp) {
                                $data[] = array('active' => 1, 'type' => 1, 'value' => $y);
                            } else {
                                $data[] = array('active' => 0, 'type' => 1, 'value' => $y);
                            }
                            if ($y == $x && $y != ceil($total_rows / $this->rows)) {
                                $data[] = array('active' => 0, 'type' => 3, 'value' => $y + 1);
                            }
                        }
                        break;
                    }
                }
            }
        }
        return $data;
    }
    public function getnum()
    {
        return $this->rows;
    }
}
?>
