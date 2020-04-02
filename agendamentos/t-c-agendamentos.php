<?php
session_start();
include_once("../db/conexao.php");
if ($_SESSION['permissao'] == 2) // SE USUÁRIO É FUNCIONÁRIO
{
	//$escola = filter_input(INPUT_POST, 'escola_selecionada', FILTER_SANITIZE_NUMBER_INT);							
	//$_SESSION['escola'] = $escola;
	$escola = $_SESSION['escola'];
	echo "usuario funcionario agenda para escola = " . $_SESSION['escola'];
}
else // SE USUÁRIO É ESCOLA
{
	$escola = $_SESSION['usuarioId'];
	$_SESSION['escola'] = $escola;
	echo "usuario escola = " . $escola;
}

$query = "SELECT COUNT(id) AS qtd FROM turmas WHERE escola='$escola'"; //CONTA QUANTIDADE DE TURMAS QUE ESCOLA TEM
$result_query = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result_query);
$qtd = $row['qtd'];//RETORNA E ATRIBUI QUANTIDADE DE TURMAS PRA VARIÁVEL 
echo "<BR>QUANTIDADE DE TURMAS= " . $qtd;
if ($qtd > 0) $agendar = TRUE; // SE TIVER PELO MENOS UMA TURMA ENTÃO PERMITE AGENDAR
$query = "SELECT id, title, vagas, start, end, color FROM eventos";// PESQUISA TODOS OS EVENTOS DISPONIVEIS NO BD
$result_query = mysqli_query($conn, $query); // RETORNA PESQUISA COM RESULTADO DE TODOS OS EVENTOS DISPONIVEIS.
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset='utf-8' />
		<link href="../css/index.css" rel="stylesheet">  <!-- PARA CEU DE TELA INTEIRA NO FUNDO -->
		<title>Agenda e Eventos</title>
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
					header:
					{
						left: 'prev,next, today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					defaultDate: Date(),
					navLinks: true, // can click day/week names to navigate views
					editable: true,
					eventLimit: true, // allow "more" link when too many events
					eventClick: function(event)
					{						
						$('#ver #id').text(event.id); // SETA TEXTO ID
						$('#ver #id').val(event.id); // SETA VALOR ID						
						$('#ver #title').text(event.title);
						$('#ver #title').val(event.title);						
						$('#ver #vagas').text(event.vagas); //SETA TEXTO DAS VAGAS
						$('#ver #vagas').val(event.vagas);	//SETA QUANTIDADE DAS VAGAS // PRA CONSEGUIR ENVIAR ESSE VALOR IMPUT HIDDEN
						$('#ver #start').text(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#ver #start').val(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#ver #end').text(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#ver #end').val(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#ver #color').text(event.color);
						$('#ver #color').val(event.color);
						//PRA EXIBIR OU NÃO OS BOTÕES CORRETOS.
						var vagas = $('#ver #vagas').val(); // RETORNA QUANTIDADE DE VAGAS
						if(vagas == 0)
						{
							//document.getElementById("zero").style.visibility = 'hidden'; //OCULTA BOTÃO
							document.getElementById("zero").disabled = true; // DESABILITA BOTÃO
						}
						else
						{
							//document.getElementById("zero").style.visibility = 'visible'; // MOSTRA BOTÃO							
							document.getElementById("zero").disabled = false; // HABILITA BOTÃO
						}
						$('#ver').modal('show');//PRA EXIBIR OU NÃO OS BOTÕES CORRETOS.
						/*
						$('#ver').modal({
						  keyboard: true
						});
						*/
						return false;
					},					
					selectable: false,
					selectHelper: false,					
					events:
					[
						<?php
						while($row_events = mysqli_fetch_array($result_query))
						{// ATRIBUI OS VALORES DE CADA LINHA DA PESQUISA REALIZADA COM TODOS OS EVENTOS DISPONIVEIS.
						?>//FECHA PHP
							{
							id: '<?php echo $row_events['id']; ?>',								
							title: '<?php echo $row_events['title']; ?>',							
							vagas: '<?php echo $row_events['vagas']; ?>',
							start: '<?php echo $row_events['start']; ?>',
							end: '<?php echo $row_events['end']; ?>',
							color: '<?php echo $row_events['color']; ?>',								
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
				if(campo.value == '00/00/0000 00:00:00') campo.value = "";			 
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
					
					<?php
					if($_SESSION['permissao'] == 3)
					{						
						echo "<a href='listar-agendamentos.php'> VER TODOS OS MEUS AGENDAMENTOS </a><br>";
					}
					else
					{						
						echo "<a href='listar-agendamentos.php'> VER AGENDAMENTOS DESTA ESCOLA</a><br>";
						echo "<a href='../funcionario/buscar-agendamentos.php'> BUSCAR AGENDAMENTOS </a><br>";
					}
					?>

					<div class="container">
						<font color="white">
							<h1 class="text-center"> Escolha um Evento para Agendar sua Visita </h1>
						</font>
						<BR>
						
						<?php						
						if(isset($_SESSION['msg']))
						{
							echo $_SESSION['msg'];
							unset($_SESSION['msg']);
						}						
						?>

						<div id='calendar'></div> <!--	DIV DO CALENDÁRIO. AQUI APARECE O CALENDÁRIO-->
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center">Dados do Evento</h4>
					</div>
					<div class="modal-body">
						<div class="ver">							
							<form id="ver-evento" name="ver-evento" class="form-horizontal" method="POST" action="action.php">
								<dl class="dl-horizontal">								
									<dt>Título: </dt>
									<dd id="title"></dd>									
									<dt>Inicio do Evento: </dt>
									<dd id="start"></dd>
									<dt>Fim do Evento: </dt>
									<dd id="end"></dd>								
									<dt>Vagas: </dt>
									<dd id="vagas"></dd>
								</dl>														
								<!--								
								-->
								<?php
								//if ($agendar == TRUE) {
								if ($qtd) {	// SE DIFERENTE DE ZERO É VERDADEIRO
								?>
									<label>Escolha a Turma : </label>
									<select name="turmas" id="turmas" >
										<option value="">Selecione</option>
								<?php
									require_once("../escola/compara-select.php");									
								?>
									</select><BR><BR>
									
									<input type="hidden" class="form-control" name="id" id="id">
									<input type="hidden" class="form-control" name="title" id="title"> <!-- PARA PEGAR OS DADOS SEM EXIBIR NO FORMULÁRIO -->
									<input type="hidden" class="form-control" name="vagas" id="vagas">
									<input type="hidden" class="form-control" name="start" id="start"> <!-- PARA PEGAR OS DADOS SEM EXIBIR NO FORMULÁRIO -->
									<input type="hidden" class="form-control" name="end" id="end"> <!-- PARA PEGAR OS DADOS SEM EXIBIR NO FORMULÁRIO -->
									<input type="hidden" class="form-control" name="color" id="color"> <!-- PARA PEGAR OS DADOS SEM EXIBIR NO FORMULÁRIO -->
									<div class="form-group">
										<div class="text-center">
											<button type="submit" class="btn btn-mais-info btn-dark" name="i">Mais Informações</button>											
											<button type="submit" id="zero" class="btn btn-agenda-visita btn-success" name="a">AGENDAR</button>
											<button type="submit" class="btn btn-lista-espera btn-primary" name="l">LISTA ESPERA</button>
											<button type="submit" class="btn btn-solicitar-vagas btn-warning" name="v">PEDIR VAGAS</button>
											<button type="button" class="btn btn-cancela-turma btn-secondary" data-dismiss="modal">SAIR</button>
											<!-- <button type="submit" class="btn btn-ok btn-success">OK</button>											
											<button type="submit" class="btn btn-primary">Lista Espera</button>
											<button type="submit" class="btn btn-warning">Solicitar Vagas</button>
											<a href='lista-espera.php' class='btn btn-primary'>Lista Espera </a>
											<a href='mais-vagas.php' class='btn btn-warning '>Solicitar Vagas</a> -->
										</div>
									</div>								
								<?php
								}
								//else {
								//if (!$qtd) {
								?>
								<!--
									<div class='alert alert-warning' role='alert'>
										<H7>
											Para realizar qualquer agendamento é necessário cadastrar a Turma (com seus respectivos Alunos) que deseja levar para fazer a visita. Retorne ao menu inicial, OU, clique no botão da direita											
											<a href="../escola/form-cad-turma.php" class="btn btn-success pull-right">Cadastar Turmas e Alunos</a>
										</H7>										
									</div>									
								-->
								<?php // IDEIA COLOCAR header("Location:  AQUI E EXIBIR A MENSAGEM POR SESSION NA PAGINA DE CADASTRO DE TURMAS E ALUNOS
								//}
								?>
							</form>						
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Informações Adicionais</h4>
                    </div>
                    <div class="modal-body">
                        <?php
                        $descricao = $_SESSION['descricao'];
                        $nomes_dos_temas = $_SESSION['nomes_dos_temas'];
                        $nomes_das_exposicoes = $_SESSION['nomes_das_exposicoes'];   
                        //echo "TEMAS:<BR>";	<label for="title">Título: </label>                        
                        ?>
                        <label>DESCRIÇÃO: </label><BR>
                        <?php
                        echo nl2br($descricao);
                        //echo $descricao;
                        ?>
                        <BR><BR>
                        <label>TEMA(S): </label><BR>
                        <?php
                        foreach ($nomes_dos_temas as $key => $value)
                        {
                        	echo "$value<BR>";
                        }
                        //echo "EXPOSIÇÕES:<BR>";	<label for="title">Título: </label>
                        ?>
                        <BR><BR>
                        <label>EXPOSIÇÕES: </label><BR>
                        <?php
                        foreach ($nomes_das_exposicoes as $key => $value)
                        {
                        	echo "$value<BR>";
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                    	<div class="text-center">
	                        <!-- <a href="pagar.php"><button type="button" class="btn btn-primary">Pagar Agora</button></a> -->
	                        <button type="button" class="btn btn-fechar-mais-info-evento btn-secondary" data-dismiss="modal">FECHAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!--         -->	
        <div class="modal fade" id="modal-funcionario-agendou" tabindex="-1" role="dialog" aria-labelledby="modal-funcionario-agendou" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">                        
                        <h4 class="modal-title" id="myModalLabel">Deseja Continuar Agendando para Esta mesma Escola?</h4>
                    </div>
                    <div class="modal-body">
                        <div class='alert alert-success' role='alert'> Agendamento realizado com sucesso! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>
                    </div>
                    <div class="modal-footer">
                        <a href="../funcionario/encontrar-escola-usuario.php"><button type="button" class="btn btn-primary">Escolher outra escola</button></a>
                        <a href=""><button type="button" class="btn btn-success" data-dismiss="modal">Continuar com esta escola</button></a>
                        <a href="../index.php"><button type="button" class="btn btn-secondary">Isso é tudo. Terminar agora</button></a>
                    </div>
                </div>
            </div>
        </div>

        <?php		
		if(isset($_SESSION['funcionario_agendou']))
		{
		?>
			<script>
				$(document).ready(function()
				{
					$('#modal-funcionario-agendou').modal('show');
				});
			</script>
		<?php
		}
		?>
		<?php
        if (isset($_SESSION['i']))
        {
            ?>
            <script>
                $(document).ready(function()
                {
                    $('#info').modal('show');
                });
            </script>
        <?php
        unset($_SESSION['i']); // POR SEGURANÇA        
        }
        ?>
        <script>			
			$('.btn-fechar-mais-info-evento').on("click", function()
			{				
				var id = "<?php echo $_SESSION['id'];?>"				
				var title = "<?php echo $_SESSION['title'];?>"				
				var vagas = "<?php echo $_SESSION['vagas'];?>"
				var start = "<?php echo $_SESSION['start'];?>"
				var end = "<?php echo $_SESSION['end'];?>"
				var color = "<?php echo $_SESSION['color'];?>"
				$('#ver #id').text(id);
				$('#ver #id').val(id);				
				$('#ver #title').text(title);
				$('#ver #title').val(title);				
				$('#ver #vagas').text(vagas);
				$('#ver #vagas').val(vagas);
				$('#ver #start').text(start);
				$('#ver #start').val(start);
				$('#ver #end').text(end);
				$('#ver #end').val(end);
				$('#ver #color').text(color);
				$('#ver #color').val(color);
				$('#ver').modal('show');
			});
		</script>
		<script>
			/*
			$('.btn-agenda-visita').on("click", function() {
				$('.form').slideToggle();
				$('.ver').slideToggle();
			});
			$('.btn-cancela-turma').on("click", function() {
				$('.ver').slideToggle();
				$('.form').slideToggle();
			});
			$('.btn-lista-espera').on("click", function() {
				$('.form').slideToggle();
				$('.ver').slideToggle();
			});
			$('.btn-solicitar-vagas').on("click", function() {
				$('.form').slideToggle();
				$('.ver').slideToggle();
			});
			*/
		</script>

		<div class="modal fade" id="modal-nao-tem-turma" tabindex="-1" role="dialog" aria-labelledby="modal-funcionario-agendou" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                	<div class="text-center">
	                    <div class="modal-header">                        
	                        <h4 class="modal-title" id="myModalLabel">Você não cadastrou nenhuma Turma</h4>
	                    </div>
	                </div>
                    <div class="modal-body">
                        <div class='alert alert-warning' role='alert'>
							<H7>
								Para realizar qualquer agendamento é necessário cadastrar a Turma (com seus respectivos Alunos) que deseja levar para fazer a visita. Retorne ao menu inicial, OU, clique no botão abaixo:								
							</H7>										
						</div>
                    </div>
                    <div class="modal-footer">
                    	<div class="text-center">
                    		<a href="../escola/form-cad-turma.php" class="btn btn-success">Cadastar Turmas e Alunos</a>                        
                    	</div>
                    </div>
                </div>
            </div>
        </div>

        <?php		
		if($qtd == 0)
		{
		?>
			<script>
				$(document).ready(function()
				{
					$('#modal-nao-tem-turma').modal('show');
				});
			</script>
		<?php
		}
		?>		
	</body>
</html>