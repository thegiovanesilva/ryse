<link href="criar.css" rel="stylesheet"/>

<?php
    require_once("../classes/Tarefa.php");

    $tarefa = new Tarefa();
    
    // Validação de dados
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $metodo = $_POST['prazo'];

    if (isset($_POST['recorrente'])){
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
    $string_retorno = (is_array($prazo)) ? $tarefa->novaTarefa($nome, $descricao, NULL, $prazo) : $tarefa->novaTarefa($nome, $descricao, $prazo, []);

    if ($string_retorno == "Tarefa criada com sucesso"){
        $img = "../imgs/noterror.png";
    }else{
        $img = "../imgs/error.png";
    }

?>
<?php include("../includes/header.php") ?>

<link rel="stylesheet" href="criar.css"/>

    <main class="confirma">
        <img src=<?=$img?> id="img">
        <p id="texto"><?=$string_retorno?></p>        
    </main>
   
<?php include("../includes/footer.php") ?>



