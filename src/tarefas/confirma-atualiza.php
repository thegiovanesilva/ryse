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
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $metodo = $_POST['prazo'];
    $intervalos = $_POST['intervalos_estimados'];
    $data_fim = ((!empty($_POST['data_fim']) && $_POST['data_fim']!='') ? $_POST['data_fim'] : NULL);
    if ($metodo == 'prazo-recorrente'){
       $prazo = $_POST['recorrente'];
    }else{
        $prazo = $_POST['date'];
        $dia = substr($prazo,0,2);
        $mes = substr($prazo,3,2);
        $ano = substr($prazo,6);
        $prazo = date($ano."/".$mes."/".$dia);
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
