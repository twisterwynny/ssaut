<?php
header("Content-type: text/html; charset=utf-8"); // for any php files sets the default character set to be used.
$servidor = "localhost";
$usuario = "root";
$senha = "root";
$dbname = "antares";
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname); //create a connection
mysqli_set_charset($conn,"utf8"); // Sets the default character set to be used when sending data from and to the database server.
if(!$conn)
{
	die("Falha na conexao: " . mysqli_connect_error());
}
else
{
	//echo "Conexao realizada com sucesso";
}		
?>