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
		<title> Buscar Usuários </title>		
	</head>
	<body>
		<a href="../index.php">HOME</a><br>
		<a href="form-cad-usuario.php">Cadastrar</a><br>
		<a href="form-listar-usuarios.php">Listar</a><br>
		<a href="form-buscar-usuarios.php">Buscar</a><br>
		<a href="t-c-gerir-estagiarios.php">Gerir Horários dos Estagiários</a><br>
		
		<h1> Buscar Usuários </h1>
		
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
			$query = "SELECT * FROM usuarios WHERE nome LIKE '%$nome%'";
			$result_query = mysqli_query($conn, $query);
			while($row_usuario = mysqli_fetch_assoc($result_query))
			{
				echo "ID: " . $row_usuario['id'] . "<br>";
				echo "Nome: " . $row_usuario['nome'] . "<br>";
				echo "E-mail: " . $row_usuario['email'] . "<br>";
				echo "<a href='form-editar-usuario.php?id=" . $row_usuario['id'] . "'>Editar</a><br>";
				//echo "<a href='proc-excluir-usuario.php?id=" . $row_usuario['id'] . "'>Excluir</a><br><hr>";
				echo "<a href='proc-excluir-usuario.php?id=" . $row_usuario['id'] . "' data-confirm=''>Excluir</a><br><hr>";
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
						$('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal-confirmar-excluir" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">EXCLUIR USUÁRIO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Esta operação não pode ser desfeita! Confirmar exclusão deste Usuário?</div><div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">NÃO! deixar como está</button><a class="btn btn-danger text-white" id="dataComfirmOK">SIM! Excluir</a></div></div></div></div>');
					}
					$('#dataComfirmOK').attr('href', href);
			        $('#confirm-delete').modal({show: true});
					return false;					
				});
			});			
		</script>

	</body>
</html>