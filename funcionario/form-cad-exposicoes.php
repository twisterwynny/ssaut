<?php
session_start();
include_once("../db/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> Cadastrar Exposições </title>		
	</head>
	<body>
		<a href="../index.php"> HOME </a><br>
		<a href="form-cad-temas.php">Cadastrar Temas</a><br>
		<a href="form-cad-exposicoes.php">Cadastrar Exposições</a><br>		
		<a href="t-c-gerir-eventos.php">Gerir Eventos</a><br>
		<h1>Cadastrar Exposiçõess</h1>
		<?php
		if(isset($_SESSION['msg']))
		{
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
		<form method="POST" action="proc-cad-exposicao.php">
			<label for="nome" >Nome: </label>
			<input type="text" id="nome" name="nome" placeholder="Digite aqui o nome da Exposição" required="" size="42"><BR><BR>
			<label for="descricao">Descrição: </label><BR>
			<textarea id="descricao" name="descricao"  placeholder="Digite a descrição" required="" rows="5" cols="50"></textarea><BR>
			<label for="tema">Tema da Exposição: </label><BR>
			<select id="tema" name="tema" required="">
		 		<option value="">Selecione Aqui</option>
				<?php		

				$query = "SELECT id, nome FROM temas";//PESQUISA TODAS AS ESCOLAS CADASTRADAS
				$result_query = mysqli_query($conn, $query);

				while ($row = mysqli_fetch_array($result_query))
				{    
				    $id = $row['id'];
				    $nome = $row['nome'];
				    ?>
				    <option value="<?php echo $row['id']; ?>"> <?php echo $row['nome']; ?> </option>
				    <?php
				}
				?>
			</select>
			<input type="submit" value="Cadastrar">
		</form>				
	</body>
</html>