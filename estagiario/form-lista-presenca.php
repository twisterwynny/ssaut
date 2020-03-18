<?php
session_start();
include_once("../db/conexao.php"); //Incluir conexao com BD
$agendamento = $_POST['agendamentos'];
$_SESSION['id_agendamento'] = $agendamento;
//echo "ID agendamento = $agendamento<BR>";
$a_ids_A = array();
$a_escolas = array();
$a_turmas = array();							
$a_ids_A = $_SESSION['a_ids_agendamentos'];
$a_escolas = $_SESSION['a_escolas'];
$a_turmas = $_SESSION['a_turmas'];
$qtd_A = count($a_ids_A);
foreach ($a_ids_A as $key => $value)
{
	//echo "ID agendamento = $value<BR>";
	if ($value == $agendamento)
	{
		//echo "ID escola = $a_escolas[$key]<BR>";
		//echo "ID turma = $a_turmas[$key]<BR>";
		$escola = $a_escolas[$key];
		$turma = $a_turmas[$key];
	}
}
$a_ids_alunos = array();
$a_nomes_alunos = array();
$query = "SELECT * FROM alunos WHERE turma = '$turma'"; 
$result_query = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_query))
{	
	$a_ids_alunos[] = $row['id'];
	$a_nomes_alunos[] = $row['nome'];
}
$i = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset='utf-8' />
		<!-- <link href="../css/index.css" rel="stylesheet"> -->  <!-- PARA CEU DE TELA INTEIRA NO FUNDO -->
		<title>Editar Eventos</title>
		<link href='../css/bootstrap.min.css' rel='stylesheet'>		
		<!-- <link href='../css/estilo.css' rel='stylesheet' /> -->
		<script src='../js/jquery.min.js'></script>
		<script src='../js/bootstrap.min.js'></script>
		<script src='../js/moment.min.js'></script>
	</head>
	<body>		
		<BR>
		<form id="editarevento" name="editarevento" method="POST" action="proc-diario.php">
			<?php			
			while (current($a_ids_alunos))			//while ($row = mysqli_fetch_assoc($result_query))
			{				
				//$nome = $row['nome'];	//$a_ids_alunos[$i] = $row['id']; //echo "$i<BR>";	
				$id = current($a_ids_alunos);
				$nome = current($a_nomes_alunos);

				//$query = "SELECT estado FROM diario WHERE (agendamento ='$agendamento' AND aluno ='$a_ids_alunos[$i]')";
				$query = "SELECT estado FROM diario WHERE (agendamento ='$agendamento' AND aluno ='$id')";
				$result_query = mysqli_query($conn, $query);
				$rs = mysqli_affected_rows($conn);
				if ($rs == (-1))
				{
					//echo "ACONTENDEU UM ERRO NA BUSCA";
				}
				elseif ($rs == 0)
				{
					?>	
					<B> ALUNO: </B>
					<?php echo "$nome";?>
			        <input type="radio" id="p<?php echo "$i";?>" name="estado[<?php echo "$i";?>]" value="1" required=""> Presente 
			        <input type="radio" id="a<?php echo "$i";?>" name="estado[<?php echo "$i";?>]" value="0" required=""> Ausente 
			        <BR>					
					<?php
					$i++;
				}
				else
				{
					?>	
					<B> ALUNO: </B>
					<?php
					echo "$nome";
					$row = mysqli_fetch_array($result_query);
					if ($row['estado'] == 1)
					{
						?>
						<input type="radio" id="p<?php echo "$i";?>" name="estado[<?php echo "$i";?>]" value="1" required="" checked="" > Presente 
						<input type="radio" id="a<?php echo "$i";?>" name="estado[<?php echo "$i";?>]" value="0" required="" > Ausente 
						<BR>
						<?php
					}
					else
					{
						?>
						<input type="radio" id="p<?php echo "$i";?>" name="estado[<?php echo "$i";?>]" value="1" required=""> Presente 
						<input type="radio" id="a<?php echo "$i";?>" name="estado[<?php echo "$i";?>]" value="0" required="" checked="" > Ausente 
						<BR>
						<?php
					}					
					$i++;
				}
				next($a_ids_alunos);
				next($a_nomes_alunos);
			}
			$_SESSION['a_ids_alunos'] = $a_ids_alunos;
			?>
			<BR>	
			<label>A Visita foi Realizada?</label>			
			<input type="radio" id="s" name="realizada" value="S" onClick="habilitacao()" required=""> SIM                        
            <input type="radio" id="i" name="realizada" value="I" onClick="habilitacao()" required="">foi interrompida
            <input type="radio" id="n" name="realizada" value="N" onClick="habilitacao()" required="">NÃO
            <BR>
            <font color="red"><B>
            	<label id="frase" name="frase" hidden="" >INFORME OS MOTIVOS: </label>
            </B></font>
            <BR>
            <textarea name="detalhes" id="detalhes" rows="5" cols="50" disabled="" required=""></textarea>
            <BR>
			<input type="hidden" class="form-control" name="escola" id="escola" value="<?php echo "$escola";?>">
			<input type="hidden" class="form-control" name="turma" id="turma" value="<?php echo "$turma";?>">
			<a href="t-c-estagiario.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
			<button type="submit" class="btn btn-success">Salvar Alterações</button>								
		</form>								
		<script language="javascript">
			function habilitacao()
			{
				if(document.getElementById('i').checked == true)
				{
					document.getElementById('frase').hidden = false;						
					document.getElementById('detalhes').disabled = false;					
					//document.getElementById('frase').disabled = false;						
					//document.getElementById("frase").style.visibility = 'visible';
				}
				if(document.getElementById('i').checked == false)
				{					
					document.getElementById('frase').hidden = true;						
					document.getElementById('detalhes').disabled = true;
					//document.getElementById('frase').disabled = true;					
					//document.getElementById("frase").style.visibility = 'hidden';
				}
			}
		</script>
	</body>
</html>	