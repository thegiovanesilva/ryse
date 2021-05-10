<link href="criar.css" rel="stylesheet"/>

<?php
    @session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: /");
    }
    
    require_once("../classes/Tarefa.php");

    $tarefa = new Tarefa();
    $valida = true;

    // Validação de dados
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $metodo = $_POST['prazo'];
    $intervalos = $_POST['intervalos_estimados'];
    if ($metodo == 'prazo-recorrente'){
       if ( !isset($_POST['recorrente']) ){ $valida = false; }
       else{ $prazo = $_POST['recorrente']; }
    }else{
        $prazo = $_POST['date'];
        $dia = substr($prazo,0,2);
        $mes = substr($prazo,3,2);
        $ano = substr($prazo,6);
        $prazo = date($ano."/".$mes."/".$dia);
        
        $today = new DateTime(date('Y/m/d'));
        $VarPrazo = new DateTime(date($prazo));
        if ($today > $VarPrazo ){
            $valida = false;
        }
    }
    
    $string_retorno = "Falha no cadastro";

    // Se o que vier do html for uma data-recorrente, então envia null como prazo limite
    // Se o que vier do html for uma data-limite, então envia null como prazo recorrente
    if ($valida) { $string_retorno = (is_array($prazo)) ? $tarefa->novaTarefa($_SESSION['id'], $nome, $descricao, NULL, $prazo, $intervalos) : $tarefa->novaTarefa($_SESSION['id'], $nome, $descricao, $prazo, [], $intervalos); }

    if ($string_retorno == "Tarefa criada com sucesso"){
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
