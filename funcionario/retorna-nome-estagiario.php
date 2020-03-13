<?php
include_once("../db/conexao.php");
$nome="";
$query = "SELECT nome FROM usuarios WHERE id = '$row_events['estagiario']'";//PESQUISA TODOS OS ESTAGIÁRIOS CADASTRADOS
$result_query = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result_query))
{
    global $nome;
    //$id = $row['id'];    
    $nome = $row['nome'];    
}
?>