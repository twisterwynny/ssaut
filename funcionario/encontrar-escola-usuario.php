<?php
session_start();
if (isset($_SESSION['funcionario_agendou']))
{
	unset($escola);
	unset($_SESSION['escola']);
	unset($_SESSION['selecionou_escola']);
	unset($_SESSION['funcionario_agendou']);	
}

if (isset($_SESSION['selecionou_escola']))
{
	$escola = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	$_SESSION['escola'] = $escola;
	unset($_SESSION['selecionou_escola']);
	echo "ESCOLA ESCOLHIDA FOI = $id<BR>";
	header("Location: ../agendamentos/t-c-agendamentos.php");
}
else
echo "PRIMEIRA VEZ<BR>";

include_once "../db/conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> <!-- essa linha é o CSS do bootstrap frameworkd-->
		<!-- as 3 linhas abaixo são JS do bootstrap frameworkd-->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>		
		<title> Buscar Usuários ou Escolas </title>		
	</head>
	<body>
		<a href="../index.php">HOME</a><br>		
		
		<h1> Buscar Usuários ou Escolas </h1>
		<h5> Para fazer um agendamento para uma escola, primeiro você precisa escolher a Escola. Faça a Busca abaixo </h5>
		
		<form method="POST" action="">
			<label>Nome: </label>
			<input type="text" name="nome" placeholder="Digite o nome"><br><br>
			
			<input name="buscar" type="submit" value="Encontrar">
		</form><br><br>
		
		<?php
		$buscar = filter_input(INPUT_POST, 'buscar', FILTER_SANITIZE_STRING);
		if($buscar)
		{
			$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
			$query = "SELECT * FROM usuarios WHERE (permissao = 3 AND nome LIKE '%$nome%')";
			$result_query = mysqli_query($conn, $query);
			while($row_usuario = mysqli_fetch_assoc($result_query))
			{
				echo "ID: " . $row_usuario['id'] . "<br>";
				echo "Nome: " . $row_usuario['nome'] . "<br>";
				echo "E-mail: " . $row_usuario['email'] . "<br>";
				echo "<a href='encontrar-escola-usuario.php?id=" . $row_usuario['id'] . "'>SELECIONAR</a><br>";								
			}			
			$_SESSION['selecionou_escola'] = true;
		}
		?>
	</body>
</html>