<link href="criar.css" rel="stylesheet"/>

<?php
    @session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: /");
    }

    require_once("../classes/Tarefa.php");

    $tarefa = new Tarefa();
    
    // Validação de dados
    $id = $_GET['id'];

    $string_retorno = $tarefa->apagarTarefa($_SESSION['id'], $id);

    if ($string_retorno == "Tarefa apagada com sucesso!"){
        $img = "../imgs/noterror.png";
    }else{
        $img = "../imgs/error.png";
    }
    header('refresh:3; url=visualizar.php');

?>
<?php include("../includes/header.php") ?>

<link rel="stylesheet" href="criar.css"/>

    <main class="confirma">
        <img src=<?=$img?> id="img">
        <p id="texto"><?=$string_retorno?></p>        
    </main>
   
<?php include("../includes/footer.php") ?>
