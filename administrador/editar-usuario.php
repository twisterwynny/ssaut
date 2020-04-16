<?php
session_start();
include_once("../db/conexao.php");

$id = $_POST['idEdit'];
$nome = $_POST['nomeEdit'];
$email = $_POST['emailEdit'];
$senha = $_POST['senhaEdit'];
$fone = $_POST['foneEdit'];
$cep = $_POST['cepEdit'];
$rua = $_POST['ruaEdit'];
$numero = $_POST['numeroEdit'];
$bairro = $_POST['bairroEdit'];
$complemento = $_POST['complementoEdit'];
$ponto_referencia = $_POST['ponto_referenciaEdit'];
$cidade = $_POST['cidadeEdit'];
$estado = $_POST['estadoEdit'];
$pais = $_POST['paisEdit'];

//echo "Nome: $nome <br>"; //echo "E-mail: $email <br>";
$query = "UPDATE usuarios SET nome='$nome', email='$email', senha='$senha', fone ='$fone'
    , cep = '$cep', rua = '$rua', numero = '$numero', bairro = '$bairro', complemento = '$complemento', ponto_referencia = '$ponto_referencia', cidade = '$cidade', estado = '$estado', pais = '$pais'   
    WHERE id='$id'";
$result_query = mysqli_query($conn, $query);

if(mysqli_affected_rows($conn))
{
	$_SESSION['msg'] = "<p style='color:green;'>Você atualizou este Usuário</p>";
	header("Location: ../usuarios.php");
}
else
{
	$_SESSION['msg'] = "<p style='color:red;'>ERRO! nada foi alterado</p>";
	header("Location: ../usuarios.php");
}
?>