<?php
require_once ("BD.php");
class Tarefa {
    private $conexao;

    function __construct() {
        $this->conexao = new BD();
    }

    function novaTarefa($idusu, $nome, $descricao, $data_limite, $repeticao, $intervalos_estimados) {
        //Tarefa com prazo recorente
        if (count($repeticao)) {
            $this->conexao->query("begin");
            $stmt = $this->conexao->prepare("INSERT INTO tarefas (idusu, nome, descricao, intervalos_estimados) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("issi",$idusu,$nome,$descricao,$intervalos_estimados);
            $result = $this->conexao->execute($stmt, 1);
            if ($result==-1) {
                $this->conexao->query("rollback");
                return "Falha no cadastro";
            }
            foreach ($repeticao as $rep) {
                $stmt = $this->conexao->prepare("INSERT INTO tarefa_reps (idusu,tarefa_id,dia) VALUES (?,?,?)");
                $stmt->bind_param("iis",$idusu,$result,$rep);
                $result1 = $this->conexao->execute($stmt);
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
            $stmt = $this->conexao->prepare("INSERT INTO tarefas (idusu, nome, descricao, data_limite, intervalos_estimados) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isssi",$idusu,$nome,$descricao,$data_limite,$intervalos_estimados);
            $result = $this->conexao->execute($stmt);
            return $result!=-1 ? "Tarefa criada com sucesso" : "Falha no cadastro";
        }
    }

    function apagarTarefa($idusu,$id) {
        $stmt = $this->conexao->prepare("DELETE FROM tarefa_reps WHERE idusu=? AND tarefa_id=?");
        $stmt->bind_param("ii",$idusu,$id);
        $result = $this->conexao->execute($stmt);
        if ($result==-1) return "Falha ao apagar";
        $stmt = $this->conexao->prepare("DELETE FROM intervalos WHERE idusu=? AND tarefa_id=?");
        $stmt->bind_param("ii",$idusu,$id);
        $result = $this->conexao->execute($stmt);
        if ($result==-1) return "Falha ao apagar";
        $stmt = $this->conexao->prepare("DELETE FROM tarefas WHERE idusu=? AND id=?;");
        $stmt->bind_param("ii",$idusu,$id);
        $result = $this->conexao->execute($stmt);
        if ($result==-1) return "Falha ao apagar";
        return "Tarefa apagada com sucesso!";
    }

    function atualizarTarefa($idusu, $id, $nome, $descricao, $data_limite, $data_fim, $repeticao, $intervalos_estimados) {
        $this->conexao->query("begin");
        //atualiza tarefa simples
        $stmt = $this->conexao->prepare("UPDATE tarefas SET nome=?,descricao=?,data_limite=?,data_fim=?,intervalos_estimados=? WHERE idusu=? AND id=?");
        $stmt->bind_param("ssssiii", $nome, $descricao, $data_limite, $data_fim, $intervalos_estimados, $idusu, $id);
        $result = $this->conexao->execute($stmt);
        if ($result==-1) {
            return "Falha ao atualizar";
            $this->conexao->query("rollback");
        }
        //remove antigas repetições
        $stmt = $this->conexao->prepare("DELETE FROM tarefa_reps WHERE idusu=? AND tarefa_id=?");
        $stmt->bind_param("ii", $idusu,$id);
        $result = $this->conexao->execute($stmt);
        if ($result==-1) {
            return "Falha ao atualizar";
            $this->conexao->query("rollback");
        }
        //cadastra novas repetições
        foreach ($repeticao as $rep) {
            $stmt = $this->conexao->prepare("INSERT INTO tarefa_reps (idusu,tarefa_id,dia) VALUES (?,?,?)");
            $stmt->bind_param("iis",$idusu,$id,$rep);
            $result = $this->conexao->execute($stmt);
            if ($result==-1) {
                $this->conexao->query("rollback");
                return "Falha na atualização";
            }
        }
        $this->conexao->query("commit");
        return "Tarefa atualizada com sucesso!";
    }

    function buscarTarefas($idusu,$id=NULL) {
        if ($id==NULL) {
            $ret = $this->conexao->select("SELECT t.*, tr.*, i.dia AS intervalo_dia, i.quantidade AS intervalo_quantidade FROM tarefas t LEFT JOIN tarefa_reps tr ON tr.tarefa_id=t.id LEFT JOIN intervalos i ON i.tarefa_id=t.id WHERE t.idusu=".$idusu.";");
        }
        else {
            $stmt = $this->conexao->prepare("SELECT t.*, tr.*, i.dia AS intervalo_dia, i.quantidade AS intervalo_quantidade FROM tarefas t LEFT JOIN tarefa_reps tr ON tr.tarefa_id=t.id LEFT JOIN intervalos i ON i.tarefa_id=t.id WHERE t.idusu=? AND t.id=?;");
            $stmt->bind_param("ii",$idusu,$id);
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
                $result[$r["id"]]["intervalos"] = $r["intervalo_quantidade"];
                $result[$r["id"]]["intervalos_estimados"]=$r["intervalos_estimados"];
                if (!empty($r["dia"])) {
                    $result[$r["id"]]["repete"]=array();
                    $result[$r["id"]]["repete"][]=$r["dia"];
                }

                $ret2 = $this->conexao->select("SELECT * FROM intervalos WHERE idusu=".$idusu."tarefa_id=".$r["id"]." AND dia='".date("Y-m-d")."';");
                if (!empty($ret2)) {
                    $result[$r["id"]]["intervalos"] = $ret2[0]["quantidade"];
                }
            }
            else {
                $result[$r["id"]]["repete"][]=$r["dia"];
            }
        }
        return $result;
    }

    function cadastraIntervalo($idusu, $tarefa, $dia) {
        $stmt = $this->conexao->prepare("SELECT * FROM intervalos WHERE idusu=? AND tarefa_id=? AND dia=?;");
        $stmt->bind_param("iis", $idusu, $tarefa, $dia);
        $result = $this->conexao->execute($stmt);
        if (empty($result)) {
            $stmt = $this->conexao->prepare("INSERT INTO intervalos (idusu,tarefa_id,dia,quantidade) VALUES (?, ?, ?, ?);");
            $t = 1;
            $stmt->bind_param("iisi", $idusu, $tarefa, $dia, $t);
            $result = $this->conexao->execute($stmt);
            if ($result!=-1) {
                return "Ok";
            }
            return "Falha";
        }
        $stmt = $this->conexao->prepare("UPDATE intervalos SET quantidade=? WHERE idusu=? AND tarefa_id=? AND dia=?;");
        $t = $result[0]["quantidade"]+1;
        $stmt->bind_param("iiis", $t, $idusu, $tarefa, $dia);
        $result = $this->conexao->execute($stmt);
        if ($result>0) {
            return "Ok";
        }
        return "Falha";
    }
}

$tar = new Tarefa();
//print($tar->novaTarefa(1, "Tarefa teste", "Teste teste teste", date("2021-03-29"), ['seg'], 1));
//print($tar->apagarTarefa(1,3));
//print($tar->atualizarTarefa(1, 3, "Tarefa teste 2", "Teste teste teste", NULL, date("2021-03-29"), ['ter','qua'], 3));
//print_r($tar->buscarTarefas(1));
//print_r($tar->buscarTarefas(1, 7));
//print_r($tar->cadastraIntervalo(1, 3, date('2021-04-26')));
