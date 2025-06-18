
CREATE TABLE especialidades (
                especialidade_id INT AUTO_INCREMENT NOT NULL,
                descricao VARCHAR(255) NOT NULL,
                data_criacao DATETIME NOT NULL,
                data_atualizacao DATETIME,
                PRIMARY KEY (especialidade_id)
);


CREATE TABLE barbeiros (
                barbeiro_id INT AUTO_INCREMENT NOT NULL,
                nome VARCHAR(255) NOT NULL,
                data_nascimento DATE NOT NULL,
                data_contratacao DATE NOT NULL,
                data_criacao DATETIME NOT NULL,
                data_atualizacao DATETIME,
                PRIMARY KEY (barbeiro_id)
);


CREATE TABLE barbeiros_especialidades (
                barbeiro_id INT NOT NULL,
                especialidade_id INT NOT NULL,
                data_criacao DATETIME NOT NULL,
                PRIMARY KEY (barbeiro_id, especialidade_id)
);


CREATE TABLE usuarios (
                usuario_id INT AUTO_INCREMENT NOT NULL,
                nome VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                senha VARCHAR(255) NOT NULL,
                admin BOOLEAN DEFAULT 0 NOT NULL,
                data_criacao DATETIME NOT NULL,
                data_atualizacao DATETIME,
                PRIMARY KEY (usuario_id)
);


CREATE TABLE agendamentos (
                agendamento_id INT AUTO_INCREMENT NOT NULL,
                usuario_id INT NOT NULL,
                especialidade_id INT NOT NULL,
                barbeiro_id INT NOT NULL,
                data_agendamento DATE NOT NULL,
                hora_inicio TIME NOT NULL,
                hora_fim TIME NOT NULL,
                status_agendamento ENUM('AGENDADO', 'CANCELADO', 'CONCLUIDO') DEFAULT 'AGENDADO' NOT NULL,
                data_criacao DATETIME NOT NULL,
                data_atualizacao DATETIME,
                PRIMARY KEY (agendamento_id)
);


ALTER TABLE barbeiros_especialidades ADD CONSTRAINT especialidades_barbeiros_especialidades_fk
FOREIGN KEY (especialidade_id)
REFERENCES especialidades (especialidade_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE agendamentos ADD CONSTRAINT especialidades_agendamentos_fk
FOREIGN KEY (especialidade_id)
REFERENCES especialidades (especialidade_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE barbeiros_especialidades ADD CONSTRAINT barbeiros_barbeiros_especialidades_fk
FOREIGN KEY (barbeiro_id)
REFERENCES barbeiros (barbeiro_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE agendamentos ADD CONSTRAINT barbeiros_agendamentos_fk
FOREIGN KEY (barbeiro_id)
REFERENCES barbeiros (barbeiro_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE agendamentos ADD CONSTRAINT usuarios_agendamentos_fk
FOREIGN KEY (usuario_id)
REFERENCES usuarios (usuario_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;