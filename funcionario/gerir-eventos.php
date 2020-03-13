<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> Gerir Eventos </title>		
	</head>
	<body>
		<h1>Gerenciar Eventos</h1>
		<a href="../index.php"> HOME </a><br>
		<a href="form-cad-temas.php">Cadastrar Temas</a><br>
		<a href="form-cad-exposicoes.php">Cadastrar Exposições</a><br>				
		<a href="form-listar-temas.php">Listar Temas</a><br>
		<a href="form-buscar-temas.php">Buscar Temas</a><br>
		<a href="form-listar-exposicoes.php">Listar Exposições</a><br>
		<a href="form-buscar-exposicoes.php">Buscar Exposições</a><br>
		<a href="t-c-gerir-eventos.php">Editar Eventos</a><br>
		<?php
		if(isset($_SESSION['msg']))
		{
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
	</body>
</html>