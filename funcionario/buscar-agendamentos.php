<?php
session_start();
/*
if (isset($_SESSION['funcionario_agendou']))
{
	unset($escola);
	unset($_SESSION['escola']);
	unset($_SESSION['selecionou_escola']);
	unset($_SESSION['funcionario_agendou']);	
}
*/
if (isset($_SESSION['controle']))
{
	$escola = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	$_SESSION['escola'] = $escola;
	unset($_SESSION['controle']);
	echo "ESCOLA ESCOLHIDA FOI = $id<BR>";
	header("Location: ../agendamentos/listar-agendamentos.php");
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
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> <!-- as 3 linhas abaixo são JS do bootstrap frameworkd -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>		
		<title> Buscar Agendamentos </title>		
	</head>
	<body>
		<a href="../index.php">HOME</a><br>		
		
		<h1> Buscar Agendamentos </h1>
		<h6> Para encontrar um agendamento específico, primeiro, informe o nome da Escola ou do Usuário Individual </h6>

		<form method="POST" action="">
			<label>Nome: </label>
			<input type="text" name="nome" placeholder="Digite o nome"><br><br>
			<!-- <a href=""></a> -->
			
			<input name="buscar" type="submit" value="Encontrar">
		</form><br><br>
		
		<?php
		$buscar = filter_input(INPUT_POST, 'buscar', FILTER_SANITIZE_STRING);
		if($buscar)
		{
			$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
			$query = "SELECT * FROM usuarios WHERE nome LIKE '%$nome%'";
			$result_query = mysqli_query($conn, $query);
			while($row_usuario = mysqli_fetch_assoc($result_query))
			{
				//$_SESSION['usuario_pesquisado'] = $row_usuario['id'];
				echo "Nome: " . $row_usuario['nome'] . " ";
				//echo "E-mail: " . $row_usuario['email'] . "<br>";
				
				//echo "<a href='proc-excluir-usuario.php?id=" . $row_usuario['id'] . "'>Excluir</a><br><hr>";
				//echo "<a href='proc-excluir-usuario.php?id=" . $row_usuario['id'] . "' data-confirm=''>Excluir</a><br>";
				//echo "<a href='../agendamentos/listar-agendamentos.php?pagina'>VER AGENDAMENTOS</a><br><hr>";
				echo "<a href='buscar-agendamentos.php?id=" . $row_usuario['id'] . "'>SELECIONAR</a><br>";
			}
			$_SESSION['controle'] = true;
		}
		?>		
	</body>
</html>