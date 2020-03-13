<?php
session_start();
include_once("../db/conexao.php");
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
//echo "Nome: $nome <br>"; //echo "E-mail: $email <br>";
$query = "UPDATE usuarios SET nome='$nome', email='$email', senha='$senha' WHERE id='$id'";
$result_query = mysqli_query($conn, $query);
if(mysqli_affected_rows($conn))
{
	$_SESSION['msg'] = "<p style='color:green;'>Você atualizou este Usuário</p>";
	header("Location: gerir-usuarios.php");
}
else
{
	$_SESSION['msg'] = "<p style='color:red;'>ERRO! nada foi alterado</p>";
	header("Location: editar-usuario.php?id=$id");
}
?>