<?php
session_start();

function valid_email($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

$message = "Error";
$img = "../imgs/error.png";

if (isset($_SESSION['id'])) {
    header("Location: /");
}

if (!isset($_POST['email']) || !valid_email($_POST['email'])) {
    $message = "Endereço de email inválido";
}
else if (isset($_POST['senha']) && isset($_POST['nome'])) {
    require_once ("../classes/Usuario.php");

    $usuario = new Usuario();

    $ret = $usuario->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha']);
    if ($ret == "Ok") {
        $message = "Cadastro efetuado com sucesso";
        $img = "../imgs/noterror.png";
    }
    else {
        $message = "Erro no cadastro";
    }
}

header("refresh:3; url=/");
?>

<?php include("../includes/header.php") ?>

<link href="../tarefas/criar.css" rel="stylesheet"/>

<link rel="stylesheet" href="criar.css"/>

<main class="confirma">
    <img src=<?=$img?> id="img">
    <p id="texto"><?=$message?></p>        
</main>
   
<?php include("../includes/footer.php") ?>
