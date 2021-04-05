--Inserir tarefa com prazo único
INSERT INTO tarefas (nome, descricao, data_limite) VALUES ('Tarefa x', 'Fazer x e y', '2021-3-29');

--Inserir tarefa com prazo recorrente
INSERT INTO tarefas (nome, descricao) VALUES ('Tarefa y', 'Fazer z');
INSERT INTO tarefa_reps (tarefa_id, dia) VALUES (0,'seg');

--Atualizar tarefa
UPDATE tarefas SET nome='Tarefa não x',descricao='Fazer x e y',data_limite='2021-3-29',data_fim=NULL WHERE id=0;

--Atualizar prazo recorrente
DELETE FROM tarefa_reps WHERE tarefa_id=0;
INSERT INTO tarefa_reps (tarefa_id, dia) VALUES (0,'ter');

--Remover tarefa
DELETE FROM tarefa_reps WHERE tarefa_id=0;
DELETE FROM tarefas WHERE id=0;

--Listar tarefas
SELECT * FROM tarefas t LEFT JOIN tarefa_reps tr ON tr.tarefa_id=t.id;

--Listar uma tarefa
SELECT * FROM tarefas t LEFT JOIN tarefa_reps tr ON tr.tarefa_id=t.id WHERE t.id=0;
