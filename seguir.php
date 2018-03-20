<?php
	session_start();

	if (!isset($_SESSION['usuario'])) {
		header('Location: index.php?erro=1');
	}

 	require_once('db.class.php');

 	$idUsuario = $_SESSION['id_usuario'];
 	$seguindoIdUsuario = $_POST['seguindo_id_usuario'];

 	if ($idUsuario == '' || $seguindoIdUsuario == '') {
 		die();
 	}

 	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "INSERT INTO usuarios_seguidores(id_usuario, seguindo_id_usuario) VALUES ($idUsuario, $seguindoIdUsuario)";

	mysqli_query($link, $sql);
?>