<?php
    @session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: /");
    }
    
    require_once("../classes/Tarefa.php");

    if (!isset($_GET['id'])) {
        header("Location: /tarefas/visualizar.php");
    }

    $id = $_GET['id'];

    $tarefa = new Tarefa();
    $tarefas = $tarefa->buscarTarefas($_SESSION['id'], $id);
    
    if (!isset($tarefas[$id])){
        header("Location: /");
    }

    // Validação de dados
    $nome = $tarefas[$id]['nome'];
    $descricao = $tarefas[$id]['descricao'];
    $metodo = $tarefas[$id]['data_limite'];
    $intervalos = $tarefas[$id]['intervalos_estimados'];
    $data_fim = date('Y-m-d');
    if (isset($tarefas[$id]['repete'])){
       $prazo = $tarefas[$id]['repete'];
    }else{
        $prazo = $tarefas[$id]['data_limite'];
    }
    $string_retorno = "";

    // Se o que vier do html for uma data-recorrente, então envia null como prazo limite
    // Se o que vier do html for uma data-limite, então envia null como prazo recorrente
    $string_retorno = (is_array($prazo)) ? $tarefa->atualizarTarefa($_SESSION['id'], $id, $nome, $descricao, NULL, $data_fim, $prazo, $intervalos) : $tarefa->atualizarTarefa($_SESSION['id'], $id, $nome, $descricao, $prazo, $data_fim, [], $intervalos);

    if ($string_retorno == "Tarefa atualizada com sucesso!"){
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
