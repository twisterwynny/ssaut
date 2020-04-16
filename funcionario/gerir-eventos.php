<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> Gerir Eventos </title>
		<link rel="stylesheet" href="./../assets/bootstrap/bootstrap.css">		
	</head>
	<body>
		<div class="container mt-5">
			<h1>Gerenciar Eventos</h1>
			<div class="row mt-3">
				<ul class="list-group">
					<li class="list-group-item list-group-item-info">
						<a href="../index.php"> HOME </a>
					</li>
					<li class="list-group-item list-group-item-info">
						<a href="form-cad-temas.php">Cadastrar Temas</a>
					</li>
					<li class="list-group-item list-group-item-info">
						<a href="form-cad-exposicoes.php">Cadastrar Exposições</a>
					</li>
					<li class="list-group-item list-group-item-info">
						<a href="form-listar-temas.php">Listar Temas</a>
					</li>
					<li class="list-group-item list-group-item-info">
						<a href="form-buscar-temas.php">Buscar Temas</a>
					</li>
					<li class="list-group-item list-group-item-info">
						<a href="form-listar-exposicoes.php">Listar Exposições</a>
					</li>
					<li class="list-group-item list-group-item-info">
						<a href="form-buscar-exposicoes.php">Buscar Exposições</a>
					</li>
					<li class="list-group-item list-group-item-info">
						<a href="t-c-gerir-eventos.php">Editar Eventos</a>
					</li>
				</ul>
			</div>
		</div>
		<?php
		if(isset($_SESSION['msg']))
		{
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
	</body>
<script src="./../assets/bootstrap/jquery.js"></script>
<script src="./../assets/bootstrap/popper.js"></script>
<script src="./../assets/bootstrap/bootstrap.js"></script>
<script src="./../assets/bootstrap/bootstrap.bundle.js"></script>
</html>