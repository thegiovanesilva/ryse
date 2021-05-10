<?php
class BD {
    private $host = "localhost";
    private $user = "admryse";
    private $password = "12345";
    private $database = "ryse";
    private $conexao;

    function __construct() {
        $this->conexao = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        mysqli_query($this->conexao, "set names 'utf8'");
    }

    function query($sql) {
        return mysqli_query($this->conexao, $sql);
    }

    function select($sql) {
        $retorno = mysqli_query($this->conexao, $sql);
        if ($retorno==false) return [];
        $arrayResultados = array();   
        if (mysqli_num_rows($retorno) > 0) {
            while($linha = mysqli_fetch_assoc($retorno)) {
                $arrayResultados[] = $linha;
            }
        }
        return $arrayResultados;
    }

    function execute($stmt, $get_id=0) {
        $stmt->execute();
        $result = $stmt->get_result();
        $id = $this->conexao->insert_id;
        $ar = $stmt->affected_rows;

        /*if ($ar==-1) {
            print_r($stmt->error);
        }*/

        $stmt->close();

        if (is_bool($result)) {
            if (!$get_id || $ar==-1) return $ar;
            return $id;
        }

        $arrayResultados = array();
        while ($row = $result->fetch_assoc()) {
            $arrayResultados[] = $row;
        }

        return $arrayResultados;
    }

    function prepare($sql) {
        return $this->conexao->prepare($sql);
    }

    function erro() {
        return mysqli_error($this->conexao);
    }

    function info() {
        return var_dump($this->conexao->info);
    }
}
?>
