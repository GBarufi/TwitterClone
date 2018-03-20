<?php
	session_start();

	require_once('db.class.php');

	$usuario = $_POST['usuario'];
	$email = $_POST['email'];
	$senha = md5($_POST['senha']);

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$usuarioJaExistente = false;
	$emailJaExistente = false;

	$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";

	if ($resultado_id = mysqli_query($link, $sql)) {
		$dados_usuario = mysqli_fetch_array($resultado_id);
		
		if (isset($dados_usuario['usuario'])) {
			$usuarioJaExistente = true;
		}

	} else {
		echo 'Erro ao tentar localizar registro de usuário.';
	}

	$sql = "SELECT * FROM usuarios WHERE email = '$email'";

	if ($resultado_id = mysqli_query($link, $sql)) {
		$dados_usuario = mysqli_fetch_array($resultado_id);
		
		if (isset($dados_usuario['email'])) {
			$emailJaExistente = true;
		}

	} else {
		echo 'Erro ao tentar localizar registro de email.';
	}

	if ($usuarioJaExistente || $emailJaExistente) {
		$retorno_get = '';

		if ($usuarioJaExistente) {
			$retorno_get.= 'erro_usuario=1';
		}

		if ($emailJaExistente) {
			$retorno_get.= $usuarioJaExistente ? '&erro_email=1' : 'erro_email=1';
		}

		header("Location: inscrevase.php?$retorno_get");
		die();
	}

	$sql = "INSERT INTO usuarios(usuario, email, senha) VALUES ('$usuario', '$email', '$senha')";

	if (mysqli_query($link, $sql)) {
		$sql = "SELECT * FROM usuarios WHERE id = (SELECT MAX(id) FROM usuarios)";

		if ($resultado_id = mysqli_query($link, $sql)) {
			$dados_usuario = mysqli_fetch_array($resultado_id);
			
			$_SESSION['id_usuario'] = $dados_usuario['id'];
			$_SESSION['usuario'] = $dados_usuario['usuario'];
			$_SESSION['email'] = $dados_usuario['email'];

			header("Location: home.php");
		}
	} else {
		echo 'Erro ao registrar usuário';
	}
?>