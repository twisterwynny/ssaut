-- CREATE DATABASE antares DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
-- USE AUEFS;
USE antares;

CREATE TABLE IF NOT EXISTS usuarios (
	id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL,
    senha VARCHAR(4) NOT NULL,
    permissao INT NOT NULL,
    fone VARCHAR(20) NOT NULL,
    cep VARCHAR(10) NOT NULL,
    rua VARCHAR(100) NOT NULL,
    numero VARCHAR(6) NOT NULL,
    bairro VARCHAR(50) NOT NULL,
    complemento VARCHAR(50) NOT NULL,
    ponto_referencia VARCHAR(100) NOT NULL,
    cidade VARCHAR(50) NOT NULL,
    estado VARCHAR(25) NOT NULL,
    pais VARCHAR(25) NOT NULL,
    excluido INT
	-- fim_semestre datetime -- PODE SER NULO pois nem todo usuário tem uma data de fim de semestre.
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS turmas (
	id INT AUTO_INCREMENT PRIMARY KEY,
    escola INT NOT NULL,
    nivel INT NOT NULL,
    serie INT NOT NULL,
    nome_turma VARCHAR(1) NOT NULL, -- para deferenciar duas turmas de mesmo nível e mesma série. pode ser 1º ano A, 1º ano B por exemplo. pode ser nulo, caso a escola não tenha duas turmas da mesma série
    data_criacao DATE NOT NULL, -- para saber a data em que a turma foi criada. isso ajuda no futuro pra saber se a turma ainda está ativa ou não. pois, normalmente as turmas duram no máximo 6 meses ou 1 ano   
    FOREIGN KEY (escola) REFERENCES usuarios (id)
)   ENGINE = innodb;

CREATE TABLE IF NOT EXISTS alunos (
	id INT AUTO_INCREMENT PRIMARY KEY,    
    nome VARCHAR(250) NOT NULL,
    data_nascimento DATE NOT NULL, -- sugestão: trocar por data de nascimento para facilitar o calculo automático de idade.
    escola INT NOT NULL,
    turma INT NOT NULL,    
    FOREIGN KEY (escola) REFERENCES usuarios (id), -- chave estrangeira para saber de que escola é o aluno
    FOREIGN KEY (turma) REFERENCES turmas (id) -- chave estrangeira para saber de que turma é o aluno
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS prof_resp (
	id INT AUTO_INCREMENT PRIMARY KEY,    
    nome VARCHAR(250) NOT NULL,
    cargo_funcao INT NOT NULL, -- sugestão: trocar por data de nascimento para facilitar o calculo automático de idade.
    escola INT NOT NULL,
    turma INT NOT NULL,    
    FOREIGN KEY (escola) REFERENCES usuarios (id), -- chave estrangeira para saber de que escoal é o professor ou responável
	FOREIGN KEY (turma) REFERENCES turmas (id) -- chave estrangeira para saber de que turma é o professor ou responsável
)	ENGINE = innodb;

-- CREATE TABLE IF NOT EXISTS horarios (id INT AUTO_INCREMENT PRIMARY KEY, estagiario INT NOT NULL, start datetime NOT NULL, end datetime NOT NULL) ENGINE = innodb;

CREATE TABLE IF NOT EXISTS eventos (
	id INT AUTO_INCREMENT PRIMARY KEY,
    estagiario INT NOT NULL,
    title VARCHAR(100), -- VARIÁVEL DO FULL CALENDAR NÃO PODE MUDAR O NOME
    descricao VARCHAR(500),
    vagas INT,
    vagas_abertas INT NOT NULL, -- inicia com valor 0 (zero) e, caso alguma escola não confirme, as vagas dela vão para essa coluna
    start datetime NOT NULL, -- VARIÁVEL DO FULL CALENDAR NÃO PODE MUDAR O NOME
    end datetime NOT NULL, -- VARIÁVEL DO FULL CALENDAR NÃO PODE MUDAR O NOME
    color VARCHAR(10), -- VARIÁVEL DO FULL CALENDAR NÃO PODE MUDAR O NOME
    FOREIGN KEY (estagiario) REFERENCES usuarios (id)
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS agendamentos (
	id INT AUTO_INCREMENT PRIMARY KEY,
    evento INT NOT NULL,
    escola INT NOT NULL,
    turma INT NOT NULL,
    avisado INT,
    confirmado INT NOT NULL,
    excluido INT,
    FOREIGN KEY (evento) REFERENCES eventos (id),
    FOREIGN KEY (escola) REFERENCES usuarios (id),
    FOREIGN KEY (turma) REFERENCES turmas (id)        
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS diario (
	id INT AUTO_INCREMENT PRIMARY KEY,
    agendamento INT NOT NULL,
    aluno INT NOT NULL,    
    estado INT,    -- 1 para PRESENTE / 0 para AUSENTE    
    FOREIGN KEY (agendamento) REFERENCES agendamentos (id),
    FOREIGN KEY (aluno) REFERENCES alunos (id)    
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS visitas (
	id INT AUTO_INCREMENT PRIMARY KEY,
    agendamento INT NOT NULL,   
    realizada CHAR, -- SE A VIISTA FOI REALIZADA RECEBE 'S' SE NÃO FOI REALIZADA RECEBE 'N' SE FOI INTERROMPIDA RECEBE 'I'
    observacoes VARCHAR(1000),
    FOREIGN KEY (agendamento) REFERENCES agendamentos (id)    
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS lista_espera (
	id INT AUTO_INCREMENT PRIMARY KEY,
    evento INT NOT NULL,
    escola INT NOT NULL,
    turma INT NOT NULL,    
    qtd_alunos_turma INT NOT NULL, -- se QTD_VAGAS == 0, então o pedido é para entrar na lista de espera, caso contrário, então o pedido é de abertura de mais vagas    
    avisado INT NOT NULL,
    confirmado INT NOT NULL,
    excluido INT,
    -- data_hora DATETIME NOT NULL,
    FOREIGN KEY (evento) REFERENCES eventos (id),
    FOREIGN KEY (escola) REFERENCES usuarios (id),
    FOREIGN KEY (turma) REFERENCES turmas (id) -- ADICIONAR NOVA COLUNA data-hora DATETIME NOT NULL para determinar quem fez o pedido primeiro    
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS mais_vagas (
	id INT AUTO_INCREMENT PRIMARY KEY,
    evento INT NOT NULL,
    escola INT NOT NULL,
    turma INT NOT NULL,    
    qtd_alunos_turma INT NOT NULL, -- se QTD_VAGAS == 0, então o pedido é para entrar na lista de espera, caso contrário, então o pedido é de abertura de mais vagas
    excluido INT,
    -- data_hora DATETIME NOT NULL,
    FOREIGN KEY (evento) REFERENCES eventos (id),
    FOREIGN KEY (escola) REFERENCES usuarios (id),
    FOREIGN KEY (turma) REFERENCES turmas (id)    -- ADICIONAR NOVA COLUNA data-hora DATETIME NOT NULL para determinar quem fez o pedido primeiro    
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS temas (
	id INT AUTO_INCREMENT PRIMARY KEY,    
    nome VARCHAR(100), 
    descricao VARCHAR(1000)    
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS exposicoes (
	id INT AUTO_INCREMENT PRIMARY KEY,    
    nome VARCHAR(100), 
    descricao VARCHAR(1000)    
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS temas_do_evento (	
	id INT AUTO_INCREMENT PRIMARY KEY,    
    evento INT,        
    tema INT,        
    FOREIGN KEY (evento) REFERENCES eventos (id),
    FOREIGN KEY (tema) REFERENCES temas (id)
)	ENGINE = innodb;

CREATE TABLE IF NOT EXISTS exposicoes_do_tema (	
	id INT AUTO_INCREMENT PRIMARY KEY,    
    tema INT,        
    exposicao INT,        
    FOREIGN KEY (tema) REFERENCES temas (id),
    FOREIGN KEY (exposicao) REFERENCES exposicoes (id)
)	ENGINE = innodb;

INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Eu", "eu@eu.eu", "123", 1, "09358521", "44085-000", "nasceu aqui", 9, "sei lá", "não tem", "se vira", "FSA", "BA", "BRASIL");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Tu", "tu@tu.tu", "123", 2, "88729518", "77558-880", "KDJF K", 1, "ÁI DON NOU", "DON RAVI", "NOS TRINTA", "WHATS", "GO", "ARGENTINA");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Vc", "vc@vc.vc", "123", 3, "09358521", "00177-066", "GRINGO", 8, "!!!!!!!", "MONEY", "$$$$$", "VEGAS", "CALIFORNICATION", "USA");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Adm", "a@a.a", "123", 4, "0987654321", "88750-321", "SAKJ", 3, "AAAAAAAAAA", "DINHEIRO", "@@@@@", "LONDRINA", "PARANÁ", "NOVA DELI");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Estagiario Um", "i1@i.i", "123", 1, "09358521", "44085-000", "nasceu aqui", 9, "sei lá", "não tem", "se vira", "FSA", "BA", "BRASIL");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Estagiario Dois", "i2@i.i", "123", 1, "88729518", "77558-880", "KDJF K", 1, "ÁI DON NOU", "DON RAVI", "NOS TRINTA", "WHATS", "GO", "ARGENTINA");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Funcionario Um", "stf1@stf.stf", "123", 2, "09358521", "00177-066", "GRINGO", 8, "!!!!!!!", "MONEY", "$$$$$", "VEGAS", "CALIFORNICATION", "USA");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Funcionario Dois", "stf2@stf.stf", "123", 2, "0987654321", "88750-321", "SAKJ", 3, "AAAAAAAAAA", "DINHEIRO", "@@@@@", "LONDRINA", "PARANÁ", "NOVA DELI");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Escola Um", "viniciusvieira.eu@gmail.com", "123", 3, "09358521", "44085-000", "nasceu aqui", 9, "sei lá", "não tem", "se vira", "FSA", "BA", "BRASIL");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Escola Dois", "wynny.eu@gmail.com", "123", 3, "88729518", "77558-880", "KDJF K", 1, "ÁI DON NOU", "DON RAVI", "NOS TRINTA", "WHATS", "GO", "ARGENTINA");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Adm UM", "a1@a.a", "123", 4, "09358521", "00177-066", "GRINGO", 8, "!!!!!!!", "MONEY", "$$$$$", "VEGAS", "CALIFORNICATION", "USA");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("Adm DOIS", "a2@a.a", "123", 4, "0987654321", "88750-321", "SAKJ", 3, "AAAAAAAAAA", "DINHEIRO", "@@@@@", "LONDRINA", "PARANÁ", "NOVA DELI");
INSERT INTO usuarios (nome, email, senha, permissao, fone, cep, rua, numero, bairro, complemento, ponto_referencia, cidade, estado, pais) VALUES ("TATAS SCHOOL", "geisekatty@hotmail.com", "123", 3, "88729518", "77558-880", "KDJF K", 1, "ÁI DON NOU", "DON RAVI", "NOS TRINTA", "WHATS", "GO", "ARGENTINA");

INSERT INTO temas (nome, descricao) VALUES ("Astronomia", "Ciência que estuda a constituição e o movimento dos astros, suas posições relativas e as leis dos seus movimentos.");
INSERT INTO temas (nome, descricao) VALUES ("Biodiversidade", "Conjunto de todas as espécies de plantas e animais existentes na biosfera.");
INSERT INTO temas (nome, descricao) VALUES ("Origem do Homem", "Conheça de onde viemos e como evoluímos com as teorias das mais diversas disciplinas.");

INSERT INTO exposicoes (nome, descricao) VALUES ("Stonehenge", " Um monumento grego ou um templo de ruínas celtas?");
INSERT INTO exposicoes (nome, descricao) VALUES ("As primeiras civilizações humanas", "A representação da Necrópole de Gizé");
INSERT INTO exposicoes (nome, descricao) VALUES ("A Grécia dos Gregos", "Os gregos e as contribuições para a ciência");
INSERT INTO exposicoes (nome, descricao) VALUES ("Pinturas Rupestres", "Reprodução de pinturas rupestres que lembram as descobertas feitas em pedras na Serra do Antônio José, no município baiano de Utinga (Chapada Diamantina), de origem indígena e secular.");
INSERT INTO exposicoes (nome, descricao) VALUES ("Planetário", "Ciência que estuda a constituição e o movimento dos astros, suas posições relativas e as leis dos seus movimentos.");
INSERT INTO exposicoes (nome, descricao) VALUES ("Telescópio", "Observação dos Astros pelo Telescópio na cúpula superiror. Melhor horário é a noite.");
INSERT INTO exposicoes (nome, descricao) VALUES ("Parque dos Dinossauros", "Conjunto de todas as espécies de plantas e animais existentes na biosfera.");
INSERT INTO exposicoes (nome, descricao) VALUES ("Museu Antares", "Ciência que estuda a constituição e o movimento dos astros, suas posições relativas e as leis dos seus movimentos.");
INSERT INTO exposicoes (nome, descricao) VALUES ("Como ir ao Espaço", "Exposição em céu aberto com réplicas de Foguetes, Módulos Lunares e Trages Espaciais. Local: área externa");
INSERT INTO exposicoes (nome, descricao) VALUES ("Giroscópio Humano", "Exposição em céu aberto com réplicas de Foguetes, Módulos Lunares e Trages Espaciais. Local: área externa");
INSERT INTO exposicoes (nome, descricao) VALUES ("Amplificador de Voz", "Exposição em céu aberto com réplicas de Foguetes, Módulos Lunares e Trages Espaciais. Local: área externa");
INSERT INTO exposicoes (nome, descricao) VALUES ("Férias Divertidas", "Para  crianças de 5 a 12 anos acompanhadas por um responsável durante toda a visitação. Com o objetivo de dar oportunidade para um número maior de crianças visitarem o nosso espaço durante esse evento, cada criança só poderá agendar um único dia de visitação. A entrada é gratuita, porém, na edição de 2020, iremos realizar uma ação social e gostaríamos de contar com a ajuda de todos vocês! No dia da sua visita, faça não apenas o seu filho feliz como também uma criança carente, com a doação de 1 Kg de alimento não perecível que será doado  para uma instituição de caridade. A felicidade do seu filho será multiplicada para quem mais precisa!!! Esperamos vocês para essa viagem educativa!!!!");

INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (1, 5);
INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (1, 6);
INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (1, 8);
INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (1, 9);

INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (2, 7);
INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (2, 10);
INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (2, 11);
INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (2, 12);

INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (3, 1);
INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (3, 2);
INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (3, 3);
INSERT INTO exposicoes_do_tema (tema, exposicao) VALUES (3, 4);

INSERT INTO turmas (escola, nivel, serie, nome_turma, data_criacao) VALUES (3, 1, 11, "A", "2020-02-01");
INSERT INTO turmas (escola, nivel, serie, nome_turma, data_criacao) VALUES (3, 2, 29, "H", "2020-02-01");

INSERT INTO turmas (escola, nivel, serie, nome_turma, data_criacao) VALUES (10, 3, 13, "C", "2020-02-01");
INSERT INTO turmas (escola, nivel, serie, nome_turma, data_criacao) VALUES (10, 2, 25, "E", "2020-02-01");

INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Django Livre", "2000-02-01", 3, 1);
INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Quentin Tarantino", "1999-02-01", 3, 1);
INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Raul Seixas", "1990-02-01", 3, 1);
INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Kill Bill", "2000-02-01", 3, 2);
INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Batman", "1800-02-01", 3, 2);
INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Bruce Wayne", "1880-02-01", 3, 2);

INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Superman", "2000-02-01", 10, 3);
INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Clark Kent", "1999-02-01", 10, 3);
INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Spiderman", "1990-02-01", 10, 3);
INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Peter Parker", "2000-02-01", 10, 4);
INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Coringa", "1800-02-01", 10, 4);
INSERT INTO alunos (nome, data_nascimento, escola, turma) VALUES ("Rei do Crime", "1880-02-01", 10, 4);

INSERT INTO prof_resp (nome, cargo_funcao, escola, turma) VALUES ("ROSE", 1, 3, 1);
INSERT INTO prof_resp (nome, cargo_funcao, escola, turma) VALUES ("DOIS ROSE", 2, 3, 1);
INSERT INTO prof_resp (nome, cargo_funcao, escola, turma) VALUES ("TRES ROSE", 2, 3, 2);
INSERT INTO prof_resp (nome, cargo_funcao, escola, turma) VALUES ("ROSE QUATRO", 1, 3, 2);

INSERT INTO prof_resp (nome, cargo_funcao, escola, turma) VALUES ("CINCO ROSE", 1, 10, 1);
INSERT INTO prof_resp (nome, cargo_funcao, escola, turma) VALUES ("SEIS ROSE", 2, 10, 1);
INSERT INTO prof_resp (nome, cargo_funcao, escola, turma) VALUES ("ROSE SETE", 2, 10, 2);
INSERT INTO prof_resp (nome, cargo_funcao, escola, turma) VALUES ("ROSE OITO", 1, 10, 2);

-- INSERT INTO usuarios (nome, email, senha, permissao) VALUES ("Eu1", "eu1@eu.eu", "123", 1);
-- ALTER TABLE agendamentos ADD COLUMN confirmado INT NOT NULL;
-- ALTER TABLE pedidos ADD COLUMN data_hora DATETIME NOT NULL;
-- INSERT INTO agendamentos (evento, escola, turma, confirmado, excluido) VALUES (2, 3, 1, 0, 0);

-- SELECT id FROM lista_espera WHERE (evento=2 AND confirmado = 0 AND excluido = 0) ORDER BY (id) ASC;
-- SELECT * FROM agendamentos WHERE (confirmado = 0 AND excluido <> 1);
-- SELECT id FROM usuarios WHERE (senha=123 ) ORDER BY (id) ASC;
-- SELECT id FROM pedidos WHERE (evento=2 AND qtd_vagas=0) ORDER BY (id) ASC;
-- DELETE FROM agendamentos WHERE id=2;
-- SELECT MIN(start) FROM eventos WHERE id<>0;
-- SELECT MIN(id) AS primeiro FROM pedidos WHERE (evento=1 AND qtd_vagas=0);
-- SELECT start FROM eventos WHERE (estagiario = 1 AND title = 'Fim do Semestre');
-- SELECT COUNT(id) AS ja_fez FROM agendamentos WHERE (evento=13 AND escola=3 AND turma=4);
-- SELECT COUNT(id) AS ja_fez FROM eventos WHERE (estagiario=1 AND start="2020-02-01 00:00:00" AND end="2020-02-02 00:00:00");
-- SELECT COUNT(id) AS ja_fez FROM eventos WHERE (estagiario=1 AND start="2020-01-19 00:00:00" AND end="2020-01-20 00:00:00");
-- SELECT YEAR(NOW());
-- SELECT YEAR(curdate());
-- SELECT curdate();