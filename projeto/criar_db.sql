DROP TABLE IF EXISTS tarefa_reps;
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
    dia CHAR(3) NOT NULL UNIQUE,
    CONSTRAINT pk_tarefas_reps PRIMARY KEY (tarefa_id,dia),
    CONSTRAINT fk_tarefas_reps_tarefas FOREIGN KEY (tarefa_id) REFERENCES tarefas (id)
);
