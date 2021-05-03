<?php
    require_once("../classes/Tarefa.php");

    $tarefa = new Tarefa();
    
    // Validação de dados
    $id = $_GET['id'];
    $date = date('Y-m-d');

    $string_retorno = $tarefa->cadastraIntervalo($id, $date);

    echo $string_retorno;
?>
