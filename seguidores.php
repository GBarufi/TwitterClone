<!DOCTYPE HTML>
<html lang="pt-br">

	<?php
		session_start();

		if (!isset($_SESSION['usuario'])) {
			header('Location: index.php?erro=1');
		}
	?>

	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	
		<script type="text/javascript">
			$(document).ready(function() {
				$.ajax({
					url: 'get_seguidores.php',
					success: function(data) {
						$('#seguidores').html(data);

						$('.btn-seguir').click(function() {
							var idUsuario = $(this).data('id_usuario'),
								usuario = $(this).data('usuario');

							$('#btn_seguir_' + idUsuario).hide();
							$('#btn_deixar_seguir_' + idUsuario).show();

							$.ajax({
								url: 'seguir.php',
								method: 'POST',
								data: { seguindo_id_usuario: idUsuario },
								success: function() {
									$('.alert-success').html('Você começou a seguir <strong>' + usuario + '</strong>');
									$('.alert-success').fadeIn("400");

									setTimeout(function () {
										$('.alert-success').fadeOut("400");
									}, 1500);
								}
							});
						});

						$('.btn-deixar-seguir').click(function() {
							var idUsuario = $(this).data('id_usuario'),
								usuario = $(this).data('usuario');

							$('#btn_deixar_seguir_' + idUsuario).hide();
							$('#btn_seguir_' + idUsuario).show();

							$.ajax({
								url: 'deixar_seguir.php',
								method: 'POST',
								data: { desfazer_seguindo_id_usuario: idUsuario },
								success: function() {
									$('.alert-danger').html('Você deixou de seguir <strong>' + usuario + '</strong>');
									$('.alert-danger').fadeIn("400");

									setTimeout(function () {
										$('.alert-danger').fadeOut("400");
									}, 1500);
								}
							});
						});
					}
				});
			});

			function atualizaQtdeTweets() {
				$.ajax({
					url: 'get_qtde_tweets.php',
					success: function(data) {
						$('#qtde_tweets').html(data);
					}
				})
			}

			function atualizaQtdeSeguidores() {
				$.ajax({
					url: 'get_qtde_seguidores.php',
					success: function(data) {
						$('#qtde_seguidores').html(data);
					}
				})
			}

			atualizaQtdeTweets();
			atualizaQtdeSeguidores();
		</script>
	</head>

	<body>
		<center><p class="alert alert-success" style="display:none;position:fixed;right: 0;left: 0;z-index: 1030;"></p></center>
		<center><p class="alert alert-danger" style="display:none;position:fixed;right: 0;left: 0;z-index: 1030;"></p></center>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
				    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					    <span class="sr-only">Toggle navigation</span>
					    <span class="icon-bar"></span>
					    <span class="icon-bar"></span>
					    <span class="icon-bar"></span>
				    </button>
				    <a href="home.php"><img src="imagens/icone_twitter.png" /></a>
				</div>

				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="home.php">Home</a></li>
				    	<li><a href="sair.php">Sair</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
	    </nav>


	    <div class="container">
	    	<div class="col-md-3">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<h4><?= $_SESSION['usuario'] ?></h4>
	    				<hr>
	    				<div class="col-md-6">
	    					<a href="home.php">Tweets</a> <br> <span id="qtde_tweets"></span>
	    				</div>
	    				<div class="col-md-6">
	    					<a href="#">Seguidores</a> <br> <span id="qtde_seguidores"></span>
	    				</div>
	    			</div>
	    		</div>
	    	</div>

	    	<div class="col-md-6">
	    		<div id="seguidores" class="list-group"></div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><a href="procurar_pessoas.php">Procurar por pessoas</a></h4>
					</div>
				</div>
			</div>
		</div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>