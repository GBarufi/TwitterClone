<?php
	session_start();

	if (!isset($_SESSION['id_usuario'])) {
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$idUsuario = $_SESSION['id_usuario'];

	if (isset($_POST['usuario'])) {
		$usuario = $_POST['usuario'];
		$sql = "SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores ";
		$sql.= "WHERE seguindo_id_usuario = (SELECT id FROM usuarios WHERE LOWER(usuario) = LOWER('$usuario'))";
	} else {
		$sql = "SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $idUsuario";
	}

	$resultado_id = mysqli_query($link, $sql);

	if ($resultado_id) {
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtdeSeguidores = $registro['qtde_seguidores'];
		
		echo $qtdeSeguidores;
	} else {
		echo "Erro ao recuperar quantidade de seguidores";
	}
?>