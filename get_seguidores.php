<?php
	session_start();
	require_once('db.class.php');

	$idUsuario = $_SESSION['id_usuario'];
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "SELECT u.*, us.* ";
	$sql.= "FROM usuarios AS u ";
	$sql.= "JOIN usuarios_seguidores AS us ";
	$sql.= "ON (u.id = us.id_usuario AND (us.seguindo_id_usuario = $idUsuario))";

	$sql = "SELECT u.*, us.*, IF((SELECT COUNT(*) FROM usuarios_seguidores ";
	$sql.=                        "WHERE id_usuario = $idUsuario AND seguindo_id_usuario = us.id_usuario), 'S','N') AS seguindo_tambem ";
	$sql.= "FROM usuarios AS u ";
	$sql.= "JOIN usuarios_seguidores AS us ";
	$sql.= "ON (u.id = us.id_usuario AND us.seguindo_id_usuario = $idUsuario)";

	$resultado_id = mysqli_query($link, $sql);

	if ($resultado_id) {
		while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) {
			echo '<div class="list-group-item">';
				echo '<a href="profile.php?usuario='.$registro['usuario'].'" style="color:black;text-decoration:none"><strong>'.$registro['usuario'].'</strong></a><small> - '.$registro['email'].'</small>';
				echo '<p class="list-group-item-text pull-right">';
					$estaSeguindoUsuarioSn = $registro['seguindo_tambem'];
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