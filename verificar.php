<?php 
	if( (isset($_REQUEST["txtUser"])) && (isset($_REQUEST["txtPss"])) ){
		if( ( trim($_REQUEST["txtUser"])!='') && ( trim($_REQUEST["txtUser"])!='')){
			//Verificar inicio
			if( ($_REQUEST["txtUser"]=='admin') && ($_REQUEST["txtPss"]=='admin') ){
				session_start();
				$_SESSION['idUsuario'] = 7;
				$_SESSION['user'] = 'admin';
				$_SESSION['nbUsuario'] = 'Administrador';
				header('Location: index.php');
			}else{
				header('Location: login.php');
			}
		}else{
			header('Location: login.php');
		}
	}else{
		header('Location: login.php');
	}
?>