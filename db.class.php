 <?php
	class db {
		private $host = 'localhost';
		private $usuario = 'root';
		private $senha = '';
		private $database = 'twitter_clone';

		public function conecta_mysql() {
			$connection = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
			mysqli_set_charset($connection, 'utf8');

			if (mysqli_connect_errno()) {
				echo "Erro ao conectar ao banco de dados MySQL: mysqli_connect_error()";
			}

			return $connection;
		}
	}
?>