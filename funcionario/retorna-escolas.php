<?php
include_once("../db/conexao.php");

$query = "SELECT id, nome FROM usuarios WHERE permissao = 3";//PESQUISA TODAS AS ESCOLAS CADASTRADAS
$result_query = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result_query))
{    
    $id = $row['id'];
    $nome = $row['nome'];
    ?>
    <option value="<?php echo $row['id']; ?>"> <?php echo $row['nome']; ?> </option>
    <?php
}
?>