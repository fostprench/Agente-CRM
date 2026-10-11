
<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/User.php';
require_once 'model/Grid.php';

class UserController extends Controller 
{
	public static function login()
	{
		$objeto = new  User();
        if ($_SERVER['REQUEST_METHOD']=='POST'){
			
			$_p = $objeto->Start();
			$obj = $_p['obj'];
			$login = $_POST['login'];
			$pass = $_POST['clave'];
			
			if ( strcasecmp($obj->user,$login)==0 && strcasecmp($obj->clave,$pass)==0) 
			{
				$empresa = $objeto->datos_empresa();
				$_SESSION['empresa']=$empresa->nombre;
				$_SESSION['siglas']=$empresa->siglas;
				$_SESSION['ruc']=$empresa->ruc;
				$_SESSION['direccion']=$empresa->direccion;
				$_SESSION['descripcion']=$empresa->descripcion;
				$_SESSION['telefono']=$empresa->telefono;
				$_SESSION['propietario']=$empresa->nombre;
				$_SESSION['logo']=$empresa->logo;
				$_SESSION['sitio_web']=$empresa->sitio_web;				
				$_SESSION['usuario']=$obj->usuario;
				$_SESSION['id_perfil']=$obj->id_perfil;
				$_SESSION['foto']=$obj->foto;
				
				if((strcmp($obj->perfil, 'GERENTE') == 0) ||  (strcmp($obj->perfil, 'ADMINISTRADOR') == 0) || (strcmp($obj->perfil, 'ADMIN') == 0) ){
				$_SESSION['perfil']= 'su';
				}else{
				$_SESSION['perfil']=$obj->perfil;
				}
				
				$_SESSION['id_usuario']=$obj->id_usuario;
				$_SESSION['user']=$obj->user;
				print_r(json_encode(array("rep"=>"1","msg"=>"Ok")));
			
			}else{
			   print_r(json_encode(array("rep"=>"0","msg"=>"Usuario o Clave incorrectos")));
			}
        } 
		else
        {
		   print_r(json_encode(array("rep"=>"0","msg"=>"Usuario o Clave incorrectos ")));
        }
    }

    public static function logout()
	{
        session_destroy();
		echo"<script>window.location='home.php';</script>";
        //header('Location: login.php');
    }
    public function Index()
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new User();
        $data = array();
	    $grilla= new  Grilla();
	    $cabecera=$obj->getHead('v_usuario');
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_usuario",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=User&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
	    $obj->session(23);
	    $titulo='Usuarios Registrados';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],true);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }
	 public function search()
    {
	   $obj = new User();
	   $columnas=$obj->getHead('v_usuario');
       $data = array();
       $view = new View();
       $data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_usuario");
       $data['num']=$columnas;
       $view->setData( $data );
       $view->setTemplate( 'view/_Json.php' );
       echo $view->renderPartial();
    }
	
	public function Panel()
	{
	  $obj = new User();
	  $data=array();
	  $data['obj']=$obj->show($_SESSION['id_usuario']);
	  $data['url']="view/fotos_user/";
	  $data['id']=$_SESSION['id_usuario'];
	  $view = new View();
	  $view->setData($data);
	  $view->setTemplate('view/user/_panel.php');
	  echo $view->renderPartial();
	}
	/*funcion k te muestra el formulario de cambio de password*/
	public function change_password()
	{
	  $view = new View();
	  $view->setTemplate('view/user/_password.php');
	  echo $view->renderPartial();
	}
	
	/*mustra el formulario de actualizacion de foto*/
	public function photo()
	{
	  $obj = new User();
	  $data=array();
	  $data['obj']=$obj->show($_SESSION['id_usuario']);
	  $view = new View();
	  $view->setData($data);
	  $view->setTemplate('view/user/_foto.php');
	  echo $view->renderPartial();
	}
	
	public function create()
	{
		if($_SESSION['insertar']==1)
		{
			$data=array();
			$data['perfil']=$this->Select(array('id'=>'idperfil','name'=>'idperfil','table'=>'perfil','code'=>'0'));
			$data['sucursal']=$this->Select(array('id'=>'idsucursal','name'=>'idsucursal','table'=>'sucursal','code'=>'0'));
			$data['p']=1;
			$data['titulo']="REGISTRAR USUARIO";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/user/_frm.php');
			echo $view->renderPartial();
		}
		else
		{
			echo "<script>alert('no tiene permiso para insertar');
			window.location='index.php?controller=User';</script>";
		}
	}
	public function _edit() 
	{
	   if($_SESSION['editar']==1)
	   {
	      $obj = new User();
          $data=array();
		  $obj=$obj->show($_GET['id']);
		  $data['obj']=$obj;
		   $data['p']=2;
		   $data['titulo']="EDITAR USUARIO";
		  $data['perfil']=$this->Select(array('id'=>'idperfil','name'=>'idperfil','table'=>'perfil','code'=>$obj->perfil));
		  $data['sucursal']=$this->Select(array('id'=>'idsucursal','name'=>'idsucursal','table'=>'sucursal','code'=>$obj->idsucursal));
		  $view = new View();
	      $view->setData($data);
          $view->setTemplate('view/user/_frm.php');
        echo $view->renderPartial();
		}else
		{
		echo 
		"<script>alert('no tiene permiso para editar');
	     window.location='index.php?controller=User';</script>";
		}
	
	}
	
	public function UpdateFoto($foto)
	{
		$obj = new User();
		echo $obj->ActualizaUserFoto($_SESSION['id_usuario'],$foto);
	}
	
	public function validar()
	
	{
		$obj = new User();
		print_r(json_encode($obj->validar($_GET['U'])));
	}
	
	public function save()
	{
		$obj = new User();
		print_r(json_encode($obj->newUser($_POST)));
	}
	
	public function validar_pass()
	{
	    $obj = new User();
		print_r(json_encode($obj->Validar_pass($_POST['pass'],$_SESSION['id_usuario'])));

	}
	public function change()
	{
	    $obj = new User();
		print_r(json_encode($obj->change($_POST['clave'],$_SESSION['id_usuario'])));
	}
	
	public function show()
	{
	    $obj = new User();
	    $data=array();
		$obj=$obj->show($_GET['id']);
		$data['obj']=$obj;
		$data['p']=3;
		$data['titulo']="USUARIO REGISTRADO";
		$data['perfil']=$this->Select(array('id'=>'idperfil','name'=>'idperfil','table'=>'perfil','code'=>$obj->perfil));
		  $data['sucursal']=$this->Select(array('id'=>'idsucursal','name'=>'idsucursal','table'=>'sucursal','code'=>$obj->idsucursal));
		$view = new View();
	    $view->setData($data);
	    $view->setTemplate('view/user/_frm.php');
        echo $view->renderPartial();
	}
	public function _delete()
    { if($_SESSION['delete']==1)
	  {
         $obj = new User();
         $c=$obj->deleteUser($_GET['id']);
	     if ($c){echo json_encode(array('rep'=>'1','msg'=>'ELIMINADO'));} 
		 else{echo json_encode(array('rep'=>'2','msg'=>'.::no se pudo eliminar::..'));}
		
	   }else
	   {
	   echo "<script>alert('no tiene permiso para eliminar');window.location='index.php';</script>";
	   }
    }
}
?>
