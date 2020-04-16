<?php
session_start();
include_once("../db/conexao.php");
$query = "SELECT id, estagiario, start, end, color FROM eventos";
$result_query = mysqli_query($conn, $query);
$a_ids = array();
$a_estagiarios = array();
$a_starts = array();
$a_ends = array();
$a_colors = array();
$a_ends = array();
$a_nomes_e = array();
while($row_eventos = mysqli_fetch_assoc($result_query))
{	
	$a_ids[] = $row_eventos['id'];
	$a_estagiarios[] = $row_eventos['estagiario'];
	$a_starts[] = $row_eventos['start']; 	
	$a_ends[] = $row_eventos['end']; 	
	$a_colors[] = $row_eventos['color']; 	
}
$qtd_E = count($a_ids);
foreach ($a_estagiarios as $key => $value)
{	
	$query = "SELECT nome FROM usuarios WHERE id=$value";
	$result_query = mysqli_query($conn, $query);
	$row_usuario = mysqli_fetch_assoc($result_query);	
	$a_nomes_e[] = $row_usuario['nome'];		
}
$i = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset='utf-8' />
		<link href="../css/index.css" rel="stylesheet">  <!-- PARA CEU DE TELA INTEIRA NO FUNDO -->
		<title>Gerir Horários Estagiários</title>
		<link href='../css/bootstrap.min.css' rel='stylesheet'>
		<link href='../css/fullcalendar.min.css' rel='stylesheet' />
		<link href='../css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
		<link href='../css/estilo.css' rel='stylesheet' />
		<script src='../js/jquery.min.js'></script>
		<script src='../js/bootstrap.min.js'></script>
		<script src='../js/moment.min.js'></script>
		<script src='../js/fullcalendar.min.js'></script>
		<script src='../locale/pt-br.js'></script>		
		<script>
			$(document).ready(function()
			{
				$('#calendar').fullCalendar(
				{
					defaultView: 'agendaWeek',
					header:
					{						
						left: 'today',
						center: 'title',						
						right: 'agendaWeek'
					},
					defaultDate: Date(),
					navLinks: true, // can click day/week names to navigate views
					editable: true,
					eventLimit: true, // allow "more" link when too many events
					eventClick: function(event)
					{
						$('#ver #id').text(event.id);
						$('#ver #id').val(event.id);
						$('#ver #estagiario').text(event.estagiario);
						$('#ver #estagiario').val(event.estagiario);
						$('#ver #nome_estagiario').text(event.nome_estagiario);
						$('#ver #nome_estagiario').val(event.nome_estagiario);
						$('#ver #start').text(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#ver #start').val(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#ver #end').text(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#ver #end').val(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#ver #color').val(event.color);
						$('#ver').modal('show');															
						return false;							
					},					
					selectable: true,
					selectHelper: true,
					select: function(start, end)
					{
						$('#cadastrar #start').val(moment(start).format('DD/MM/YYYY HH:mm:ss'));
						$('#cadastrar #end').val(moment(end).format('DD/MM/YYYY HH:mm:ss'));
						$('#cadastrar').modal('show');						
					},
					events:
					[
						<?php						
						while($i < $qtd_E)
						{
						?>
							{
								id: '<?php echo $a_ids[$i]; ?>',
								estagiario: '<?php echo $a_estagiarios[$i]; ?>',
								start: '<?php echo $a_starts[$i]; ?>',
								end: '<?php echo $a_ends[$i]; ?>',																
								color: '<?php echo $a_colors[$i]; ?>',
								nome_estagiario: '<?php echo $a_nomes_e[$i]; ?>',
							},
						<?php
						$i++;							
						}
						?>//FECHA PHP
					]
				}); // FECHA fullCalendar(
			});	// FECHA ready(
			function MascaraDataHora(evento, objeto) //mascara para o campo DATETIME do formato SQL ser apresentado no formato brasileiro
			{
				var clica=(window.event)?event.keyCode:evento.which;
				campo = eval (objeto);
				if (campo.value == '00/00/0000 00:00:00') campo.value = "";			 
				numeros = '0123456789';
				token1 = '/';
				token2 = ' ';
				token3 = ':';
				grupo1 = 2;
				grupo2 = 5;
				grupo3 = 10;
				grupo4 = 13;
				grupo5 = 16;
				if((numeros.search(String.fromCharCode (clica)) != -1) && campo.value.length < (19))
				{
					if(campo.value.length == grupo1 ) campo.value = campo.value + token1;
					else if(campo.value.length == grupo2) campo.value = campo.value + token1;
					else if(campo.value.length == grupo3) campo.value = campo.value + token2;
					else if(campo.value.length == grupo4) campo.value = campo.value + token3;
					else if(campo.value.length == grupo5) campo.value = campo.value + token3;
				}
				else
				{
					event.returnValue = false;
				}
			}
		</script>
	</head>
	<body>

		<div class="fluid-container" id="">
    		<div id="" class="text-center" style="color:#000">
        		<div id="ceu" class="img_fundo" style="padding-bottom: 10%; padding-top: 0%">
		
					<a href="../index.php"> HOME </a><br>
					<!-- 
					<a href="encontrar-escola-usuario.php"> AGENDAR VISITA PARA ESCOLA </a><br>
					<a href='buscar-agendamentos.php'> BUSCAR AGENDAMENTOS </a><br>
					-->
					
					<div class="container">
						<font color="white">
							<h1 class="text-center"> Gerenciar Horários dos Estagiários </h1>
						</font>
						<BR>
						
						<?php						
						if(isset($_SESSION['msg']))
						{
							echo $_SESSION['msg'];
							unset($_SESSION['msg']);
						}						
						?>

						<div id='calendar'></div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center">Dados do Horário</h4>
					</div>
					<div class="modal-body">
						<div class="ver">
							<dl class="dl-horizontal">
								<dt>ID do Evento: </dt>
								<dd id="id"></dd>
								<dt>ID Estagiário: </dt>
								<dd id="estagiario"></dd>								
								<dt>NOME do estagiário: </dt>
								<dd id="nome_estagiario"></dd>
								<dt>Inicio do Evento: </dt>
								<dd id="start"></dd>
								<dt>Fim do Evento: </dt>
								<dd id="end"></dd>																
							</dl>
							<div class="form-group">
								<div class="text-center">
									<button type="button" class="btn btn-cancelar-ver-evento btn-secondary" data-dismiss="modal">Cancelar</button>
									<button class="btn btn-editar-horario btn-primary">Editar</button>
								</div>
							</div>
						</div>
						<div class="form">
							<form class="form-horizontal" method="POST" action="proc-edit-horario-estagiario.php">
								
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-1 control-label"> Data e Hora do Início </label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-6 control-label"> Data e Hora do Fim </label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="end" id="end" onKeyPress="DataHora(event, this)">
									</div>
								</div>

								<!-- -->
								<input type="hidden" class="form-control" name="id" id="id"> <!-- PARA PEGAR OS DADOS SEM EXIBIR NO FORMULÁRIO -->
								<input type="hidden" class="form-control" name="estagiario" id="estagiario">  <!-- PARA PEGAR OS DADOS SEM EXIBIR NO FORMULÁRIO -->								
								<!-- -->
								<div class="form-group">
									<div class="text-center">
										<button type="button" class="btn btn-cancela-editar-horario btn-secondary">Cancelar</button>
										<button type="submit" class="btn btn-success">Salvar Alterações</button>
									</div>
								</div>
							</form>						
						</div>
					</div>
				</div>
			</div>
		</div>	

		<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="cadastrar" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">

					<div class="modal-header">						
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center"> Cadastrar Horário do Estagiário </h4>						
					</div>

					<div class="modal-body">
						<form class="form-cad-horario-estagiario" method="POST" action="proc-cad-horario-estagiario.php">
							<div class="form-group">
								<div class="row">
									<div class="text-center">
										<label for="start" class="col-sm-6 control-label"> Data e Hora de Início: </label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="text-center">
										<label for="end" class="col-sm-6 control-label"> Data e Hora do Fim: </label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="end" id="end" onKeyPress="DataHora(event, this)">
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="text-center">									
										<label for="estagiario" class="col-sm-6 control-label"> Escolha o Estagiário: </label>
										<div class="col-sm-4">
											<select class="form-control" id="estagiario" name="estagiario" required="">
									 			<option value="">Selecione</option>
								 				<?php
												require_once("retorna-estagiarios.php");//	<div class="col-sm-10">
												?>
											</select>
										</div>
									</div>
								</div>		
							</div>										 	
					 		
					 		<div class="form-group">
								<div class="text-center">
									<button type="button" class="btn btn-cancelar-adicionar-horario btn-secondary" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-success">ADICIONAR</button>
								</div>
							</div>							
						</form>
					</div>
				</div>
			</div>
		</div>		
		
		<script>
			$('.btn-editar-horario').on("click", function()
			{
				$('.form').slideToggle();
				$('.ver').slideToggle();
			});
			$('.btn-cancela-editar-horario').on("click", function()
			{
				$('.ver').slideToggle();
				$('.form').slideToggle();
			});
		</script>
	</body>
</html>
