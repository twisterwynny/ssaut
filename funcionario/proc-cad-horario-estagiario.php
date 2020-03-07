<?php
session_start();
include_once("../db/conexao.php");//Incluir conexao com BD

$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);
$estagiario = $_POST['estagiario'];//ID do estagiário selecionado

if(!empty($start) && !empty($end) && !empty($estagiario))
{	//Converter a data e hora do formato brasileiro para o formato do Banco de Dados	
	$data = explode(" ", $start);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$start_sem_barra = $data_sem_barra . " " . $hora;	
	
	$data = explode(" ", $end);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$end_sem_barra = $data_sem_barra . " " . $hora;	

	if (strtotime($end_sem_barra) > strtotime($start_sem_barra))
	{
		$_SESSION['start']=$start_sem_barra;
		$_SESSION['end']=$end_sem_barra;				

		$query = "SELECT COUNT(id) AS ja_fez FROM eventos WHERE (estagiario='$estagiario' AND start='$start_sem_barra' AND end='$end_sem_barra')";
		$result_query = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result_query);
		$ja_fez = $row['ja_fez'];

		if ($ja_fez == 0)
		{
			$query = "SELECT start FROM eventos WHERE (estagiario = '$estagiario' AND title = 'Fim do Semestre')";
			$result_query = mysqli_query($conn, $query);
			$row = mysqli_fetch_array($result_query);
			//$estagiario = $_SESSION['estagiario']; //ID do estagiário					
			$_SESSION['fim_semestre'] = $row['start'];
			$_SESSION['estagiario'] = $estagiario;

			$query = "INSERT INTO eventos (estagiario, start, end, vagas_abertas) VALUES ('$estagiario', '$start_sem_barra', '$end_sem_barra', 0)";
			$result_query = mysqli_query($conn, $query);				
			//Verificar se salvou no banco de dados através "mysqli_insert_id" o qual verifica se existe o ID do último dado inserido
			if(mysqli_insert_id($conn))
			{
				require_once("repete-cad-horario-estagiario.php");
				$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Seu Horário foi Registrado com Sucesso! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
				header("Location: t-c-gerir-estagiarios.php");
			}
			else
			{
				$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>ERRO! seu horário NÃO foi registrado.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
				header("Location: t-c-gerir-estagiarios.php");
			}
		}
		else
		{
			$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>Esta Data e Horário já foi registrado. Tente outra Data e Hora diferentes. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			header("Location: t-c-gerir-estagiarios.php");
		}
	}
	else
	{
		$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'> a Data/Hora do FIM do evento precisa ser depois ou maior do que a Data/Hora do INICIO do evento. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: t-c-gerir-estagiarios.php");
	}			
}
else
{
	$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>ERRO! seu horário NÃO foi registrado<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	header("Location: t-c-gerir-estagiarios.php");
}

?>