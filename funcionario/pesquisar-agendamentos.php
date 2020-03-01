<?php
session_start();
include_once "../db/conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> <!-- essa linha é o CSS do bootstrap frameworkd-->		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> <!-- as 3 linhas abaixo são JS do bootstrap frameworkd-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>		
		<title> Pesquisar Agendamentos </title>		
	</head>
	<body>
		<a href="../index.php">HOME</a><br>		
		
		<h1> Pesquisar Agendamentos </h1>
		<h6> Para encontrar um agendamento específico, primeiro, informe o nome da Escola ou do Usuário Individual </h6>
		<form method="POST" action="">
			<label>Nome: </label>
			<input type="text" name="nome" placeholder="Digite o nome"><br><br>
			<a href=""></a>
			
			<input name="pesquisa" type="submit" value="Pesquisar">
		</form><br><br>
		
		<?php
		$pesquisa = filter_input(INPUT_POST, 'pesquisa', FILTER_SANITIZE_STRING);
		if($pesquisa)
		{
			$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
			$query = "SELECT * FROM usuarios WHERE nome LIKE '%$nome%'";
			$result_query = mysqli_query($conn, $query);
			while($row_usuario = mysqli_fetch_assoc($result_query))
			{
				$_SESSION['usuario_pesquisado'] = $row_usuario['id'];
				echo "Nome: " . $row_usuario['nome'] . "<br>";
				//echo "E-mail: " . $row_usuario['email'] . "<br>";
				//echo "<a href='editar-usuario.php?id=" . $row_usuario['id'] . "'>Editar</a><br>";
				//echo "<a href='proc-excluir-usuario.php?id=" . $row_usuario['id'] . "'>Excluir</a><br><hr>";
				//echo "<a href='proc-excluir-usuario.php?id=" . $row_usuario['id'] . "' data-confirm=''>Excluir</a><br>";
				echo "<a href='../agendamentos/listar-agendamentos.php?pagina'>VER AGENDAMENTOS</a><br><hr>";
			}
		}
		?>		
	</body>
</html>