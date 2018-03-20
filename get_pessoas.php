<?php
	session_start();

	if (!isset($_SESSION['usuario'])) {
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');

	$nome_pessoa = $_POST['nome_pessoa'];
 	$idUsuario = $_SESSION['id_usuario'];

 	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "SELECT u.*, us.* ";
	$sql.= "FROM usuarios AS u ";
	$sql.= "LEFT JOIN usuarios_seguidores AS us ";
	$sql.= "ON (us.id_usuario = $idUsuario AND u.id = us.seguindo_id_usuario) ";
	$sql.= "WHERE u.usuario LIKE '%$nome_pessoa%' AND u.id <> $idUsuario";

	$resultado_id = mysqli_query($link, $sql);

	if ($resultado_id) {
		while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) {
			echo '<div class="list-group-item">';
				echo '<a href="profile.php?usuario='.$registro['usuario'].'" style="color:black;text-decoration:none"><strong>'.$registro['usuario'].'</strong></a><small> - '.$registro['email'].'</small>';
				echo '<p class="list-group-item-text pull-right">';
					$estaSeguindoUsuarioSn = isset($registro['id_usuario_seguidor']) && !empty($registro['id_usuario_seguidor']) ? 'S' : 'N';
					$btnSeguirDisplay = 'block';
					$btnDeixarSeguirDisplay = 'block';

					if ($estaSeguindoUsuarioSn == 'S') {
						$btnSeguirDisplay = 'none';
					} else {
						$btnDeixarSeguirDisplay = 'none';
					}

					echo '<button type="button" id="btn_seguir_'.$registro['id'].'" class="btn btn-primary btn-seguir" style="display:'.$btnSeguirDisplay.'" data-id_usuario="'.$registro['id'].'" data-usuario="'.$registro['usuario'].'">Seguir</button>';
					echo '<button type="button" id="btn_deixar_seguir_'.$registro['id'].'" class="btn btn-default btn-deixar-seguir" style="display:'.$btnDeixarSeguirDisplay.'" data-id_usuario="'.$registro['id'].'" data-usuario="'.$registro['usuario'].'">Deixar de seguir</button>';
				echo '</p>';
				echo '<div class="clearfix"></div>';
			echo '</div>';
		}
	} else {
		echo 'Erro na consulta de usuários';
	}
?>