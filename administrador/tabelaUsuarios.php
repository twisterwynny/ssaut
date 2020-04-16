<?php

session_start();

include("../db/conexao.php");

$sql = "select * from usuarios";

$result = mysqli_query($conn, $sql);
//$row	= mysql_fetch_assoc($result);

if($result)
{
    $dados_usuarios = array();
    $tam = 0;

    while( $linha = mysqli_fetch_array($result, MYSQLI_ASSOC) ){

        if( $linha['permissao'] == 1 )
            $linha['permissao'] = 'Estagiário';
        else if( $linha['permissao'] == 2 )
            $linha['permissao'] = 'Funcionário';
        else if( $linha['permissao'] == 3 )
            $linha['permissao'] = 'Escola';
        else if( $linha['permissao'] == 4 )
            $linha['permissao'] = 'Administrador';

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