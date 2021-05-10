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
            return false;
        }
        $this->conexao->query("commit");
        return true;
    }

    function autenticar($email, $senha) {
        $stmt = $this->conexao->prepare("SELECT * FROM usuarios WHERE email=?");
        $stmt->bind_param("s",$email);
        $result = $this->conexao->execute($stmt);

        if (!isset($result) || count($result)==0 || count($result)>1) {
            return False;
        }
        if (password_verify($senha, $result[0]['senha'])) {
            return $result[0];
        }
        return False;
    }
}

//$usu = new Usuario();
//echo $usu->cadastrar("José", "jose@jose.com", "jose123");
//var_dump($usu->autenticar("jose@jose.com", "jose123"));
