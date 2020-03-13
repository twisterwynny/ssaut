<?php
session_start();
include_once("../db/conexao.php");
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$tema = $_POST['tema'];

if(!empty($nome) && !empty($descricao) && !empty($tema))
{		
	$query = "SELECT COUNT(id) AS ja_fez FROM exposicoes WHERE (nome='$nome' AND descricao='$descricao')";
	$result_query = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result_query);
	$ja_fez = $row['ja_fez'];	//var_dump($ja_fez);	//echo "<BR>JA FEZ = $ja_fez<BR>";
	if($ja_fez == 0)
	{		
		$query = "INSERT INTO exposicoes (nome, descricao) VALUES ('$nome', '$descricao')";
		$result_query = mysqli_query($conn, $query);
		
		if($exposicao = mysqli_insert_id($conn))
		{			
			$query = "INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES ('$tema', '$exposicao')";
			$result_query = mysqli_query($conn, $query);		
			$_SESSION['msg'] = "<p style='color:green;'>Você acabou de realizar o cadastro da nova Exposição</p>";
			header("Location: form-cad-exposicoes.php");
		}
		else
		{
			$_SESSION['msg'] = "<p style='color:red;'>NÃO foi realizado o cadadastro da Exposição</p>";
			header("Location: form-cad-exposicoes.php");				
		}					
	}
	else
	{
		$_SESSION['msg'] = "<p style='color:blue;'>Esta Exposição já foi cadastrada</p>";
		header("Location: form-cad-exposicoes.php");
	}
}
else
{
	$_SESSION['msg'] = "<p style='color:red;'>ERRO! NÃO foi cadastrada Exposição</p>";
	header("Location: form-cad-exposicoes.php");
}
?>