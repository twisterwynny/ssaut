<?php
session_start();
include_once("../db/conexao.php");

$id = $_POST['id'];

if(!empty($id))
{
	$query = "DELETE FROM usuarios WHERE id='$id'";
	$result_query = mysqli_query($conn, $query);
	if(mysqli_affected_rows($conn))
	{
		$_SESSION['msg'] = "<p style='color:green;'>Você excluiu este Usuário</p>";
		header("Location: gerir-usuarios.php");
	}
	else
	{
		$_SESSION['msg'] = "<p style='color:red;'>OPERAÇÃO NÃO FOI REALIZADA</p>";
		header("Location: gerir-usuarios.php");
	}
}
else
{
	$_SESSION['msg'] = "<p style='color:red;'>Primeiro Escolha um Usuário</p>";
	header("Location: gerir-usuarios.php");
}
?>