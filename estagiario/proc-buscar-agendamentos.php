<?php
session_start();
include_once("../db/conexao.php"); //Incluir conexao com BD
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);//ID do evento
$query = "SELECT id, escola, turma FROM agendamentos WHERE (evento = '$id' AND confirmado = 1)"; 
$result_query = mysqli_query($conn, $query);
$rs = mysqli_affected_rows($conn);
$_SESSION['result_search'] = $rs;
if ($rs == (-1))
{
	//echo "ACONTENDEU UM ERRO NA BUSCA";
	//$_SESSION['result_search'] = $rs;
}
elseif ($rs == 0)
{
	//echo "NÃO EXISTEM AGENDAMENTOS PARA ESTE EVENTO";
	//$_SESSION['result_search'] = $rs;
}
else
{
	//$_SESSION['result_search'] = $rs;
	$a_ids_agendamentos = array();
	$a_escolas = array();
	$a_nomes_escolas = array();
	$a_turmas = array();
	$a_series = array();
	$a_nomes_turmas = array();
	$a_dados_turmas = array();
	$frase = "";
				 //mysqli_fetch_ARRAY();
	while($row = mysqli_fetch_assoc($result_query))
	{
		$a_ids_agendamentos[] = $row['id'];
		$a_escolas[] = $row['escola'];
		$a_turmas[] = $row['turma'];		
	}
	foreach ($a_escolas as $key => $value)
	{
		$query = "SELECT nome FROM usuarios WHERE (id = '$value')"; 
		$result_query = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result_query);
		$a_nomes_escolas[] = $row['nome'];
	}
	foreach ($a_turmas as $key => $value)
	{
		$query = "SELECT serie, nome_turma FROM turmas WHERE id='$value'";
		$result_query = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result_query);
		$a_series[] = $row['serie'];
		$a_nomes_turmas[] = $row['nome_turma'];
	}	
	foreach ($a_series as $key => $value)
	{
		$serie = $value;		
		require_once("../escola/retorna-nivel-serie.php");		
		traduzDadosTurma ();		
		$a_dados_turmas[] = $frase . $a_nomes_turmas[$key];
	}	
	$_SESSION['a_ids_agendamentos'] = $a_ids_agendamentos;
	$_SESSION['a_escolas'] = $a_escolas;
	$_SESSION['a_nomes_escolas'] = $a_nomes_escolas;
	$_SESSION['a_turmas'] = $a_turmas;
	$_SESSION['a_dados_turmas'] = $a_dados_turmas;
}
header("Location: t-c-estagiario.php");
?>