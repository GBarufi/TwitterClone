<!DOCTYPE HTML>
<html lang="pt-br">

	<?php
		session_start();
		
		$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

		if (isset($_SESSION['usuario'])) {
			header('Location: home.php');
		}
	?>

	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>

		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	
		<script>
			$(document).ready(function() {
				$('#btn_login').click(function() {
					var campoVazio = false;

					var campoUsuario = $('#campo_usuario'),
						campoSenha = $('#campo_senha');

					if (campoUsuario.val() == '') {
						campoUsuario.css({'border-color': '#A94442'});
						campoVazio = true;
					} else {
						campoUsuario.css({'border-color': '#CCC'});
					}

					if (campoSenha.val() == '') {
						campoSenha.css({'border-color': '#A94442'});
						campoVazio = true;
					} else {
						campoSenha.css({'border-color': '#CCC'});
					}

					if (campoVazio) {
						return false;
					}
				});
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
						<li><a href="inscrevase.php">Inscrever-se</a></li>
						<li class="<?= $erro == 1 ? 'open' : '' ?>">
							<a id="entrar" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entrar</a>
							<ul class="dropdown-menu" aria-labelledby="entrar">
								<div class="col-md-12">
						    		<p>Você possui uma conta?</h3>
						    		<br />
									<form method="post" action="validar_acesso.php" id="formLogin">
										<div class="form-group">
											<input type="text" class="form-control" id="campo_usuario" name="usuario" placeholder="Usuário" />
										</div>
										
										<div class="form-group">
											<input type="password" class="form-control red" id="campo_senha" name="senha" placeholder="Senha" />
										</div>
										
										<button type="submit" class="btn btn-primary" id="btn_login">Entrar</button>

										<br /><br />
										
									</form>

									<?php
										if ($erro == 1) {
											echo '<span style="color:#FF0000">Usuário e/ou senha inválido(s).</span>';
										}
									?>
								</form>
						  	</ul>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
	    </nav>


	    <div class="container">

	        <div class="jumbotron">
	            <h1>Bem vindo ao twitter clone</h1>
	            <p>Veja o que está acontecendo agora...</p>
	        </div>

	        <div class="clearfix"></div>
		</div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>