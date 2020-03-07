<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> Gerir Usuários </title>		
	</head>
	<body>
		<h1>Gerenciar Usuários</h1>
		<a href="../index.php"> HOME </a><br>
		<a href="form-cad-usuario.php">Cadastrar Usuário</a><br>
		<a href="form-listar-usuarios.php">Listar Usuários</a><br>
		<a href="form-buscar-usuarios.php">Buscar Usuários</a><br>		
		<a href="t-c-gerir-estagiarios.php">Gerir Horários dos Estagiários</a><br>
		<?php
		if(isset($_SESSION['msg']))
		{
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
	</body>
</html>