<?php
session_start();
unset($_SESSION['e']); // POR SEGURANÇA
header("Content-type: text/html; charset=utf-8");
include_once("../db/conexao.php");
$id = $_SESSION['id'];//ID do evento
$estagiario = $_SESSION['estagiario'];//estagiario
$nome_estagiario = $_SESSION['nome_estagiario'];//nome estagiario
$title = $_SESSION['title'];
$descricao = $_SESSION['descricao'];
$vagas = $_SESSION['vagas'];
$start = $_SESSION['start'];
$end = $_SESSION['end'];
$color = $_SESSION['color'];
$ac = str_split($descricao);
$cs = "";
foreach ($ac as $key => $value)
{
	if (ord($ac[$key]) != 13)
	{
		if (ord($ac[$key]) != 10)
		{			
			$cs .= $value;
		}
		else
		{
			$cs .= "\\n";			
		}
	}
	else
	{
		$cs .= "\\r";		
	}
}
/*  */
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
		<script>
			function marcar_todos()
			{
				for (i=0; i<document.editarevento.elements.length; i++)
					if(document.editarevento.elements[i].type == "checkbox")	
						document.editarevento.elements[i].checked=1
			}
			function desmarcar_todos()
			{
				for (i=0; i<document.editarevento.elements.length; i++)
					if(document.editarevento.elements[i].type == "checkbox")	
						document.editarevento.elements[i].checked=0
			}
		</script>
	</head>
	<body>		
		<BR>
		<form id="editarevento" name="editarevento" method="POST" action="proc-edit-evento.php">				
			<div class="text-center">
				<label for="id">ID evento: </label> <?php echo $id;?>
				<label>ID estagiário: </label> <?php echo $estagiario;?>
				<BR>
				<label>NOME estagiário: </label> <?php echo $nome_estagiario;?>				
				<!-- <input type="text" readonly class="form-control-plaintext" placeholder="Input só de leitura, aqui..." size="2"> -->				
				<div>				
					<label for="title">Título: </label>				
				</div>
				<div>
					<input type="text" name="title" id="title" placeholder="Titulo do Evento" value="<?php echo $title; ?>" size="33" required="">				
				</div>	
				<div>		
					<label for="descricao">Descrição: </label>
				</div>
				<div>			    	
			    	<!-- <input style="height:200px" type="text" name="descricao" id="descricao" placeholder="Descrição do Evento" value="<?php //echo $descricao; ?>"> -->
			    	<textarea name="descricao" id="descricao" rows="5" cols="50" required=""></textarea>
			    </div>				    
			    <BR>
				<div>			
					<label for="vagas">VAGAS: </label>										
					<input type="text" name="vagas" id="vagas" placeholder="digite a quantidade de vagas" value="<?php echo $vagas; ?>" size="1" required="">
					<label for="color" >Cor: </label>				
					<select name="color" id="color" required="">
						<option value="">Selecione</option>
						<option style="color:#FF69B4;" value="#FF69B4">HotPink</option>
						<option style="color:#FF0000;" value="#FF0000">Red</option>
						<option style="color:#FF6347;" value="#FF6347">Orange</option>
						<option style="color:#FFD700;" value="#FFD700">Yellow</option>
						<option style="color:#32CD32;" value="#32CD32">LimeGreen</option>
						<option style="color:#006400;" value="#006400">Green</option>
						<option style="color:#00FFFF;" value="#00FFFF">Cyan</option>
						<option style="color:#0000FF;" value="#0000FF">Blue</option>											
						<option style="color:#8B4513;" value="#8B4513">SaddleBrown</option>	
						<option style="color:#808080;" value="#808080">Gray</option>	
						<option style="color:#000000;" value="#000000">Black</option>	
						<option style="color:#9370DB;" value="#9370DB">MediumPurple</option>	
						<option style="color:#4B0082;" value="#4B0082">Indigo</option>
					</select>				
				</div>				
				<BR>		
				<div>																						
					<label> Defina o(s) Tema(s): </label><BR>
					<a href="javascript:marcar_todos()">TODOS</a> ou <a href="javascript:desmarcar_todos()">NENHUM</a><BR>								 			
	 				<?php
					require_once("retorna-temas.php");			// <div class="col-sm-10"> <div class="text-center">
					//require_once("retorna-exposicoes.php");	// <div class="col-sm-10"> <div class="text-center">
					?>									
				</div>	
				<BR>
				<div>                
                	<label for="alcance" > Alcance das Alterações: </label>
                </div>              
                <div>              
	                <input type="radio" id="all" name="alcance" value="2" class="radio-grande" required=""> TODOS os Eventos com mesmo Horário
	                <BR>
	                <input type="radio" id="this" name="alcance" value="1" class="radio-grande" required="">SÓ este Evento
            	</div>	
            	<BR>	
            	<script>
			    	$(function()
			    	{
					   var descricao = "<?php echo $cs; ?>";
					   $("#descricao").val(descricao);
					});					
			    </script>
			    <script>			    	
					$(function()
					{
					   var color = "<?php echo $color; ?>";
					   $("#color").val(color);
					});					
			    </script>
				<div>					
					<a href="t-c-gerir-eventos.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
					<button type="submit" class="btn btn-success">Salvar Alterações</button>					
				</div>			
			</div>
		</form>								
		<script>	    				
	    </script>	
	</body>
</html>