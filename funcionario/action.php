<?php
session_start();
header("Content-type: text/html; charset=utf-8");
include_once("../db/conexao.php");

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);//ID do evento
$estagiario = filter_input(INPUT_POST, 'estagiario', FILTER_SANITIZE_NUMBER_INT);//estagiario
$nome_estagiario = filter_input(INPUT_POST, 'nome_estagiario', FILTER_SANITIZE_STRING);//estagiario
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$vagas = filter_input(INPUT_POST, 'vagas', FILTER_SANITIZE_NUMBER_INT);
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);
$color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);

$_SESSION['id'] = $id;//ID do evento
$_SESSION['estagiario'] = $estagiario;
$_SESSION['nome_estagiario'] = $nome_estagiario;
$_SESSION['title'] = $title;
$_SESSION['descricao'] = $descricao;
$_SESSION['vagas'] = $vagas;
$_SESSION['start'] = $start;
$_SESSION['end'] = $end;
$_SESSION['color'] = $color;

if(isset($_POST["c"]))
{
	//echo "botão clicado foi o inserir";
}
else if(isset($_POST["e"]))
{
	header("Location: form-editar-evento.php");	
}
else if(isset($_POST["i"]))
{
	$temas_do_evento = array();
	$nomes_dos_temas = array();
	$exposicoes_do_evento = array();
	$nomes_das_exposicoes = array();
	//$evento = $_POST["id"];

	$_SESSION['i'] = true;	

	$query = "SELECT tema FROM temas_do_evento WHERE evento ='$id'";
	$result_query = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_array($result_query))
	{
		$temas_do_evento[] = $row['tema'];
	}

	//$_SESSION['temas_do_evento'] = $temas_do_evento;

	foreach ($temas_do_evento as $key => $value)
	{
		$query = "SELECT exposicao FROM exposicoes_do_tema WHERE tema ='$value'";
		$result_query = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_array($result_query))
		{
			$exposicoes_do_evento[] = $row['exposicao'];
		}
	}

	//$_SESSION['exposicoes_do_evento'] = $exposicoes_do_evento;

	foreach ($temas_do_evento as $key => $value)
	{
		$query = "SELECT nome FROM temas WHERE id ='$value'";
		$result_query = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_array($result_query))
		{
			$nomes_dos_temas[] = $row['nome'];
		}
	}

	$_SESSION['nomes_dos_temas'] = $nomes_dos_temas;

	foreach ($exposicoes_do_evento as $key => $value)
	{
		$query = "SELECT nome FROM exposicoes WHERE id ='$value'";
		$result_query = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_array($result_query))
		{
			$nomes_das_exposicoes[] = $row['nome'];
		}
	}

	$_SESSION['nomes_das_exposicoes'] = $nomes_das_exposicoes;

	header("Location: t-c-gerir-eventos.php");
}
?>