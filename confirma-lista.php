<?php
session_start();
include_once ("db/conexao.php");
$resposta = $_POST['resposta']; 
$id_lista = $_SESSION['id_lista']; 
$evento = $_SESSION['evento'];
$escola = $_SESSION['escola'];
$turma_lista = $_SESSION['turma_lista'];
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];
$qtd_alunos_lista = $_SESSION['qtd_alunos_lista'];
$qtd_alunos_agenda = $_SESSION['qtd_alunos_agenda'];

if(!empty($id_lista) && !empty($evento) && !empty($escola) && !empty($turma_lista))
{
	if($resposta == 1) 
	{	
		$query = "SELECT COUNT(id) AS ja_fez FROM agendamentos WHERE (evento='$evento' AND escola='$escola' AND turma='$turma_lista' AND confirmado = 1)";
	    $result_query = mysqli_query($conn, $query);
	    $row = mysqli_fetch_array($result_query);
	    $ja_fez = $row['ja_fez']; 
	    if ($ja_fez == 0) 
	    {
	    	$query = "INSERT INTO agendamentos (evento, escola, turma, avisado, confirmado, excluido) VALUES ('$evento', '$escola', '$turma_lista', 1, 1, 0)"; 
			$result_query = mysqli_query($conn, $query);	

			$query = "UPDATE lista_espera SET confirmado = 1 WHERE id = '$id_lista'"; 
			$result_query = mysqli_query($conn, $query);

			if ($qtd_alunos_agenda > $qtd_alunos_lista) 
			{
				$saldo = $qtd_alunos_agenda - $qtd_alunos_lista;

				$query = "SELECT vagas, vagas_abertas FROM eventos WHERE id = '$evento'"; 
				$result_query = mysqli_query($conn, $query);
				$row = mysqli_fetch_array($result_query);
				$vagas = $row['vagas'];	
				$vagas_abertas = $row['vagas_abertas'];				

				$vagas += $saldo; 
				
				$vagas_abertas -= $vagas_abertas;

				$query = "UPDATE eventos SET vagas = '$vagas', vagas_abertas = '$vagas_abertas' WHERE id = '$evento'"; 
				$result_query = mysqli_query($conn, $query);				
			}
			else
			{
				$query = "SELECT vagas_abertas FROM eventos WHERE id = '$evento'"; 
				$result_query = mysqli_query($conn, $query);
				$row = mysqli_fetch_array($result_query);
				
				$vagas_abertas = $row['vagas_abertas'];				
				
				$vagas_abertas -= $vagas_abertas;

				$query = "UPDATE eventos SET vagas_abertas = '$vagas_abertas' WHERE id = '$evento'"; 
				$result_query = mysqli_query($conn, $query);				
			}			
			
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'> Agendamento foi confirmado! Estamos aguardando você! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			unset($_SESSION['id_lista']);
			//header("Location: index.php");
		}
		else 
		{			
			$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'> Você já confirmou este agendamento. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			unset($_SESSION['id_lista']);
			//header("Location: index.php");
		}
	}
	else
	{			
		$setFromNome = "BINA";
		$assunto = "DESISTENCIA LISTA ESPERA - Antares";
		$msgEmail = "Este e-mail é para lembra-lo que você desistiu da vaga na lista de espera do evento (DADOS DO AGENDAMENTO) Mas a qualquer momento você poderá fazer novo agendamento na data e hora que melhor se adeque a sua agenda.";				
		$avisado = 0;
		require_once("fEnviarEmail.php");
		enviarEmail();

		$query = "UPDATE lista_espera SET excluido = 1 WHERE id = '$id_lista'";
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
			$query = "SELECT vagas, vagas_abertas FROM eventos WHERE id = '$evento'";			
			$result_query = mysqli_query($conn, $query);
			$row = mysqli_fetch_array($result_query);
			$vagas = $row['vagas'];	
			$vagas_abertas = $row['vagas_abertas'];

			$vagas += $qtd_alunos_agenda; 
			
			$vagas_abertas -= $vagas_abertas;

			$query = "UPDATE eventos SET vagas = '$vagas', vagas_abertas = '$vagas_abertas' WHERE id = '$evento'"; 
			$result_query = mysqli_query($conn, $query);
		}	
		unset($_SESSION['id_lista']);				
		//header("Location: index.php");	
		/* SE NÃO QUISER FAZER NOVA PROCURA DE ESCOLA E TURMA EXECUTA APENAS A DEVOLUÇÃO DAS VAGAS. CÓDIGO ESTÁ ABAIXO
		$query = "SELECT vagas FROM eventos WHERE id = '$evento'";			
		$result_query = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result_query);
		$vagas = $row['vagas'];													// ALGORITIMO VAI PROCURAR OUTRO NA LISTA DE ESPERA, SE TIVER, CHAMA, SE NÃO TIVER, DEVOLVE A VAGA

		$vagas += $qtd_alunos_agenda; // DEVOLVE A QUANTIDADE DE VAGAS QUE A TURMA DESISTIU
		$query = "UPDATE eventos SET vagas = '$vagas' WHERE id = '$evento'";
		$result_query = mysqli_query($conn, $query);		
		$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'> Obrigado por nos avisar! Você ainda pode escolher outros eventos que melhor se adequem a sua agenda. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";		
		$assunto = "DESISITIU DA LISTA ESPERA - Antares";
		$msgEmail = "Este e-mail é para informar que você foi selecionado na lista de espera mas desisitiu de participar do evento. A qualquer momento você poderá solicitar outro agendamento na data e hora que melhor se adeque a sua agenda.";		
		require_once("fEnviarEmail.php");			
		enviarEmail();
		unset($_SESSION['id_lista']);
		header("Location: index.php"); */
	}
}
else
{		
	$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'> ERRO! NADA foi confirmado <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	unset($_SESSION['id_lista']);
	//header("Location: index.php");
}
?>