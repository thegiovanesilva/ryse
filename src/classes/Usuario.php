<?php
require_once ("BD.php");
class Usuario {
    private $conexao;

    function __construct() {
        $this->conexao = new BD();
    }

    function cadastrar($nome, $email, $senha) {
        $senha = password_hash($senha, PASSWORD_DEFAULT);

        $this->conexao->query("begin");
        $stmt = $this->conexao->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss",$nome,$email,$senha);
        $result = $this->conexao->execute($stmt);
        if ($result==-1) {
            $this->conexao->query("rollback");
            return "Erro";
        }
        $this->conexao->query("commit");
        return "Ok";
    }
}

//$usu = new Usuario();
//echo $usu->cadastrar("José", "jose@jose.com", "jose123");
