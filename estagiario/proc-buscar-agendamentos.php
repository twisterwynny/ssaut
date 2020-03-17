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
	$_SESSION['result_search'] = $rs;
}
elseif ($rs == 0)
{
	//echo "NÃO EXISTEM AGENDAMENTOS PARA ESTE EVENTO";
	$_SESSION['result_search'] = $rs;

}
else
{
	$_SESSION['result_search'] = $rs;
	$a_ids_agendamentos = array();
	$a_escolas = array();
	$a_turmas = array();
				 //mysqli_fetch_ARRAY();
	while($row = mysqli_fetch_assoc($result_query))
	{
		$a_ids_agendamentos[] = $row['id'];
		$a_escolas[] = $row['escola'];
		$a_turmas[] = $row['turma'];
		//$id_agendmaento = $row['id'];
		//$escola = $row['escola'];
		//$turma = $row['turma'];
		//echo "$id<BR>"; //echo "$escola<BR>";	//echo "$turma<BR>";
	}
	$_SESSION['a_ids_agendamentos'] = $a_ids_agendamentos;
	$_SESSION['a_escolas'] = $a_escolas;
	$_SESSION['a_turmas'] = $a_turmas;
}
header("Location: t-c-estagiario.php");
?>