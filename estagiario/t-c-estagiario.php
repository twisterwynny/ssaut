<?php
session_start();
include_once("../db/conexao.php");
$id = $_SESSION['usuarioId'];
//$query = "SELECT id, estagiario, title, descricao, vagas, start, end, color FROM eventos WHERE (estagiario='$id')";
$query = "SELECT id, estagiario, title, vagas, start, end, color FROM eventos WHERE (estagiario='$id')";
$result_query = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset='utf-8' />
		<link href="../css/index.css" rel="stylesheet">  <!-- PARA CEU DE TELA INTEIRA NO FUNDO -->
		<title>Gerenciar Visitações</title>
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
					navLinks: false, // can click day/week names to navigate views
					editable: true,
					eventLimit: true, // allow "more" link when too many events
					eventClick: function(event)
					{						
						$('#visualizar #id').text(event.id);
						$('#visualizar #id').val(event.id);						
						$('#visualizar #estagiario').text(event.estagiario);
						$('#visualizar #estagiario').val(event.estagiario);
						$('#visualizar #title').text(event.title);
						//$('#visualizar #descricao').text(event.descricao);
						$('#visualizar #vagas').text(event.vagas);
						$('#visualizar #start').text(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #start').val(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #end').text(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #end').val(event.end.format('DD/MM/YYYY HH:mm:ss'));						
						$('#visualizar #color').val(event.color);
						$('#visualizar').modal('show');
						return false;
					},					
					selectable: false,
					selectHelper: false,					
					events:
					[
						<?php
						while($row = mysqli_fetch_array($result_query))
						{
						?>
							{
							id: '<?php echo $row['id']; ?>',
							estagiario: '<?php echo $row['estagiario']; ?>',
							title: '<?php echo $row['title']; ?>',
							//descricao: '<?php // echo $row['descricao']; ?>',
							vagas: '<?php echo $row['vagas']; ?>',
							start: '<?php echo $row['start']; ?>',
							end: '<?php echo $row['end']; ?>',
							color: '<?php echo $row['color']; ?>',								
							},
						<?php
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

					<div class="container">
						<font color="white">
							<h1 class="text-center"> Gerenciar Visitações </h1>
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

		<div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center">Buscar Agendamentos para Evento?</h4>
					</div>
					<div class="modal-body">
						<div class="visualizar">
							<form class="form-horizontal" method="POST" action="proc-buscar-agendamentos.php">
							<dl class="dl-horizontal">
								<dt> ID do Horário </dt>
								<dd id="id"></dd>								
								<dt> ID do Estagiário </dt>
								<dd id="estagiario"></dd>								
								<dt> Data e Hora de Inicio </dt>
								<dd id="start"></dd>
								<dt> Data e Hora do Fim </dt>
								<dd id="end"></dd>								
							</dl>
							<input type="hidden" class="form-control" name="id" id="id">							
							<div class="text-center" >
								<button type="button" class="btn btn-canc-buscar btn-secondary" data-dismiss="modal">cancelar</button>
								<button type="submit" class="btn btn-success">BUSCAR</button>
							</div>
						</div>
						</form>						
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="ver_agendamentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Agendamentos do Evento</h4>
                    </div>
                    <div class="modal-body">
                    	<form class="form-horizontal" method="POST" action="form-lista-presenca.php">
	                        <?php
	                        if ($_SESSION['result_search'] == (-1) )
	                        {
	                        	echo "ACONTENDEU UM ERRO NA BUSCA";	                        	
	                        }
	                        elseif ($_SESSION['result_search'] == 0 )
	                        {
	                        	echo "NÃO EXISTEM AGENDAMENTOS PARA ESTE EVENTO";	                        	
	                        }						
							else
							{
								$a_ids_A = array();
								$a_escolas = array();
								$a_turmas = array();
								$a_dados_turmas = array();
								$a_ids_A = $_SESSION['a_ids_agendamentos'];
								$a_escolas = $_SESSION['a_escolas'];
								$a_nomes_escolas = $_SESSION['a_nomes_escolas'];
								$a_turmas = $_SESSION['a_turmas'];
								$a_dados_turmas = $_SESSION['a_dados_turmas'];
								$qtd_A = count($a_ids_A);	
								?>
								<div class="text-center" >
								<label>Escolha o Agendamento: </label><BR>
								<select name="agendamentos" id="agendamentos" required="">
									<option value="">Selecione</option>
									<?php
									for ($i=0; $i < $qtd_A; $i++)
									{ 
										?>
										<option value="<?php echo $a_ids_A[$i]; ?>"> <?php echo "Escola: " . $a_nomes_escolas[$i] . " |" . " Turma: " . $a_dados_turmas[$i] ?></option>
										<?php
									}									
									?>
								</select><BR><BR>
								<?php
							}
							?>
							</div>
							<div class="text-center" >
		                        <button type="button" class="btn btn-fechar-mais-info-evento btn-secondary" data-dismiss="modal">FECHAR</button>
	                        	<button type="submit" class="btn btn-success"id="print" >VER LISTA</button>
                        	</div>							
						</form>
						<?php
                        if ($_SESSION['result_search'] > 0)
                        {
                        	?>
                        	<script type="text/javascript">
                        		//document.getElementById("print").style.visibility = 'visible'; //MOSTRA BOTÃO
                        		document.getElementById("print").disabled = false; // HABILITA BOTÃO
                        	</script>	                        	
                        	<?php
                        }
                        else
                        {
                        	?>
                        	<script type="text/javascript">
                        		//document.getElementById("print").style.visibility = 'hidden'; //OCULTA BOTÃO
                        		document.getElementById("print").disabled = true; // DESABILITA BOTÃO
                        	</script>	                        	
                        	<?php
                        }
	                    ?>
                    </div>                    
                </div>
            </div>
        </div>

		<?php
        if (isset($_SESSION['result_search']))
        {
            ?>
            <script>
                $(document).ready(function()
                {
                    $('#ver_agendamentos').modal('show');
                });
            </script>
        <?php
        unset($_SESSION['result_search']); // POR SEGURANÇA        
        }
        ?>		
		<script>			
		</script>
	</body>
</html>