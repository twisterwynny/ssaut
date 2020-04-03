--Para o Estagiário:
--Estagiario ver os nomes dos visitantes de um determinado evento:
SELECT nome FROM alunos WHERE alunos.turma = (SELECT turma FROM agendamentos WHERE agendamentos.id = 1);
--trocar o "1" pelo id do evento que ele selecionar


--Para o Funcionário:
--Disponibilidade dos horarios dos estágiários
SELECT c.nome, eventos.start, eventos.end FROM eventos INNER JOIN (SELECT id,nome FROM usuarios WHERE usuarios.permissao = 1) c WHERE eventos.estagiario = c.id ORDER BY c.nome;

--Agendamentos castrado de visitantes
