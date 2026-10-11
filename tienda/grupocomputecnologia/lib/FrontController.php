<?php
class FrontController
{
	public static function Main()
	{
		if (!isset($_SESSION['usuario'])) {
			$_SESSION['usuario'] = null;
		}

		$controllerDir = "controller/";

		// CORRECCIÓN: Inicializar variables y usar operador ??
		$controller = '';
		$action = '';

		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				$controller = $_GET['controller'] ?? '';
				$action = $_GET['action'] ?? '';
				break;
			case 'POST':
				$controller = $_POST['controller'] ?? '';
				$action = $_POST['action'] ?? '';
				break;
			default:
				$controller = '';
				$action = '';
				break;
		}

		if (empty($controller)) {
			$controller = "Index";
		}
		if (empty($action)) {
			$action = "Index";
		}

		// Validación de sesión mejorada
		$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

		if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
			if (!$isAjax) {
				header('Location: home.php');
				exit(); // Agregado: Terminar ejecución después de redirección
			} else {
				header('HTTP/1.0 499 Not Authorized');
				die('Not Authorized');
			}
		}

		// Concatenar la dirección con el controlador
		$controllerFile = $controllerDir . $controller . "Controller.php";

		if (!file_exists($controllerFile)) {
			die("No se encontro el archivo especificado: $controllerFile");
		}

		require_once $controllerFile;

		$controllerClass = $controller . "Controller";

		if (!class_exists($controllerClass, false)) {
			die("El controlador fue cargado pero no se encontro la clase: $controllerClass");
		}

		$controllerInst = new $controllerClass();

		if (!is_callable(array($controllerInst, $action))) {
			die("El controlador no tiene definida la accion: $action");
		} else {
			$controllerInst->$action();
		}
	}
}
?>