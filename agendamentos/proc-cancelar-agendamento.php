<?php
session_start();
include_once("../db/conexao.php");
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$evento = filter_input(INPUT_GET, 'evento', FILTER_SANITIZE_NUMBER_INT);
$turma_agenda = filter_input(INPUT_GET, 'turma', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id) && !empty($evento) && !empty($turma_agenda))
{
	//$query = "DELETE FROM agendamentos WHERE id='$id'";
	$query = "UPDATE agendamentos SET excluido = 1 WHERE id = $id";
	$result_query = mysqli_query($conn, $query);

	$query = "SELECT COUNT(*) AS qtd_alunos_agenda FROM alunos WHERE turma='$turma_agenda'";// CONTAR QUANTIDADE DE ALUNOS QUE TEM NA TURMA QUE DESISTIU
	$result_query = mysqli_query($conn, $query); 
	$row_qtd_alunos_turma_agenda = mysqli_fetch_array($result_query);
	$qtd_alunos_agenda = $row_qtd_alunos_turma_agenda['qtd_alunos_agenda'];// COMO ESCOLA DESITIU, ENTÃO AS VAGAS QUE ESTAVAM OCUPADAS FICAM DISPONÍVEIS PRA SEREM PREENCHIDAS

	//$query = "SELECT vagas_abertas FROM eventos WHERE id = '$evento'";			
	$query = "SELECT vagas FROM eventos WHERE id = '$evento'"; // PESQUISA A QUANTIDADE DE VAGAS DO EVENTO			
	$result_query = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result_query);
	//$vagas_abertas = $row['vagas_abertas'];
	$vagas = $row['vagas'];

	//$vagas_abertas += $qtd_alunos_agenda; // 
	$vagas += $qtd_alunos_agenda; // DEVOLVE AS VAGAS QUE FICARAM DISPONÍVEIS PARA O EVENTO

	//$query = "UPDATE eventos SET vagas_abertas = '$vagas_abertas' WHERE id = '$evento'"; 
	$query = "UPDATE eventos SET vagas = '$vagas' WHERE id = '$evento'"; //REGISTRA A QUANTIDADE DE VAGAS ATUAL NO EVENTO
	$result_query = mysqli_query($conn, $query);

	if(mysqli_affected_rows($conn))
	{
		$_SESSION['msg'] = "<p style='color:green;'>Agendamento foi cancelado</p>";
		header("Location: listar-agendamentos.php");
	}
	else
	{		
		$_SESSION['msg'] = "<p style='color:red;'>OPERAÇÃO NÃO FOI REALIZADA</p>";
		header("Location: listar-agendamentos.php");
	}
}
else
{	
	$_SESSION['msg'] = "<p style='color:red;'>Primeiro Escolha um Agendamento</p>";
	header("Location: listar-agendamentos.php");
}
?>