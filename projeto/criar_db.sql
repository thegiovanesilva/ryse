DROP DATABASE IF EXISTS ryse;

CREATE DATABASE ryse DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE ryse;

DROP USER IF EXISTS 'admryse'@'localhost';
CREATE USER 'admryse'@'localhost' IDENTIFIED BY '12345';
GRANT SELECT, INSERT, UPDATE, DELETE ON ryse.* TO 'admryse'@'localhost';

DROP TABLE IF EXISTS tarefa_reps;
DROP TABLE IF EXISTS intervalos;
DROP TABLE IF EXISTS tarefas;

CREATE TABLE tarefas (
	id SERIAL,
	nome VARCHAR(50) NOT NULL,
    descricao TEXT NOT NULL,
	data_limite DATE,
	data_fim DATE,
    CONSTRAINT pk_tarefas PRIMARY KEY (id)
);

CREATE TABLE tarefa_reps (
    tarefa_id BIGINT UNSIGNED NOT NULL,
    dia CHAR(3) NOT NULL,
    CONSTRAINT pk_tarefas_reps PRIMARY KEY (tarefa_id,dia),
    CONSTRAINT fk_tarefas_reps_tarefas FOREIGN KEY (tarefa_id) REFERENCES tarefas (id)
);

CREATE TABLE intervalos (
    tarefa_id BIGINT UNSIGNED NOT NULL,
    dia DATE NOT NULL,
    quantidade INTEGER NOT NULL,
    CONSTRAINT pk_intervalo PRIMARY KEY (tarefa_id,dia),
    CONSTRAINT fk_tarefas_intervalos FOREIGN KEY (tarefa_id) REFERENCES tarefas (id)
);
