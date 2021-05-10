DROP DATABASE IF EXISTS ryse;

CREATE DATABASE ryse DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE ryse;

DROP USER IF EXISTS 'admryse'@'localhost';
CREATE USER 'admryse'@'localhost' IDENTIFIED BY '12345';
GRANT SELECT, INSERT, UPDATE, DELETE ON ryse.* TO 'admryse'@'localhost';

DROP TABLE IF EXISTS tarefa_reps;
DROP TABLE IF EXISTS intervalos;
DROP TABLE IF EXISTS tarefas;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id SERIAL,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha TEXT NOT NULL,
    CONSTRAINT pk_usuarios PRIMARY KEY (id)
);

CREATE TABLE tarefas (
    idusu BIGINT UNSIGNED NOT NULL,
	id SERIAL,
	nome VARCHAR(50) NOT NULL,
    descricao TEXT NOT NULL,
	data_limite DATE,
	data_fim DATE,
    intervalos_estimados INTEGER NOT NULL,
    CONSTRAINT pk_tarefas PRIMARY KEY (idusu, id),
    CONSTRAINT fk_tarefas_usuarios FOREIGN KEY (idusu) REFERENCES usuarios (id)
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
