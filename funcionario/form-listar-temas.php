<?php
session_start();
include_once("../db/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> <!-- essa linha é o CSS do bootstrap frameworkd-->		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> <!-- as 3 linhas abaixo são JS do bootstrap frameworkd-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>		
		<title> Listar Temas</title>		
	</head>
	<body>
		<div class="container"> <!-- afasta o conteúdo da margem esquerda -->
			<a href="../index.php">HOME</a><br>
			<a href="form-cad-temas.php">Cadastrar Temas</a><br>
			<a href="form-cad-exposicoes.php">Cadastrar Exposições</a><br>				
			<a href="form-listar-temas.php">Listar Temas</a><br>
			<a href="form-buscar-temas.php">Buscar Temas</a><br>
			<a href="form-listar-exposicoes.php">Listar Exposições</a><br>
			<a href="form-buscar-exposicoes.php">Buscar Exposições</a><br>
			<a href="t-c-gerir-eventos.php">Editar Eventos</a><br>
			<h1> Listar Temas </h1>

			<?php			

			if(isset($_SESSION['msg']))
			{
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			
			$pagina_atual = filter_input(INPUT_GET,'pagina', FILTER_SANITIZE_NUMBER_INT); //pega o número da página atual na variável contida na URL.
			
			$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1; // operador ternário, se pagina_atual NÃO estiver vazia, então pagina = pagina_atual, caso contrário, pagina = 1;
			
			$total_de_resultados_por_pagina = 3; //define a quantidade de resultados listados em cada página			
			
			$inicio = ($total_de_resultados_por_pagina * $pagina) - $total_de_resultados_por_pagina; //define onde começa a exibição em cada página. por exemplo: se forem 2 resultados por página e estiver na pagina dois, então começa a exibir do resultado 3. se estiver na pagina 3 então começa a exibir no resultado 5.
			
			$query = "SELECT * FROM temas LIMIT $inicio, $total_de_resultados_por_pagina"; // cada clique no link, executa este select uma vez.
			$result_query = mysqli_query($conn, $query);
			while($row = mysqli_fetch_assoc($result_query))
			{
				echo "ID: " . $row['id'] . "<br>";
				echo "Nome: " . $row['nome'] . "<br>";
				echo "Descrição: " . $row['descricao'] . "<br>";
				echo "<a href='form-editar-tema.php?id=" . $row['id'] . "'>Editar</a><br>";
				//echo "<a href='proc-excluir-tema.php?id=" . $row['id'] . "'>excluir</a><br><hr>";
				//echo "<a href='proc-excluir-tema.php?id=" . $row['id'] . "' data-confirm='Esta operação não pode ser desfeita! Confirmar exclusão deste Usuário?'>excluir</a><br><hr>";
				echo "<a href='proc-excluir-tema.php?id=" . $row['id'] . "' data-confirm=''>excluir</a><br><hr>";
			}			
			
			$query = "SELECT COUNT(id) AS total_temas FROM temas"; // conta todos os temas na tabela e retorna o total
			$result_query = mysqli_query($conn, $query);
			$row_pagina = mysqli_fetch_assoc($result_query);
			//echo $row_pagina['total_temas'];			
			$total_de_paginas = ceil($row_pagina['total_temas'] / $total_de_resultados_por_pagina); //determina o total de paginas de resultados para suportar a exibição de todos os usuários que foram contados na tabela
			
			$max_links = 2; // define o limite de links exibidos em "PAGINAS ANTERIORES" e "PAGINAS SEGUINTES"	

			echo "<a href='form-listar-temas.php?pagina=1'>Primeira</a> ";
			
			for($pagina_anterior = $pagina - $max_links; $pagina_anterior <= $pagina - 1; $pagina_anterior++)
			{
				if($pagina_anterior >= 1)
				{					
					echo "<a href='form-listar-temas.php?pagina=$pagina_anterior'>$pagina_anterior</a> ";
				}
			}
				
			echo "$pagina ";
			
			for($pagina_seguinte = $pagina + 1; $pagina_seguinte <= $pagina + $max_links; $pagina_seguinte++)
			{
				if($pagina_seguinte <= $total_de_paginas)
				{					
					echo "<a href='form-listar-temas.php?pagina=$pagina_seguinte'>$pagina_seguinte</a> ";
				}
			}			
			
			echo "<a href='form-listar-temas.php?pagina=$total_de_paginas'>Ultima</a>";
			
			?>
		</div>

		<script>
			$(document).ready(function()
			{
				$('a[data-confirm]').click(function(ev)
				{
					var href = $(this).attr('href');
					if(!$('#confirm-delete').length)
					{
						$('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal-confirmar-excluir" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">EXCLUIR TEMAS<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Esta operação não pode ser desfeita! Confirmar exclusão deste Tema?</div><div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">NÃO! deixar como está</button><a class="btn btn-danger text-white" id="dataComfirmOK">SIM! Excluir</a></div></div></div></div>');
					}
					$('#dataComfirmOK').attr('href', href);
			        $('#confirm-delete').modal({show: true});
					return false;					
				});
			});			
		</script>
	</body>
</html>