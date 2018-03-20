<!DOCTYPE HTML>
<html lang="pt-br">

	<?php
		session_start();

		if (!isset($_SESSION['usuario'])) {
			header('Location: index.php?erro=1');
		}

		if (isset($_GET['usuario'])) {
			$usuarioProfile =  $_GET['usuario'];
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
					url: 'get_pessoas.php',
					method: 'POST',
					data: { nome_pessoa: "<?= $usuarioProfile ?>" },
					success: function(data) {
						if (data.trim()) {
							$.ajax({
								url: 'get_tweet.php',
								method: 'GET',
								data: { usuario: "<?= $usuarioProfile ?>" },
								success: function(data) {
									$('#tweets').html(data);
								}
							});
						} else {
							window.location.href = 'http://localhost/twitter_clone/home.php';
						}
					}
				});

				function atualizaQtdeTweets() {
					$.ajax({
						url: 'get_qtde_tweets.php',
						method: 'POST',
						data: { usuario: "<?= $usuarioProfile ?>" },
						success: function(data) {
							$('#qtde_tweets').html(data);
						}
					});
				}

				function atualizaQtdeSeguidores() {
					$.ajax({
						url: 'get_qtde_seguidores.php',
						method: 'POST',
						data: { usuario: "<?= $usuarioProfile ?>" },
						success: function(data) {
							$('#qtde_seguidores').html(data);
						}
					});
				}
				atualizaQtdeTweets();
				atualizaQtdeSeguidores();
			});
		</script>
	</head>

	<body>

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
	    				<h4><?= $_GET['usuario'] ?></h4>
	    				<hr>
	    				<div class="col-md-6">
	    					Tweets <br> <span id="qtde_tweets"></span>
	    				</div>
	    				<div class="col-md-6">
	    					Seguidores <br> <span id="qtde_seguidores"></span>
	    				</div>
	    			</div>
	    		</div>
	    	</div>

	    	<div class="col-md-6">
	    		<div id="tweets" class="list-group"></div>
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