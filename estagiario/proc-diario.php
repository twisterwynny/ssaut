<?php
session_start();
include_once("../db/conexao.php"); //Incluir conexao com BD
$a_ids_alunos = array();
$a_estado = array();
$a_ids_alunos = $_SESSION['a_ids_alunos'];
$id_agendamento = $_SESSION['id_agendamento'];
$a_estado = $_POST['estado'];
$escola = $_POST['escola'];
$turma = $_POST['turma'];
$realizada = $_POST['realizada'];
//echo "$realizada<BR>";
if (isset($_POST['observacoes']))
{
	$observacoes = $_POST['observacoes'];
	//echo "$observacoes<BR>";
}

if(!empty($a_ids_alunos) && !empty($a_estado) && !empty($escola) && !empty($turma) && !empty($id_agendamento))
{            
    $id_turma = mysqli_insert_id($conn);

    while (current($a_ids_alunos))
    {
    	$id_aluno = current($a_ids_alunos);
        $estado_aluno = current($a_estado);

        $query = "SELECT COUNT(id) AS ja_fez FROM diario WHERE (agendamento='$id_agendamento' AND aluno='$id_aluno')";
	    $result_query = mysqli_query($conn, $query);
	    $row = mysqli_fetch_array($result_query);
	    $ja_fez = $row['ja_fez'];

	    if ($ja_fez == 0)
	    {
	    	$query = "INSERT INTO diario (agendamento, aluno, estado) VALUES ('$id_agendamento', '$id_aluno', '$estado_aluno')";
        	$result_query = mysqli_query($conn, $query);        	
	    }
	    else
	    {
	    	$query = "UPDATE diario SET estado='$estado_aluno' WHERE (agendamento='$id_agendamento' AND aluno='$id_aluno')";
	    	$result_query = mysqli_query($conn, $query);
	    }        
        next($a_ids_alunos);
        next($a_estado);
    }    
    $query = "SELECT COUNT(id) AS ja_fez FROM visitas WHERE (agendamento='$id_agendamento')";
    $result_query = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result_query);
    $ja_fez = $row['ja_fez'];

    if ($ja_fez == 0)
    {
    	if (isset($observacoes))
	    {
	    	$query = "INSERT INTO visitas (agendamento, realizada, observacoes) VALUES ('$id_agendamento', '$realizada', '$observacoes')";
    		$result_query = mysqli_query($conn, $query);
	    }
	    else
	    {
	    	$query = "INSERT INTO visitas (agendamento, realizada) VALUES ('$id_agendamento', '$realizada')";
    		$result_query = mysqli_query($conn, $query);
	    }    	        	
    }
    else
    {
    	if (isset($observacoes))
	    {
	    	$query = "UPDATE visitas SET realizada='$realizada', observacoes='$observacoes' WHERE (agendamento='$id_agendamento')";
    		$result_query = mysqli_query($conn, $query);
    	}
    	else
    	{
    		$query = "UPDATE visitas SET realizada='$realizada', observacoes='' WHERE (agendamento='$id_agendamento')";
    		$result_query = mysqli_query($conn, $query);
    	}
    }
}
header("Location: t-c-estagiario.php");
?>