<?php
session_start();
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
		<title> Buscar Temas </title>		
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
		
		<h1> Buscar Temas </h1>
		
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
			$query = "SELECT * FROM temas WHERE nome LIKE '%$nome%'";
			$result_query = mysqli_query($conn, $query);
			while($row = mysqli_fetch_assoc($result_query))
			{
				echo "ID: " . $row['id'] . "<br>";
				echo "Nome: " . $row['nome'] . "<br>";
				echo "Descrição: " . $row['descricao'] . "<br>";
				echo "<a href='form-editar-tema.php?id=" . $row['id'] . "'>Editar</a><br>";
				//echo "<a href='proc-excluir-tema.php?id=" . $row['id'] . "'>Excluir</a><br><hr>";
				echo "<a href='proc-excluir-tema.php?id=" . $row['id'] . "' data-confirm=''>Excluir</a><br><hr>";
			}
		}
		?>

		<script>
			$(document).ready(function()
			{
				$('a[data-confirm]').click(function(ev)
				{
					var href = $(this).attr('href');
					if(!$('#confirm-delete').length)
					{
						$('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal-confirmar-excluir" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">EXCLUIR TEMA<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Esta operação não pode ser desfeita! Confirmar exclusão deste Tema?</div><div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">NÃO! deixar como está</button><a class="btn btn-danger text-white" id="dataComfirmOK">SIM! Excluir</a></div></div></div></div>');
					}
					$('#dataComfirmOK').attr('href', href);
			        $('#confirm-delete').modal({show: true});
					return false;					
				});
			});			
		</script>

	</body>
</html>