<?php
include_once("../db/conexao.php");
$query = "SELECT * FROM temas";//PESQUISA TODAS AS ESCOLAS CADASTRADAS
$result_query = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result_query))
{
	?>
	<input type="checkbox" id="tema" name="tema[]" value="<?php echo $row['id']; ?>" checked=""> <?php echo $row['nome'] . "<BR>"; ?>
	<?php
}
?>