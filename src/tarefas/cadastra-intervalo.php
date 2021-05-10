<?php
    @session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: /");
    }

    require_once("../classes/Tarefa.php");

    $tarefa = new Tarefa();
    
    // Validação de dados
    $id = $_GET['id'];
    $date = date('Y-m-d');

    $string_retorno = $tarefa->cadastraIntervalo($_SESSION['id'], $id, $date);

    echo $string_retorno;
?>
