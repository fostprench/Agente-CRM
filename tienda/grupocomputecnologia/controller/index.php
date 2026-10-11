<?php

	if (!isset($_SESSION['usuario']) && empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') 
			{
				
				//header('Location: ../login.php');
				echo"<script>window.location='../login.php';</script>";
				
            }
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && !isset ($_SESSION['usuario'])   ) 
			{
				header('NOT_AUTHORIZED: 499');
				die();
            }
?>