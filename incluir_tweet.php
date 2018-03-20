<?php
	session_start();

	if (!isset($_SESSION['usuario'])) {
		header('Location: index.php?erro=1');
	}

 	require_once('db.class.php');

 	$idUsuario = $_SESSION['id_usuario'];
 	$textoTweet = $_POST['texto_tweet'];

 	if ($textoTweet == '' && $idUsuario == '') {
 		die();
 	}

 	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "INSERT INTO tweets(id_usuario, tweet) VALUES ($idUsuario, '$textoTweet')";

	mysqli_query($link, $sql);
?>