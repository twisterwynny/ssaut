<?php
session_start();
include_once("../db/conexao.php"); //Incluir conexao com BD
$turma = $_POST['agendamentos'];
$query = "SELECT * FROM alunos WHERE turma = '$turma'"; 
$result_query = mysqli_query($conn, $query);
$a_alunos = array();
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
			while ($row = mysqli_fetch_assoc($result_query))
			{				
				$nome = $row['nome'];
				$a_alunos[$i] = $row['id'];
				//echo "$i<BR>";	
				?>	
				<B> ALUNO: </B>
				<?php echo "$nome";?>
		        <input type="radio" id="p<?php echo "$i";?>" name="estado[<?php echo "$i";?>]" value="1" required=""> Presente 
		        <input type="radio" id="a<?php echo "$i";?>" name="estado[<?php echo "$i";?>]" value="0" required=""> Ausente 
		        <BR>					
				<?php
				$i++;				
			}
			$_SESSION['a_alunos'] = $a_alunos;
			?>					
			<a href="t-c-estagiario.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
			<button type="submit" class="btn btn-success">Salvar Alterações</button>								
		</form>								
		<script>	    				
	    </script>	
	</body>
</html>	