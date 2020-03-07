<?php
session_start();

//Incluir conexao com BD
include_once("../db/conexao.php");

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);//ID do evento
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);
$estagiario = filter_input(INPUT_POST, 'estagiario', FILTER_SANITIZE_NUMBER_INT);//ID do estagiário
//echo "$id<BR>";
//echo "$estagiario<BR>";
//echo "$start<BR>";
//echo "$end<BR>";
$query = "SELECT id, start FROM eventos WHERE (estagiario = '$estagiario' AND title = 'Fim do Semestre')";
$result_query = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result_query);

$id_fim_semestre = $row['id'];
$_SESSION['id_fim_semestre'] = $row['id'];
$_SESSION['fim_semestre'] = $row['start'];
$_SESSION['estagiario'] = $estagiario;
$_SESSION['id'] = $id;
//echo "$id_fim_semestre<BR>";
//echo "fim_semestre = " . $_SESSION['fim_semestre']."<BR>";

if(!empty($id) && !empty($start) && !empty($end) && !empty($estagiario))
{
	//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
	$data = explode(" ", $start);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$start_sem_barra = $data_sem_barra . " " . $hora;
	$_SESSION['start'] = $start_sem_barra;
	//echo "$start_sem_barra<BR>";

	$data = explode(" ", $end);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$end_sem_barra = $data_sem_barra . " " . $hora;
	$_SESSION['end'] = $end_sem_barra;		
		
	//echo "$end_sem_barra<BR>";
	$result_events = "UPDATE eventos SET start='$start_sem_barra', end='$end_sem_barra' WHERE id='$id'";
	$resultado_events = mysqli_query($conn, $result_events);	
	//SE FOR != VAI DAR ERRO. OLHE ABAIXO A RAZÃO:
	// A CLAUSULA DENTRO DOS PARANTESES CORRESPONDE A QUALQUER CHAVE PRIMARIA. SEM ELA ACONTECE ERRO 1175 PARA MUAR SAFE UPDATES NAS PREFERENCIAS DO BD.
	//UPDATE events SET title ='NOVO', vagas =777, color = "#1C1C1C" WHERE (start = "2020-01-28 22:00:00" AND id_evento <> 0);
	
	
	//Verificar se alterou no banco de dados através "mysqli_affected_rows"
	if(mysqli_affected_rows($conn))
	{
		require_once("repete-edit-horario-estagiario.php");		
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>O Evento editado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";				
		header("Location: t-c-gerir-estagiarios.php");
	}
	else
	{
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>UM Erro ao editar o evento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: t-c-gerir-estagiarios.php");
	}	
}
else
{
	$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>DOIS Erro ao editar o evento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	header("Location: t-c-gerir-estagiarios.php");
}

?>