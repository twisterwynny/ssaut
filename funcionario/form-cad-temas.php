<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> Cadastrar Temas </title>		
	</head>
	<body>
		<a href="../index.php"> HOME </a><br>
		<a href="form-cad-temas.php">Cadastrar Temas</a><br>
		<a href="form-cad-exposicoes.php">Cadastrar Exposições</a><br>		
		<a href="t-c-gerir-eventos.php">Gerir Eventos</a><br>
		<h1>Cadastrar Temas</h1>
		<?php
		if(isset($_SESSION['msg']))
		{
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
		<form method="POST" action="proc-cad-tema.php">
			<label for="nome" >Nome: </label>
			<input type="text" id="nome" name="nome" placeholder="Digite aqui o nome do Tema" required="" size="42"><BR><BR>
			<label for="descricao">Descrição: </label><BR>
			<textarea id="descricao" name="descricao"  placeholder="Digite a descrição" required="" rows="5" cols="50"></textarea><BR>
			<input type="submit" value="Cadastrar">
		</form>				
	</body>
</html>