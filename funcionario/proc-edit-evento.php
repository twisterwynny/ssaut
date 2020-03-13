<?php
session_start();
header("Content-type: text/html; charset=utf-8");
//Incluir conexao com BD
include_once("../db/conexao.php");
$id = $_SESSION['id']; //ID do evento
$estagiario = $_SESSION['estagiario'];
$start = $_SESSION['start'];
$end = $_SESSION['end'];
//$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);//ID do evento
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$vagas = filter_input(INPUT_POST, 'vagas', FILTER_SANITIZE_NUMBER_INT);
//$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
//$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);
//$estagiario = filter_input(INPUT_POST, 'estagiario', FILTER_SANITIZE_NUMBER_INT);//ID do estagiário
$color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
/*
echo "ID = $id<BR>";
echo "title = $title<BR>";
echo "descricao = $descricao<BR>";
echo "vagas = $vagas<BR>";
echo "estagiario = $estagiario<BR>";
echo "start = $start<BR>";
echo "end = $end<BR>";
echo "color = $color<BR>";
*/
$temas = $_POST['tema'];
$alcance = $_POST['alcance'];
//$temas = $_SESSION['temas'];

$query = "SELECT id, start FROM eventos WHERE (estagiario = '$estagiario' AND title = 'Fim do Semestre')";
$result_query = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result_query);

$id_fim_semestre = $row['id'];
$_SESSION['id_fim_semestre'] = $row['id'];
$_SESSION['fim_semestre'] = $row['start'];

$_SESSION['title'] = $title;
$_SESSION['descricao'] = $descricao;
$_SESSION['vagas'] = $vagas;
$_SESSION['color'] = $color;

if(!empty($id) && !empty($title) && !empty($descricao) && !empty($vagas) && !empty($color))
{
	//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
	$data = explode(" ", $start);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$start_sem_barra = $data_sem_barra . " " . $hora;
	$_SESSION['start'] = $start_sem_barra;

	$data = explode(" ", $end);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$end_sem_barra = $data_sem_barra . " " . $hora;
	$_SESSION['end'] = $end_sem_barra;		
		
	$query = "UPDATE eventos SET title='$title', descricao='$descricao', vagas='$vagas', color='$color' WHERE (start = '$start_sem_barra' AND id <> '$id_fim_semestre')"; //SE FOR != VAI DAR ERRO. OLHE ABAIXO A RAZÃO:
	// A CLAUSULA DENTRO DOS PARANTESES CORRESPONDE A QUALQUER CHAVE PRIMARIA. SEM ELA ACONTECE ERRO 1175 PARA MUAR SAFE UPDATES NAS PREFERENCIAS DO BD.
	//UPDATE events SET title ='NOVO', vagas =777, color = "#1C1C1C" WHERE (start = "2020-01-28 22:00:00" AND id_evento <> 0);
	$result_query = mysqli_query($conn, $query);

	$query = "SELECT tema FROM temas_do_evento WHERE evento ='$id'";
	$result_query = mysqli_query($conn, $query);

	if (mysqli_affected_rows($conn))
	{
		$query = "DELETE FROM temas_do_evento WHERE evento ='$id'";
		$result_query = mysqli_query($conn, $query);
	}

	$qtd = count($temas);
	for ($i=0; $i < $qtd; $i++)
	{
		$tema_id = $temas[$i];
		$query = "INSERT INTO temas_do_evento (evento, tema) VALUES ('$id', '$tema_id')";
		$result_query = mysqli_query($conn, $query);
	}	

	//Verificar se alterou no banco de dados através "mysqli_affected_rows"
	if(mysqli_affected_rows($conn))
	{
		if ($alcance == 2)
		{		
			$id++;
			$_SESSION['id'] = $id;
			$_SESSION['temas'] = $temas;

			require_once("repete-edit-evento.php");		
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Todos os eventos com mesmo horário e foram alterados! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";				
			header("Location: t-c-gerir-eventos.php");
		}
		else
		{
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Evento alterado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";				
			header("Location: t-c-gerir-eventos.php");
		}
	}
	else
	{
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>UM Erro ao editar o evento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: t-c-gerir-eventos.php");
	}	
}
else
{
	$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>DOIS Erro ao editar o evento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	header("Location: t-c-gerir-eventos.php");
}

?>