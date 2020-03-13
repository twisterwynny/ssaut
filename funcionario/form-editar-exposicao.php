<?php
session_start();
include_once("../db/conexao.php");
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT * FROM exposicoes WHERE id = '$id'";
$result_query = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result_query);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> Atualizar Exposição </title>		
	</head>
	<body>
		<a href="../index.php">HOME</a><br>
		<a href="form-cad-temas.php">Cadastrar Temas</a><br>
		<a href="form-cad-exposicoes.php">Cadastrar Exposições</a><br>				
		<a href="form-listar-temas.php">Listar Temas</a><br>
		<a href="form-buscar-temas.php">Buscar Temas</a><br>
		<a href="form-listar-exposicoes.php">Listar Exposições</a><br>
		<a href="form-buscar-exposicoes.php">Buscar Exposições</a><br>
		<a href="t-c-gerir-eventos.php">Editar Eventos</a><br>
		<h1> Atualizar Exposição </h1>
		<?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
		<form method="POST" action="proc-editar-exposicao.php">
			<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
			
			<label>Nome: </label>
			<input type="text" name="nome" placeholder="Digite aqui o nome" value="<?php echo $row['nome']; ?>"><br><br>
			
			<label>Descrição: </label>
			<input type="text" name="descricao" placeholder="Digite aqui a Descrição" value="<?php echo $row['descricao']; ?>"><br><br>			
			
			<input type="submit" value="Editar">
		</form>
	</body>
</html>