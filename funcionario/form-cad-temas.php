<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> Cadastrar Temas </title>	
		<link rel="stylesheet" href="./../assets/bootstrap/bootstrap.css">	
	</head>
	<body>
		<div class="container mt-5">
			<div class="row">
				<div class="col-md-4">
					<ul class="list-group">
						<li class="list-group-item list-group-item-info">
							<a href="../index.php"> HOME </a>
						</li>
						<li class="list-group-item list-group-item-info">
							<a href="form-cad-temas.php">Cadastrar Temas</a>
						</li>
						<li class="list-group-item list-group-item-info">
							<a href="form-cad-exposicoes.php">Cadastrar Exposições</a>	
						</li>
						<li class="list-group-item list-group-item-info">
							<a href="t-c-gerir-eventos.php">Gerir Eventos</a>
						</li>
					</ul>
				</div>
				<div class="container mt-4">
					<h1>Cadastrar Temas</h1>
					<?php
					if(isset($_SESSION['msg']))
					{
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}
					?>
					<div class="col-md-4">
						<form method="POST" action="proc-cad-tema.php">
							<div class="form-group">
								<label for="nome" >Nome: </label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Digite aqui o nome do Tema" required="" size="42">
							</div>
							<div class="form-group">
								<label for="descricao">Descrição: </label><BR>
								<textarea class="form-control" id="descricao" name="descricao"  placeholder="Digite a descrição" required="" rows="5" cols="50"></textarea><BR>
							</div>
							<button type="submit" class="btn btn-primary" value="Cadastrar">Confirmar identidade</button>
						</form>				
					</div>
				</div>
			</div>
		</div>

		<div class="container mt-3">
		</div>
	</body>
	<script src="./../assets/bootstrap/jquery.js"></script>
<script src="./../assets/bootstrap/popper.js"></script>
<script src="./../assets/bootstrap/bootstrap.js"></script>
<script src="./../assets/bootstrap/bootstrap.bundle.js"></script>
</html>