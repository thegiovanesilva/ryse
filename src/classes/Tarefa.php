<?php
require_once ("BD.php");
class Tarefa {
    private $conexao;

    function __construct() {
        $this->conexao = new BD();
    }

    function novaTarefa($nome, $descricao, $data_limite, $repeticao) {
        //Tarefa com prazo recorente
        if (count($repeticao)) {
            $this->conexao->query("begin");
            $stmt = $this->conexao->prepare("INSERT INTO tarefas (nome, descricao) VALUES (?, ?)");
            $stmt->bind_param("ss",$nome,$descricao);
            $result = $this->conexao->execute($stmt, 1);
            if ($result==-1) {
                $this->conexao->query("rollback");
                return "Falha no cadastro";
            }
            foreach ($repeticao as $rep) {
                $stmt = $this->conexao->prepare("INSERT INTO tarefa_reps (tarefa_id,dia) VALUES (?,?)");
                $stmt->bind_param("is",$result,$rep);
                $result1 = $this->conexao->execute($tstm);
                if ($result1==-1) {
                    $this->conexao->query("rollback");
                    return "Falha no cadastro";
                }
            }
            $this->conexao->query("commit");
            return "Tarefa criada com sucesso";
        }

        //Tarefa com prazo único
        else {
            $stmt = $this->conexao->prepare("INSERT INTO tarefas (nome, descricao, data_limite) VALUES (?, ?, ?)");
            $stmt->bind_param("sss",$nome,$descricao,$data_limite);
            $result = $this->conexao->execute($stmt);
            return $result!=-1 ? "Tarefa criada com sucesso" : "Falha no cadastro";
        }
    }

    function apagarTarefa($id) {
        $stmt = $this->conexao->prepare("DELETE FROM tarefa_reps WHERE tarefa_id=?");
        $stmt->bind_param("i",$id);
        $result = $this->conexao->execute($stmt);
        if ($result==-1) return "Falha ao apagar";
        $stmt = $this->conexao->prepare("DELETE FROM tarefas WHERE id=?;");
        $stmt->bind_param("i",$id);
        $result = $this->conexao->execute($stmt);
        if ($result==-1) return "Falha ao apagar";
        return "Tarefa apagada com sucesso!";
    }

    function atualizarTarefa($id, $nome, $descricao, $data_limite, $data_fim, $repeticao) {
        $this->conexao->query("begin");
        //atualiza tarefa simples
        $stmt = $this->conexao->prepare("UPDATE tarefas SET nome=?,descricao=?,data_limite=?,data_fim=? WHERE id=?");
        $stmt->bind_param(" ", $nome, $descricao, $data_limite, $data_fim, $id);
        $result = $this->conexao->execute($stmt);
        if ($result==-1) {
            return "Falha ao atualizar";
            $this->conexao->query("rollback");
        }
        //remove antigas repetições
        $stmt = $this->conexao->prepare("DELETE FROM tarefa_reps WHERE tarefa_id=?");
        $stmt->bind_param("i", $id);
        $result = $this->conexao->execute($stmt);
        if ($result==-1) {
            return "Falha ao atualizar";
            $this->conexao->query("rollback");
        }
        //cadastra novas repetições
        foreach ($repeticao as $rep) {
            $stmt = $this->conexao->prepare("INSERT INTO tarefa_reps (tarefa_id,dia) VALUES (?,?)");
            $stmt->bind_param("is",$id,$rep);
            $result = $this->conexao->execute($stmt);
            if ($result==-1) {
                $this->conexao->query("rollback");
                return "Falha na atualização";
            }
        }
        $this->conexao->query("commit");
        return "Tarefa atualizada com sucesso!";
    }
}

//$tar = new Tarefa();
//print($tar->novaTarefa("Tarefa teste", "Teste teste teste", date("2021-03-29"), ['seg']));
//print($tar->apagarTarefa(7));
//print($tar->atualizarTarefa(7, "Tarefa teste 2", "Teste teste teste", NULL, date("2021-03-29"), ['ter']));
