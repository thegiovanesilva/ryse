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
                $result1 = $this->conexao->execute($stmt);
                if ($result1==-1) {
                    $this->conexao->query("rollback");
                    return "Falha no cadastro";
                }
            }
            $this->conexao->query("commit");
            return "Tarefa criada com sucesso!";
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
        $stmt->bind_param("ssssi", $nome, $descricao, $data_limite, $data_fim, $id);
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

    function buscarTarefas($id=NULL) {
        if ($id==NULL) {
            $ret = $this->conexao->select("SELECT * FROM tarefas t LEFT JOIN tarefa_reps tr ON tr.tarefa_id=t.id;");
        }
        else {
            $stmt = $this->conexao->prepare("SELECT * FROM tarefas t LEFT JOIN tarefa_reps tr ON tr.tarefa_id=t.id WHERE t.id=?;");
            $stmt->bind_param("i",$id);
            $ret = $this->conexao->execute($stmt);
            if ($ret==-1) {
                return "Falha na consulta";
            }
        }
        $result = array();
        foreach ($ret as $r) {
            if (!array_key_exists($r["id"], $result)) {
                $result[$r["id"]]=array();
                $result[$r["id"]]["nome"]=$r["nome"];
                $result[$r["id"]]["descricao"]=$r["descricao"];
                $result[$r["id"]]["data_limite"]=$r["data_limite"];
                $result[$r["id"]]["data_fim"]=$r["data_fim"];
                if (!empty($r["dia"])) {
                    $result[$r["id"]]["repete"]=array();
                    $result[$r["id"]]["repete"][]=$r["dia"];
                }
            }
            else {
                $result[$r["id"]]["repete"][]=$r["dia"];
            }
        }
        return $result;
    }
}

//$tar = new Tarefa();
//print($tar->novaTarefa("Tarefa teste", "Teste teste teste", date("2021-03-29"), ['seg']));
//print($tar->apagarTarefa(7));
//print($tar->atualizarTarefa(7, "Tarefa teste 2", "Teste teste teste", NULL, date("2021-03-29"), ['ter','qua']));
//print_r($tar->buscarTarefas());
//print_r($tar->buscarTarefas(7));
