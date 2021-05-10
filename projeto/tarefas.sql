--Inserir tarefa com prazo único
INSERT INTO tarefas (idusu, nome, descricao, data_limite, intervalos_estimados) VALUES (1, 'Tarefa x', 'Fazer x e y', '2021-3-29', 2);

--Inserir tarefa com prazo recorrente
INSERT INTO tarefas (idusu, nome, descricao, intervalos_estimados) VALUES (1, 'Tarefa y', 'Fazer z', 2);
INSERT INTO tarefa_reps (idusu, tarefa_id, dia) VALUES (1,0,'seg');

--Atualizar tarefa
UPDATE tarefas SET nome='Tarefa não x',descricao='Fazer x e y',data_limite='2021-3-29',data_fim=NULL,intervalos_estimados=3 WHERE idusu=1 AND id=0;

--Atualizar prazo recorrente
DELETE FROM tarefa_reps WHERE idusu=1 AND tarefa_id=0;
INSERT INTO tarefa_reps (idusu, tarefa_id, dia) VALUES (1,0,'ter');

--Remover tarefa
DELETE FROM tarefa_reps WHERE idusu=1 AND tarefa_id=0;
DELETE FROM intervalos WHERE idusu=1 AND tarefa_id=0;
DELETE FROM tarefas WHERE idusu=1 AND id=0;

--Listar tarefas
SELECT t.*, tr.*, i.dia AS intervalo_dia, i.quantidade AS intervalo_quantidade FROM tarefas t LEFT JOIN tarefa_reps tr ON tr.tarefa_id=t.id LEFT JOIN intervalos i ON i.tarefa_id=t.id WHERE t.idusu=1;

--Listar uma tarefa
SELECT t.*, tr.*, i.dia AS intervalo_dia, i.quantidade AS intervalo_quantidade FROM tarefas t LEFT JOIN tarefa_reps tr ON tr.tarefa_id=t.id LEFT JOIN intervalos i ON i.tarefa_id=t.id WHERE t.idusu=1 AND t.id=0;

--Inserir/atualizar intervalo
SELECT * FROM intervalos WHERE idusu=1 AND tarefa_id=0 AND dia='2021-4-26';
INSERT INTO intervalos (idusu,tarefa_id,dia,quantidade) VALUES (1, 0, '2021-4-26', 1);
UPDATE intervalos SET quantidade=0 WHERE idusu=1 AND tarefa_id=0 AND dia='2021-4-26';
