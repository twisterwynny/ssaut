<?php
include_once("../db/conexao.php");
//$id = $_SESSION['id'];
//echo "SEGUNDA PAG<BR>";
$query = "SELECT * FROM exposicoes";
$result_query = mysqli_query($conn, $query);
$ids_exposicoes = array();
$nomes_exposicoes = array();
$a_exposicoes_do_tema = array();

while ($row = mysqli_fetch_array($result_query))
{	
	$ids_exposicoes[] = $row['id'];
	$nomes_exposicoes[] = $row['nome'];
}

//$query = "SELECT exposicao FROM exposicoes_do_tema WHERE tema ='$tema'";
$query = "SELECT exposicao FROM exposicoes_do_tema WHERE tema = 3";
$result_query = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result_query))
{	
	$a_exposicoes_do_tema[] = $row['exposicao'];	
}

if (mysqli_affected_rows($conn))
{	
	echo "as exposicoes do tema são: <BR>";
	$aux = 0;
	$total_exposicoes = count($ids_exposicoes);
	$qtd_exposicoes_tema = count($a_exposicoes_do_tema);
	//echo "$total_exposicoes<BR>";
	//echo "$qtd_exposicoes_tema<BR>";	
	for ($i=0; $i < $total_exposicoes; $i++)
	{
		if ($aux < $qtd_exposicoes_tema)
		{
			if ($ids_exposicoes[$i] == $a_exposicoes_do_tema[$aux])
			{
				?>
				<input type="checkbox" id="exposicao" name="exposicao[]" value="<?php echo $ids_exposicoes[$i]; ?>" checked=""> <?php echo $nomes_exposicoes[$i] . "<BR>"; ?>
				<?php
				$aux++;
			}
			else
			{
				?>
				<input type="checkbox" id="exposicao" name="exposicao[]" value="<?php echo $ids_exposicoes[$i]; ?>" > <?php echo $nomes_exposicoes[$i] . "<BR>"; ?>
				<?php
			}
		}
		else
		{
			?>
			<input type="checkbox" id="exposicao" name="exposicao[]" value="<?php echo $ids_exposicoes[$i]; ?>" > <?php echo $nomes_exposicoes[$i] . "<BR>"; ?>
			<?php
		} 			
	}	
}
else
{
	echo "não achou exposicoes do tema <BR>";
	$total_exposicoes = count($ids_exposicoes);
	for ($i=0; $i < $total_exposicoes; $i++)
	{ 
		?>
		<input type="checkbox" id="exposicao" name="exposicao[]" value="<?php echo $ids_exposicoes[$i]; ?>" checked=""> <?php echo $nomes_exposicoes[$i] . "<BR>"; ?>
		<?php
	}	
}

?>