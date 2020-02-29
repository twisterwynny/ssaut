<?php
session_start();
include_once ("db/conexao.php");
$resposta = $_POST['resposta'];
$id_agendamento = $_SESSION['id_agendamento']; 
$evento = $_SESSION['evento'];
$escola = $_SESSION['escola'];
$turma_agenda = $_SESSION['turma_agenda'];
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];
if(!empty($id_agendamento) && !empty($evento) && !empty($escola) && !empty($turma_agenda))
{
	if($resposta == 1)
	{	
		$query = "SELECT COUNT(id) AS ja_fez FROM agendamentos WHERE (evento='$evento' AND escola='$escola' AND turma='$turma_agenda' AND confirmado = 1)";
	    $result_query = mysqli_query($conn, $query);
	    $row = mysqli_fetch_array($result_query);
	    $ja_fez = $row['ja_fez'];
	    if ($ja_fez == 0) 
	    {
	        $query = "UPDATE agendamentos SET confirmado = 1 WHERE id = '$id_agendamento'";
			$result_query = mysqli_query($conn, $query);
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'> Agendamento foi confirmado! Estamos aguardando você! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			unset($_SESSION['id_agendamento']); unset($_SESSION['evento']); unset($_SESSION['escola']); unset($_SESSION['turma_agenda']);
			unset($id_agendamento); unset($evento); unset($escola); unset($turma_agenda);
			//header("Location: index.php");
		}
		else
		{			
			$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'> Você já confirmou este agendamento. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			unset($_SESSION['id_agendamento']); unset($_SESSION['evento']); unset($_SESSION['escola']); unset($_SESSION['turma_agenda']);
			unset($id_agendamento); unset($evento); unset($escola); unset($turma_agenda);
			//header("Location: index.php");
		}
	}
	else 
	{		
		$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'> Obrigado por nos avisar! Você ainda pode escolher outros eventos que melhor se adequem a sua agenda. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";		
		$setFromNome = "BINA";
		$assunto = "Agendamento Cancelado pelo usuário - Antares";
		$msgEmail = "Este e-mail é para lembra-lo que você mesmo cancelou seu agendamento. (DADOS DO AGENDAMENTO) Mas a qualquer momento você poderá fazer novo agendamento na data e hora que melhor se adeque a sua agenda.";				
		$avisado = 0;
		require_once("fEnviarEmail.php");
		enviarEmail();	
		
		$query = "SELECT COUNT(*) AS qtd_alunos_agenda FROM alunos WHERE turma='$turma_agenda'";
		$result_query = mysqli_query($conn, $query); 
		$row_qtd_alunos_turma_agenda = mysqli_fetch_array($result_query);
		$qtd_alunos_agenda = $row_qtd_alunos_turma_agenda['qtd_alunos_agenda'];
		
		$vagas_abertas = $qtd_alunos_agenda;
		
		$query = "UPDATE eventos SET vagas_abertas = '$vagas_abertas' WHERE id = '$evento'"; 
		$result_query = mysqli_query($conn, $query);
		
		$query = "UPDATE agendamentos SET excluido = 1 WHERE id = '$id_agendamento'";
		$result_query = mysqli_query($conn, $query);

		$selecinou_outra_escola = false; 
		$query = "SELECT id FROM lista_espera WHERE (evento='$evento' AND avisado = 0 AND confirmado = 0 AND excluido <> 1) ORDER BY (id) ASC"; 
		$result_query_lista_espera = mysqli_query($conn, $query);
		while($row_lista_espera = mysqli_fetch_array($result_query_lista_espera)) 
		{
			$id_lista = $row_lista_espera['id'];				
			$query = "SELECT escola, turma FROM lista_espera WHERE id='$id_lista'"; 
			$result_query_dados_le = mysqli_query($conn, $query);
			$row_dados_lista_espera = mysqli_fetch_array($result_query_dados_le);
			$escola = $row_dados_lista_espera['escola'];
			$turma_lista = $row_dados_lista_espera['turma'];			
			$query = "SELECT COUNT(*) AS qtd_alunos_lista FROM alunos WHERE turma='$turma_lista'";
			$result_query = mysqli_query($conn, $query); 
			$row_total_alunos_lista = mysqli_fetch_array($result_query);
			$qtd_alunos_lista = $row_total_alunos_lista['qtd_alunos_lista'];			
			$avisado = 0;
			if($qtd_alunos_lista <= $qtd_alunos_agenda ) 
			{
				$title = $_SESSION['title'];
				$data = $_SESSION['data'];
				$hora = $_SESSION['hora'];				
				$query = "SELECT nome, email FROM usuarios WHERE id='$escola'"; 
				$result_query_usuario = mysqli_query($conn, $query);
				$row_dados_usuario = mysqli_fetch_array($result_query_usuario);
				$nome = $row_dados_usuario['nome'];
				$email = $row_dados_usuario['email'];					
				$query = "SELECT nivel, serie, nome_turma FROM turmas WHERE id='$turma_lista'";
				$result_query_turma = mysqli_query($conn, $query);		
				$row_dados_turma = mysqli_fetch_array($result_query_turma);
				$nivel_ensino = $row_dados_turma['nivel'];
				$serie = $row_dados_turma['serie'];
				$nome_turma = $row_dados_turma['nome_turma'];
				$setFromNome = "BINA";
				$assunto = "Antares - LISTA DE ESPERA";
				$msgEmail = "<BR> Olá eu sou a <B><font color='HotPink'> BINA </font></B> gestora de visitação do Antares, e você está na Lista de Espera para o evento $title no dia $data as $hora horas. <BR> O <B><font color='blue'> Etevaldo </font></B>, disse que a turma que fez o agendamento para esse evento foi <S> ABDUZIDA </S> <B><font color='red'> cancelada </font></B> e por isso estamos chamando você. Nós precisamos da confirmação para garantir a sua vaga. Você tem 24 horas para responder. <BR> <I><B><font color='gray'>Para vir conosco para nosso planeta </I></B></font> acesse o link : <a href='http://localhost:8080/form-confirma-lista.php?id_lista=$id_lista&data=$data&hora=$hora&evento=$evento&title=$title&nome=$nome&email=$email&escola=$escola&turma_lista=$turma_lista&nivel_ensino=$nivel_ensino&serie=$serie&nome_turma=$nome_turma&qtd_alunos_lista=$qtd_alunos_lista&qtd_alunos_agenda=$qtd_alunos_agenda'> ANTARES </a> <BR> <S> O CHEFE </S> nossa equipe está ansiosa para levar você para conhecer alguns mistérios do Universo. Desde já agradecemos seu interesse e compreensão.";
				require_once("fEnviarEmail.php");
				enviarEmail();				
				if ($avisado)
				{
					
					$query = "UPDATE lista_espera SET avisado = '$avisado' WHERE id = '$id_lista'"; 
					$result_query = mysqli_query($conn, $query);			
				}
				$selecinou_outra_escola = true; 
				break; 
			}
		}
		if ($selecinou_outra_escola == false) 
		{	
			$query = "SELECT vagas FROM eventos WHERE id = '$evento'";			
			$result_query = mysqli_query($conn, $query);
			$row = mysqli_fetch_array($result_query);
			$vagas = $row['vagas'];	
			$vagas += $vagas_abertas; 
			
			$vagas_abertas -= $vagas_abertas; 
			$query = "UPDATE eventos SET vagas = '$vagas', vagas_abertas = '$vagas_abertas' WHERE id = '$evento'"; 
			$result_query = mysqli_query($conn, $query);
		}	
		unset($_SESSION['id_agendamento']); unset($_SESSION['evento']); unset($_SESSION['escola']); unset($_SESSION['turma']);
		unset($id_agendamento); unset($evento); unset($escola); unset($turma);
		//header("Location: index.php");			
	}		
}
else
{	//echo "<BR>QUARTO<BR>";		
	$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'> ERRO! NADA foi confirmado <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	unset($_SESSION['id_agendamento']); unset($_SESSION['evento']); unset($_SESSION['escola']); unset($_SESSION['turma']);
	unset($id_agendamento); unset($evento); unset($escola); unset($turma);	
	//header("Location: index.php");
}
/* $query = "SELECT MIN(id) AS primeiro FROM pedidos WHERE (evento=$evento AND qtd_vagas=0)";			
$result_query = mysqli_query($conn, $query);	
$row_lista_espera = mysqli_fetch_array($result_query);
$id_lista = $row_lista_espera['primeiro']; */
?>