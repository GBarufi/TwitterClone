<?php
	require_once('db.class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$idTweet = $_POST['id_tweet'];

	$sql = "DELETE FROM tweets WHERE id_tweet = $idTweet";
	//echo $sql;

	if (!mysqli_query($link, $sql)) {
		echo 'Erro ao remover o tweet.';
	}
?>