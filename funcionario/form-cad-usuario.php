<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> Cadastrar Usuário </title>		
	</head>
	<body>
		<a href="../index.php"> HOME </a><br>
		<a href="form-cad-usuario.php">Cadastrar Usuário</a><br>
		<a href="form-listar-usuarios.php">Listar Usuários</a><br>
		<a href="form-buscar-usuarios.php">Buscar Usuários</a><br>
		<h1>Cadastrar Usuário</h1>

		<?php
		if(isset($_SESSION['msg']))
		{
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>

		<form method="POST" action="proc-cad-usuario.php">
			<label>Nome: </label>
			<input type="text" name="nome" placeholder="Digite aqui seu nome" required=""><br><br>
			
			<label>E-mail: </label>
			<input type="email" name="email" placeholder="Digite aqui seu e-mail" required=""><br><br>

			<label>Senha: </label>
			<input type="text" name="senha" placeholder="APENAS 4 DÍGITOS ALFANUMÉRICOS" required=""><br><br>

			<label>Telefone: </label>
			<input type="text" name="fone" placeholder="Digite aqui seu Telefone" required=""><br><br>

			<label>E N D E R E Ç O : </label><BR></BR>

			<label>CEP: </label>
			<input type="text" name="cep" placeholder="Digite aqui o CEP" required=""><br><br>

			<label>Rua/Avenida/Caminho: </label>
			<input type="text" name="rua" placeholder="Digite aqui o Logradouro" required=""><br><br>

			<label>Número: </label>
			<input type="text" name="numero" placeholder="Digite aqui o número da casa/prédio" required=""><br><br>

			<label>Bairro/Conjunto: </label>
			<input type="text" name="bairro" placeholder="Digite aqui o Bairro/Conjunto" required=""><br><br>

			<label>Complemento: </label>
			<input type="text" name="complemento" placeholder="Digite aqui o Complemento" required=""><br><br>

			<label>Ponto de Referência: </label>
			<input type="text" name="ponto_referencia" placeholder="Digite aqui o Ponto de Referência" required=""><br><br>

			<label>Cidade: </label>
			<input type="text" name="cidade" placeholder="Digite aqui a Cidade" required=""><br><br>

			<label>Estado/UF: </label>
			<input type="text" name="estado" placeholder="Digite aqui o Estado/UF" required=""><br><br>

			<label>País: </label>
			<input type="text" name="pais" placeholder="Digite aqui o País" required=""><br><br>

			<label>Nível de Acesso: </label><BR>
			<input type="radio" id="estagiario" name="permissao" value="1" onClick="habilitacao()" required="">
			<label for="estagiario"> Estagiário </label><br />
			<input type="radio" id="funcionario" name="permissao" value="2" onClick="habilitacao()" required="">
			<label for="funcionario"> Funcionário </label><br />
			<input type="radio" id="escola" name="permissao" value="3" onClick="habilitacao()" required="">
			<label for="escola"> Escola </label><br />
			<!--
			<input type="radio" id="adm" name="permissao" value="4" required=""/>
			<label for="adm"> Administrador </label><br />
			-->			
			<label>Data do Fim do Semestre: </label>
			<input type="date" name="fim_semestre" id="fim_semestre" maxlength="10" disabled="" required="">
			<BR>
			<label id="frase" style.visibility="hidden" > Se marcar "Estagiário" é obrigatório informar a data do Fim do Semestre </label>
			<BR>
			<input type="submit" value="Cadastrar">
		</form>
		<script language="javascript">
			function habilitacao()
			{
				if(document.getElementById('estagiario').checked == true)
				{
					document.getElementById('fim_semestre').disabled = false;					
					//document.getElementById('frase').disabled = false;						
					//document.getElementById("frase").style.visibility = 'visible';
				}
				if(document.getElementById('estagiario').checked == false)
				{					
					document.getElementById('fim_semestre').disabled = true;
					//document.getElementById('frase').disabled = true;					
					//document.getElementById("frase").style.visibility = 'hidden';
				}
			}
		</script>		
	</body>
</html>
<!--
Estagiário: <input type="radio" name="permissao" checked="yes" /><br />
Funcionário: <input type="radio" name="permissao" /><br />
Escola: <input type="radio" name="permissao" />
Administrador: <input type="radio" name="permissao" />
-->
<!--
<input type="radio" id="estagiario" name="permissao" value="1" checked="yes" required=""/>
-->