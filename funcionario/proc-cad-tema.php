<?php
session_start();
include_once("../db/conexao.php");
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);

if(!empty($nome) && !empty($descricao))
{		
	$query = "SELECT COUNT(id) AS ja_fez FROM temas WHERE (nome='$nome' AND descricao='$descricao')";
	$result_query = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result_query);
	$ja_fez = $row['ja_fez'];	//var_dump($ja_fez);	//echo "<BR>JA FEZ = $ja_fez<BR>";
	if($ja_fez == 0)
	{		
		$query = "INSERT INTO temas (nome, descricao) VALUES ('$nome', '$descricao')";
		$result_query = mysqli_query($conn, $query);
		if(mysqli_insert_id($conn))
		{			
			$_SESSION['msg'] = "<p style='color:green;'>Você acabou de realizar o cadastro do novo Tema</p>";		
			header("Location: form-cad-temas.php");
		}
		else
		{
			$_SESSION['msg'] = "<p style='color:red;'>NÃO foi realizado o cadadastro do Tema</p>";
			header("Location: form-cad-temas.php");				
		}					
	}
	else
	{
		$_SESSION['msg'] = "<p style='color:blue;'>Este Tema já foi cadastrado</p>";
		header("Location: form-cad-temas.php");
	}
}
else
{
	$_SESSION['msg'] = "<p style='color:red;'>ERRO! NÃO foi cadastrado o Tema</p>";
	header("Location: form-cad-temas.php");
}
?>