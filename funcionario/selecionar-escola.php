<?php
session_start();
include_once "../db/conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> <!-- essa linha é o CSS do bootstrap frameworkd-->		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> <!-- as 3 linhas abaixo são JS do bootstrap frameworkd-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>		
		<title> Selecionar Escola </title>		
	</head>
	<body>
		<a href="../index.php" class="col-sm-5" >HOME</a><br>

		<div class="form-group">
			<form method="POST" action="../agendamentos/t-c-agendamentos.php">													
				<font color="red">
					<label for="escola_selecionada" class="control-label col-sm-5">Para qual Escola é o Agendamento? Selecione abaixo: </label>									
				</font>			
				<div class="row col-sm-5">
					<div class="col-sm-5">
						<select class="form-control" id="escola_selecionada" name="escola_selecionada" required="">
		 					<option value="">Selecione Aqui</option>
				 				<?php
								require_once("../funcionario/retorna-escolas.php");//	<div class="col-sm-10">
								?>
						</select>
					</div>
					<div class="col-sm-5">
						<input type="submit" value="OK">										
					</div>
				</div>				
			</form>
		</div>		
	</body>
</html>