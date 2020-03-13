<?php
session_start();
include_once("../db/conexao.php");
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
//echo "Nome: $nome <br>"; //echo "E-mail: $email <br>";
$query = "UPDATE exposicoes SET nome='$nome', descricao='$descricao' WHERE id='$id'";
$result_query = mysqli_query($conn, $query);
if(mysqli_affected_rows($conn))
{
	$_SESSION['msg'] = "<p style='color:green;'>Você atualizou esta Exposição</p>";
	header("Location: gerir-eventos.php");
}
else
{
	$_SESSION['msg'] = "<p style='color:red;'>ERRO! nada foi alterado</p>";
	header("Location: form-editar-expoicao.php?id=$id");
}
?>