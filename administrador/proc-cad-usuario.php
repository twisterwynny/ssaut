<?php
session_start();
include_once("../db/conexao.php");
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); //EMAIL
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$permissao = filter_input(INPUT_POST, 'permissao', FILTER_SANITIZE_NUMBER_INT); //NIVEL ACESSO
$fone = filter_input(INPUT_POST, 'fone', FILTER_SANITIZE_STRING);
$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
$rua = filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_STRING);
$numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);
$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
$complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
$ponto_referencia = filter_input(INPUT_POST, 'ponto_referencia', FILTER_SANITIZE_STRING);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
$pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
$fim_semestre = $_POST["fim_semestre"];
if(!empty($nome) && !empty($email) && !empty($senha) && !empty($permissao) && !empty($fone) && !empty($cep) && !empty($rua) && !empty($numero) && !empty($bairro) && !empty($complemento) && !empty($ponto_referencia) && !empty($cidade) && !empty($estado) && !empty($pais))
{		
	$query = "SELECT COUNT(id) AS ja_fez FROM usuarios WHERE email='$email'";
	$result_query = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result_query);
	$ja_fez = $row['ja_fez'];	//var_dump($ja_fez);	//echo "<BR>JA FEZ = $ja_fez<BR>";
	if($ja_fez == 0)
	{
		$query = "SELECT COUNT(id) AS ja_fez FROM usuarios WHERE (nome='$nome' AND email='$email' AND permissao='$permissao' AND fone='$fone' AND cep='$cep' AND rua='$rua' AND numero='$numero' AND bairro='$bairro' AND complemento='$complemento' AND ponto_referencia='$ponto_referencia' AND cidade='$cidade' AND estado='$estado' AND pais='$pais')";
		$result_query = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result_query);
		$ja_fez = $row['ja_fez'];
		if($ja_fez == 0)
		{
			$query = "INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais)
								VALUES ('$nome', '$email', '$senha', '$permissao', '$fone', '$cep', '$rua', '$numero', '$bairro', '$complemento', '$ponto_referencia', '$cidade', '$estado', '$pais')";
			$result_query = mysqli_query($conn, $query);
			if ($permissao == 1)
			{				
				$estagiario = mysqli_insert_id($conn); // ID DO ESTAGIARIO				
				$datahora_start = $fim_semestre . " 00:00:00"; // PARA FICAR NO FORMATO DATETIME DO SQL								
				$timestamp_end = strtotime($datahora_start . "+1 days"); // ++ 24h
				$datahora_end = date('Y-m-d H:i:s', $timestamp_end);// PARA FICAR NO FORMATO DATETIME DO SQL				
				$descricao = "Data em que acaba o as aulas deste estagiário específico. Essa informação é importante para todas as verificações no sistema.";	
				$query = "INSERT INTO eventos (estagiario, title, descricao, vagas, vagas_abertas, start, end, color) VALUES ('$estagiario', 'Fim do Semestre', '$descricao', 0, 0, '$datahora_start', '$datahora_end', '#FF0000')";	
				$result_query = mysqli_query($conn, $query);				
				if(mysqli_insert_id($conn))
				{
					//$_SESSION['estagiario'] = $estagiario;
					//$_SESSION['fim_semestre'] = $datahora_start;
					$_SESSION['msg'] = "<p style='color:green;'>Você acabou de realizar o cadastro do novo Usuário</p>";
					//header("Location: estagiario/t-c-horarios-estagiario.php");
					header("Location: ./usuarios.php");
				}
				else
				{
					$_SESSION['msg'] = "<p style='color:red;'>NÃO foi realizado o cadadastro do Usuário</p>";
					header("Location: ./usuarios.php");
				}				
			}
			if(mysqli_insert_id($conn))
			{
				$_SESSION['msg'] = "<p style='color:green;'>Você acabou de realizar o cadastro do novo Usuário</p>";
				header("Location: ./usuarios.php");				//header("Location: ../index.php");
			}
			else
			{
				$_SESSION['msg'] = "<p style='color:red;'>NÃO foi realizado o cadadastro do Usuário</p>";
				header("Location: ./usuarios.php");
			}			
		}
		else
		{
			$_SESSION['msg'] = "<p style='color:blue;'>Este Usuário já foi cadastrado</p>";
			header("Location: ./usuarios.php");
		}
	}
	else
	{		
		$_SESSION['msg'] = "<p style='color:blue;'>Já existe um Usuário cadastrado com esse E-mail. Tente outro E-mail</p>";
		header("Location: ./usuarios.php");
	}
}
else
{
	$_SESSION['msg'] = "<p style='color:red;'>ERRO! NÃO foi cadastrado o Usuário</p>";
	header("Location: ./usuarios.php");
}
?>