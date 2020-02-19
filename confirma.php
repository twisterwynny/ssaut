<?php
session_start();
//include_once ("../db/conexao.php");
include_once ("db/conexao.php");

$resposta = $_POST['resposta'];

$id_agendamento = $_SESSION['id_agendamento'];
$evento = $_SESSION['evento'];
$escola = $_SESSION['escola'];
$turma = $_SESSION['turma'];
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];

if(!empty($id_agendamento) && !empty($evento) && !empty($escola) && !empty($turma))
{
	if($resposta == 1)
	{
		$query = "SELECT COUNT(id) AS ja_fez FROM agendamentos WHERE (evento='$evento' AND escola='$escola' AND turma='$turma' AND confirmado = 1)";
	    $result_query = mysqli_query($conn, $query);
	    $row = mysqli_fetch_array($result_query);
	    $ja_fez = $row['ja_fez'];
	    
	    //echo "ja fez<BR>";
	    //var_dump($ja_fez);

	    if ($ja_fez == 0)
	    {
	        $query = "UPDATE agendamentos SET confirmado = 1 WHERE id = '$id_agendamento'";			
			$result_query = mysqli_query($conn, $query);

			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'> Agendamento foi confirmado! Estamos aguardando você! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			header("Location: index.php");
		}
		else
		{
			//echo "<BR>TERCEIRO<BR>";
			$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'> Você já confirmou este agendamento. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			header("Location: index.php");
		}
	}
	else
	{
		$query = "DELETE FROM agendamentos WHERE id = '$id_agendamento'";			
		$result_query = mysqli_query($conn, $query);
		//echo "<BR>TERCEIRO<BR>";
		$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'> Obrigado por nos avisar! Você ainda pode escolher outros eventos que melhor se adequem a sua agenda. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		$assunto = "Agendamento Cancelado - Antares";
		$msgEmail = "Este e-mail é para informar que seu agendamento foi cancelado mas que a qualquer momento você poderá solicitar outro na data e hora que melhor se adeque a sua agenda.";
		require_once("fEnviarEmail.php");
		enviarEmail();
		header("Location: index.php");		
	}
}
else
{
	//echo "<BR>QUARTO<BR>";		
	$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'> ERRO! NADA foi confirmado <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	header("Location: index.php");
}

?>