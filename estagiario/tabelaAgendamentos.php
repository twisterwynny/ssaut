<?php

session_start();

include("../db/conexao.php");

$id_agendamento = 1;

$sql = "select agendamentos.id, usuarios.nome, eventos.start, eventos.end FROM agendamentos
            INNER JOIN (select * from eventos where eventos.id = agendamentos.evento)
            INNER JOIN (select * from usuarios where usuarios.id = eventos.estagiario)";

$sql = "select agendamentos.id, usuarios.nome, eventos.start, eventos.end FROM agendamentos
            INNER JOIN eventos
            INNER JOIN usuarios
            where eventos.id = agendamentos.evento AND usuarios.id = eventos.estagiario";

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