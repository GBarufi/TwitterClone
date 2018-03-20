<?php
	session_start();

	if (!isset($_SESSION['usuario'])) {
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	if (isset($_GET['usuario'])) {
		$idUsuarioProfile = $_GET['usuario'];

		$sql = 'SELECT id FROM usuarios WHERE LOWER(usuario) = LOWER("'.$_GET['usuario'].'")';

		$resultado_id = mysqli_query($link, $sql);
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);

		$idUsuario = $registro['id'];
	} else {
 		$idUsuario = $_SESSION['id_usuario'];
 	}

	$sql = "SELECT tw.id_tweet, tw.id_usuario, usu.usuario, tw.tweet, DATE_FORMAT(tw.data_inclusao, '%d %b %Y %H:%i') AS data_inclusao ";
	$sql.= "FROM tweets AS tw JOIN usuarios AS usu ON (tw.id_usuario = usu.id) ";
	$sql.= "WHERE id_usuario = $idUsuario ";

	if (!isset($_GET['usuario'])) {
		$sql.= "OR id_usuario IN (SELECT seguindo_id_usuario FROM usuarios_seguidores WHERE id_usuario = $idUsuario) ";
	}

	$sql.= "ORDER BY data_inclusao DESC";

	$resultado_id = mysqli_query($link, $sql);

	if ($resultado_id) {
		while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) {
			$idTweet = $registro['id_tweet'];
			$textoTweet = $registro['tweet'];

			if ($registro['id_usuario'] == $_SESSION['id_usuario']) {
				echo '<a href="#" class="list-group-item">';

					echo '<button type="button" data-id_tweet="'.$idTweet.'" data-texto_tweet="'.$textoTweet.'" class="close remover-tweet" aria-label="Close" data-toggle="modal" data-target="#modalRemocaoTweet">';
					  echo '<span aria-hidden="true">&times;</span>';
					echo '</button>';

					echo '<h4 class="list-group-item-heading">'.$registro['usuario'].' <small> - '.$registro['data_inclusao'].'</small></h4>';
					echo '<p class="list-group-item-text">'.$registro['tweet'].'</p>';
				echo '</a>';
			} else if (isset($_GET['usuario']) && $registro['usuario'] == $_GET['usuario']) {
				echo '<a href="#" class="list-group-item">';
					echo '<h4 class="list-group-item-heading">'.$registro['usuario'].' <small> - '.$registro['data_inclusao'].'</small></h4>';	
					echo '<p class="list-group-item-text">'.$registro['tweet'].'</p>';
				echo '</a>';
			} else {
				echo '<div class="list-group-item">';
					echo '<a href="profile.php?usuario='.$registro['usuario'].'" style="color:black;text-decoration:none"><h4 style="display:inline">'.$registro['usuario'].'</h4></a><small> - '.$registro['data_inclusao'].'</small>';
					echo '<p class="list-group-item-text">'.$registro['tweet'].'</p>';
				echo '</div>';
			}	
		}
	} else {
		echo 'Erro na consulta de tweets';
	}
?>