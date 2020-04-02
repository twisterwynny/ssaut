<?php
session_start();
header("Content-type: text/html; charset=utf-8");
include_once("../db/conexao.php");

if ($_POST['turmas'])
{	 	
	//echo "botão clicado foi o inserir";
	$turma = $_POST['turmas'];
	$_SESSION['turma'] = $turma;
	//echo "<BR>$turma = TURMA<BR>";

	$query = "SELECT COUNT(*) AS total_alunos FROM alunos WHERE turma='$turma'";// CONTAR QUANTIDADE DE ALUNOS QUE TEM NA TURMA
	$result_query = mysqli_query($conn, $query); //RETORNA RESULTADO DA CONSULTA
	$row = mysqli_fetch_array($result_query);
	$QTD_alunos = $row['total_alunos'];//RETORNA E ATRIBUI QUANTIDADE DE ALUNOS PRA VARIÁVEL
	//echo "<BR>$QTD_alunos = QTD_alunos<BR>";
	$_SESSION['QTD_alunos'] = $QTD_alunos;

	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);//ID do evento
	//echo "<BR>$id  = ID EVENTO<BR>";
	$vagas = filter_input(INPUT_POST, 'vagas', FILTER_SANITIZE_NUMBER_INT);//vagas do evento
	//echo "<BR>$vagas  = vagas EVENTO<BR>";

	$_SESSION['id-evento'] = $id;
	$_SESSION['vagas'] = $vagas;
	//$escola = $_SESSION['usuarioId']; //ID da escola
	$escola = $_SESSION['escola']; //ID da escola

	//echo "<BR>$escola<BR>";
	if(isset($_POST["a"])) header("Location: proc-agendamento.php");
	else if(isset($_POST["l"])) header("Location: lista-espera.php");		
	else header("Location: mais-vagas.php");
}
else if(isset($_POST["i"]))
{	
	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);//ID do evento	
	$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
	//$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
	$vagas = filter_input(INPUT_POST, 'vagas', FILTER_SANITIZE_NUMBER_INT);	
	$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
	$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);
	$color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);

	$query = "SELECT descricao FROM eventos WHERE id ='$id'";
	$result_query = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result_query);
	$descricao = $row['descricao'];

	$_SESSION['id'] = $id;//ID do evento	
	$_SESSION['title'] = $title;
	$_SESSION['descricao'] = $descricao;
	$_SESSION['vagas'] = $vagas;		
	$_SESSION['start'] = $start;
	$_SESSION['end'] = $end;
	$_SESSION['color'] = $color;

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

	header("Location: t-c-agendamentos.php");
}
else
{
	$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'> VOCÊ NÃO SELECIONOU UMA TURMA. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	header("Location: t-c-agendamentos.php");	
}
?>