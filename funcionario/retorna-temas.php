<?php
//header("Content-type: text/html; charset=utf-8");
include_once("../db/conexao.php");
$id = $_SESSION['id'];
//echo "SEGUNDA PAG<BR>";
$query = "SELECT * FROM temas";
$result_query = mysqli_query($conn, $query);
$ids_temas = array();
$nomes_temas = array();
$a_temas_do_evento = array();

while ($row = mysqli_fetch_array($result_query))
{	
	$ids_temas[] = $row['id'];
	$nomes_temas[] = $row['nome'];
}

$query = "SELECT tema FROM temas_do_evento WHERE evento ='$id'";
$result_query = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result_query))
{	
	$a_temas_do_evento[] = $row['tema'];	
}

if (mysqli_affected_rows($conn))
{	
	//echo "os temas do evento são: <BR>";
	$aux = 0;
	$total_temas = count($ids_temas);
	$qtd_temas_evento = count($a_temas_do_evento);
	//echo "$total_temas<BR>";
	//echo "$qtd_temas_evento<BR>";	
	for ($i=0; $i < $total_temas; $i++)
	{
		if ($aux < $qtd_temas_evento)
		{
			if ($ids_temas[$i] == $a_temas_do_evento[$aux])
			{
				?>
				<input type="checkbox" id="tema" name="tema[]" value="<?php echo $ids_temas[$i]; ?>" checked=""> <?php echo $nomes_temas[$i] . "<BR>"; ?>
				<?php
				$aux++;
			}
			else
			{
				?>
				<input type="checkbox" id="tema" name="tema[]" value="<?php echo $ids_temas[$i]; ?>" > <?php echo $nomes_temas[$i] . "<BR>"; ?>
				<?php
			}
		}
		else
		{
			?>
			<input type="checkbox" id="tema" name="tema[]" value="<?php echo $ids_temas[$i]; ?>" > <?php echo $nomes_temas[$i] . "<BR>"; ?>
			<?php
		} 			
	}	
}
else
{
	//echo "não achou tema no evento <BR>";
	$total_temas = count($ids_temas);
	for ($i=0; $i < $total_temas; $i++)
	{ 
		?>
		<input type="checkbox" id="tema" name="tema[]" value="<?php echo $ids_temas[$i]; ?>" checked=""> <?php echo $nomes_temas[$i] . "<BR>"; ?>
		<?php
	}	
}
?>