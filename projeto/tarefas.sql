--Inserir tarefa com prazo único
INSERT INTO tarefas (nome, descricao, data_limite, intervalos_estimados) VALUES ('Tarefa x', 'Fazer x e y', '2021-3-29', 2);

--Inserir tarefa com prazo recorrente
INSERT INTO tarefas (nome, descricao, intervalos_estimados) VALUES ('Tarefa y', 'Fazer z', 2);
INSERT INTO tarefa_reps (tarefa_id, dia) VALUES (0,'seg');

--Atualizar tarefa
UPDATE tarefas SET nome='Tarefa não x',descricao='Fazer x e y',data_limite='2021-3-29',data_fim=NULL,intervalos_estimados=3 WHERE id=0;

--Atualizar prazo recorrente
DELETE FROM tarefa_reps WHERE tarefa_id=0;
INSERT INTO tarefa_reps (tarefa_id, dia) VALUES (0,'ter');

--Remover tarefa
DELETE FROM tarefa_reps WHERE tarefa_id=0;
DELETE FROM intervalos WHERE tarefa_id=0;
DELETE FROM tarefas WHERE id=0;

--Listar tarefas
SELECT t.*, tr.*, i.dia AS intervalo_dia, i.quantidade AS intervalo_quantidade FROM tarefas t LEFT JOIN tarefa_reps tr ON tr.tarefa_id=t.id LEFT JOIN intervalos i ON i.tarefa_id=t.id;

--Listar uma tarefa
SELECT t.*, tr.*, i.dia AS intervalo_dia, i.quantidade AS intervalo_quantidade FROM tarefas t LEFT JOIN tarefa_reps tr ON tr.tarefa_id=t.id LEFT JOIN intervalos i ON i.tarefa_id=t.id WHERE t.id=0;

--Inserir/atualizar intervalo
SELECT * FROM intervalos WHERE tarefa_id=0 AND dia='2021-4-26';
INSERT INTO intervalos (tarefa_id,dia,quantidade) VALUES (0, '2021-4-26', 1);
UPDATE intervalos SET quantidade=0 WHERE tarefa_id=0 AND dia='2021-4-26';
