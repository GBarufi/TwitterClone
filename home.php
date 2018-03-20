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
				$('#btn_tweet').click(function() {
					var textoTweet = $('#texto_tweet').val();

					if (textoTweet.length > 0) {	
						$.ajax({
							url: 'incluir_tweet.php',
							method: 'POST',
							data: { texto_tweet: textoTweet },
							success: function(data) {
								$('#texto_tweet').val('');
								atualizaTweets();
								atualizaQtdeTweets();
							}
						});
					}
				});

				function atualizaTweets() {
					$.ajax({
						url: 'get_tweet.php',
						success: function(data) {
							$('#tweets').html(data);

							$('.remover-tweet').click(function() {
								var idTweet = $(this).data('id_tweet'),
									textoTweet = $(this).data('texto_tweet');

								$('#id_tweet').html(idTweet);
								$('#conteudo_tweet').html(textoTweet);
							});

							$('#btn-remover-tweet').click(function() {
								var idTweet = $('#id_tweet').html();

								$.ajax({
									url: 'remover_tweet.php',
									method: 'POST',
									data: { id_tweet: idTweet },
									success: function(data) {
										atualizaTweets();
										atualizaQtdeTweets();
										$('#modalRemocaoTweet').modal('hide');
									}
								})
							});
						}
					});
				}

				function atualizaQtdeTweets() {
					$.ajax({
						url: 'get_qtde_tweets.php',
						success: function(data) {
							$('#qtde_tweets').html(data);
						}
					});
				}

				function atualizaQtdeSeguidores() {
					$.ajax({
						url: 'get_qtde_seguidores.php',
						success: function(data) {
							$('#qtde_seguidores').html(data);
						}
					});
				}

				atualizaTweets();
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
				    <a href="#"><img src="imagens/icone_twitter.png" /></a>
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
	    					<a href="#">Tweets</a> <br> <span id="qtde_tweets"></span>
	    				</div>
	    				<div class="col-md-6">
	    					<a href="seguidores.php">Seguidores</a> <br> <span id="qtde_seguidores"></span>
	    				</div>
	    			</div>
	    		</div>
	    	</div>

	    	<div class="col-md-6">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<div class="input-group">
	    					<input type="text" id="texto_tweet" class="form-control" placeholder="O que está acontecendo agora?" maxlength="140">
	    					<span class="input-group-btn">
	    						<button id="btn_tweet" class="btn btn-default" type="button">Tweet</button>
	    					</span>
	    				</div>
	    			</div>
	    		</div>

	    		<div id="tweets" class="list-group"></div>

				<!-- Modal -->
				<div id="modalRemocaoTweet" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				        <div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal">&times;</button>
				        	<h4 class="modal-title">Tem certeza que deseja excluir o tweet?</h4>
				        </div>
				        <div class="modal-body">
				        	<span id="id_tweet" style="display:none"></span>
				        	<p id="conteudo_tweet"></p>
				        </div>
				        <div class="modal-footer">
				      		<button type="button" id="btn-remover-tweet" class="btn btn-primary">Excluir</button>
				        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				        </div>
				    </div>

				  </div>
				</div>
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