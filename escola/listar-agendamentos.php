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
		<title> Meus Agendamentos</title>		
	</head>
	<body>
		<div class="container"> <!-- afasta o conteúdo da margem esquerda -->
			<a href="../index.php">HOME</a><br>			
			<h1 class="text-center" > Todos os Meus Agendamentos </h1>

			<?php

			$usuario = $_SESSION['usuarioId'];
			$a_ids = array();
			$a_eventos = array();
			$a_turmas = array();
			$a_titles = array();
			$a_starts = array();
			$a_ends = array();

			if(isset($_SESSION['msg']))
			{
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			
			$pagina_atual = filter_input(INPUT_GET,'pagina', FILTER_SANITIZE_NUMBER_INT); 
			
			$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1; 
			
			$total_de_resultados_por_pagina = 3; 
			
			$inicio = ($total_de_resultados_por_pagina * $pagina) - $total_de_resultados_por_pagina; 
			
			$query = "SELECT * FROM agendamentos WHERE (escola = $usuario AND excluido = 0) LIMIT $inicio, $total_de_resultados_por_pagina"; 
			$result_query = mysqli_query($conn, $query);

			while($row_agendamento = mysqli_fetch_assoc($result_query))
			{	
				$a_ids[] = $row_agendamento['id'];
				$a_eventos[] = $row_agendamento['evento'];
				$a_turmas[] = $row_agendamento['turma']; 	
			}

			$qtd_A = count($a_eventos);

			foreach ($a_eventos as $key => $value)
			{	
				$query = "SELECT title, start, end FROM eventos WHERE id=$value";
				$result_query = mysqli_query($conn, $query);
				$row_evento = mysqli_fetch_assoc($result_query);	
				$a_titles[] = $row_evento['title'];	
				$a_starts[] = $row_evento['start'];	
				$a_ends[] = $row_evento['end'];
			}

			$i = 0;

			while($i < $qtd_A)
			{	
				echo "Evento: "; echo $a_eventos[$i]; echo "<BR>";
				echo "TEMA = "; echo $a_titles[$i]; echo "<BR>";	
				echo "inicio = "; echo $a_starts[$i]; echo "<BR>";		
				echo "fim = "; echo $a_ends[$i]; echo "<BR>";	
				echo "Turma: "; echo $a_turmas[$i]; echo "<BR>";	
				echo "<a href='proc-cancelar-agendamento.php?id=" . $a_ids[$i] . "&evento=" . $a_eventos[$i] . "&turma=" . $a_turmas[$i] . "' data-confirm=''>CANCELAR este AGENDAMENTO</a><br><hr>";
				$i++;
			}						
			
			$query = "SELECT COUNT(id) AS total_agendamentos FROM agendamentos WHERE escola = $usuario"; 
			$result_query = mysqli_query($conn, $query);
			$row_pagina = mysqli_fetch_assoc($result_query); //echo $row_pagina['total_agendamentos'];			
			$total_de_paginas = ceil($row_pagina['total_agendamentos'] / $total_de_resultados_por_pagina); 
			
			$max_links = 2; 

			echo "<a href='listar-agendamentos.php?pagina=1'>Primeira</a> ";
			
			for($pagina_anterior = $pagina - $max_links; $pagina_anterior <= $pagina - 1; $pagina_anterior++)
			{
				if($pagina_anterior >= 1)
				{					
					echo "<a href='listar-agendamentos.php?pagina=$pagina_anterior'>$pagina_anterior</a> ";
				}
			}
				
			echo "$pagina ";
			
			for($pagina_seguinte = $pagina + 1; $pagina_seguinte <= $pagina + $max_links; $pagina_seguinte++)
			{
				if($pagina_seguinte <= $total_de_paginas)
				{					
					echo "<a href='listar-agendamentos.php?pagina=$pagina_seguinte'>$pagina_seguinte</a> ";
				}
			}			
			
			echo "<a href='listar-agendamentos.php?pagina=$total_de_paginas'>Ultima</a>";
			
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
						$('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal-confirmar-cancelar" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">CANCELAR AGENDAMENTO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Esta operação não pode ser desfeita! Você ainda deseja CANCELAR este Agendamento?</div><div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">NÃO ! deixar tudo como está!</button><a class="btn btn-danger text-white" id="dataComfirmOK">SIM! quero cancelar</a></div></div></div></div>');
					}
					$('#dataComfirmOK').attr('href', href);
			        $('#confirm-delete').modal({show: true});
					return false;					
				});
			});			
		</script>
	</body>
</html>