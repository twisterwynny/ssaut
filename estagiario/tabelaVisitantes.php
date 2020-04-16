<?php

session_start();

include("../db/conexao.php");

$id_agendamento = $_GET['id'];

$sql = "select id, nome FROM alunos WHERE alunos.turma = (SELECT turma FROM agendamentos WHERE agendamentos.id = ". $id_agendamento . ")";

$result = mysqli_query($conn, $sql);
//$row	= mysql_fetch_assoc($result);

if($result)
{
    $dados_usuarios = array();
    $tam = 0;

    while( $linha = mysqli_fetch_array($result, MYSQLI_ASSOC) ){

        $dados_usuarios[] = $linha;
        $tam += 1;

    }

    $dados = [
        "total" => $tam,
        "totalNotFiltered" => $tam,
        "rows" => $dados_usuarios
    ];

    echo json_encode($dados);

}

?>