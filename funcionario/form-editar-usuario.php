<?php
session_start();
include_once("../db/conexao.php");
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$result_usuario = "SELECT * FROM usuarios WHERE id = '$id'";
$resultado_usuario = mysqli_query($conn, $result_usuario);
$row_usuario = mysqli_fetch_assoc($resultado_usuario);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> Atualizar Usuário </title>		
	</head>
	<body>
		<a href="../index.php">HOME</a><br>
		<a href="form-cad-usuario.php">Cadastrar</a><br>
		<a href="form-listar-usuarios.php">Listar</a><br>
		<a href="form-buscar-usuarios.php">Buscar</a><br>
		<h1> Atualizar Usuário </h1>
		<?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
		<form method="POST" action="proc-editar-usuario.php">
			<input type="hidden" name="id" value="<?php echo $row_usuario['id']; ?>">
			
			<label>Nome: </label>
			<input type="text" name="nome" placeholder="Digite aqui seu nome" value="<?php echo $row_usuario['nome']; ?>"><br><br>
			
			<label>E-mail: </label>
			<input type="email" name="email" placeholder="Digite aqui seu e-mail" value="<?php echo $row_usuario['email']; ?>"><br><br>

			<label>Senha: </label>
			<input type="senha" name="senha" placeholder="Digite aqui sua senha" value="<?php echo $row_usuario['senha']; ?>"><br><br>
			
			<input type="submit" value="Editar">
		</form>
	</body>
</html>