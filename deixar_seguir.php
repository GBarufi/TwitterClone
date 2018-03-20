<?php
	session_start();

	if (!isset($_SESSION['usuario'])) {
		header('Location: index.php?erro=1');
	}

 	require_once('db.class.php');

 	$idUsuario = $_SESSION['id_usuario'];
 	$desfazerSeguindoIdUsuario = $_POST['desfazer_seguindo_id_usuario'];


 	if ($idUsuario == '' || $desfazerSeguindoIdUsuario == '') {
 		die();
 	}

 	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "DELETE FROM usuarios_seguidores WHERE id_usuario = $idUsuario AND seguindo_id_usuario = $desfazerSeguindoIdUsuario";

	mysqli_query($link, $sql);
?>