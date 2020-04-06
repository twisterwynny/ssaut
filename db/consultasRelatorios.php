<?php  
	include("conexao.php");

	//Para Estagiário saber os visitantes de um agendamento
	function getNomeVisitantes($id_agendamento) : array{
		$sql = "select nome FROM alunos WHERE alunos.turma = (SELECT turma FROM agendamentos WHERE agendamentos.id = ". $id_agendamento ;
		$result = mysqli_query($sql);
		$row	= mysql_fetch_assoc($result);

		return $row;
	}

	//Para funcionário saber os horários dos estagiários
	function getHorarioEstagiario() : array{
		$sql 	= "select c.nome, eventos.start, eventos.end FROM eventos INNER JOIN (SELECT id,nome FROM usuarios WHERE usuarios.permissao = 1) c WHERE eventos.estagiario = c.id ORDER BY c.nome";
		$result = mysqli_query($sql);
		$row	= mysql_fetch_assoc($result);

		return $row;
	}

	//Para funcionário saber os visitantes por agendamento
	function getVisitantes($id_agendamento) : array{
		$sql 	= "select usuarios.nome, turmas.nome_turma, eventos.start FROM usuarios INNER JOIN turmas INNER JOIN eventos INNER JOIN (SELECT escola, turma, evento FROM agendamentos WHERE id = " . $id_agendamento . ") c WHERE usuarios.id = c.escola AND turmas.id = c.turma AND  eventos.id = c.evento;"
		$result = mysqli_query($sql);
		$row	= mysql_fetch_assoc($result);

		return $row;
	}


?>