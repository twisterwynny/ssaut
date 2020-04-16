<?php
session_start();
include_once("../db/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> Cadastrar Exposições </title>
		<link rel="stylesheet" href="./../assets/bootstrap/bootstrap.css">	
	</head>
	<body>
		<div class="container mt-3">
			<div class="row col-md-4">
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
			<div class="mt-3">
				<h1>Cadastrar Exposiçõess</h1>
				<?php
				if(isset($_SESSION['msg']))
				{
					echo $_SESSION['msg'];
					unset($_SESSION['msg']);
				}
				?>
			</div>
			<div class=" row mt-3">
				<form method="POST" action="proc-cad-exposicao.php">
					<div class="form-group">
						<label for="nome" >Nome: </label>
						<input class="form-control" type="text" id="nome" name="nome" placeholder="Digite aqui o nome da Exposição" required="" size="42">
					</div>
					<div class="form-group">
						<label for="descricao">Descrição: </label><BR>
						<textarea class="form-control" id="descricao" name="descricao"  placeholder="Digite a descrição" required="" rows="5" cols="50"></textarea>
					</div>
					<div class="form-group">
						<label for="tema">Tema da Exposição: </label><BR>
						<select class="form-control" id="tema" name="tema" required="">
							 <option value="">Selecione Aqui</option>
							<?php		
			
							$query = "SELECT id, nome FROM temas";//PESQUISA TODAS AS ESCOLAS CADASTRADAS
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
						</select>
					</div>
					<button type="submit" class="btn btn-primary" value="Cadastrar">Cadastrar</button>
				</form>				
			</div>
		</div>
	</body>
<script src="./../assets/bootstrap/jquery.js"></script>
<script src="./../assets/bootstrap/popper.js"></script>
<script src="./../assets/bootstrap/bootstrap.js"></script>
<script src="./../assets/bootstrap/bootstrap.bundle.js"></script>
</html>