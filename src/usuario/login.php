<?php
session_start();

if(!isset($_SESSION['cont'])) $_SESSION['cont'] = 0;

$message = "Error";
$img = "../imgs/error.png";
if ($_SESSION['cont']==3) {
    if ($_SESSION['exp']<time()) $_SESSION['cont']=0;
    else {
        $x = $_SESSION['exp']-time();
        $message = "Muitas tentativas incorretas, tente novamente em $x segundos...";
    }
}

if (isset($_SESSION['id'])) {
    header("Location: /");
}

if (isset($_POST['email']) && isset($_POST['senha'])) {
    require_once ("../classes/Usuario.php");
    
    if ($_SESSION['cont']!=3) {
        $usuario = new Usuario();
        $usu = $usuario->autenticar($_POST['email'],$_POST['senha']);
        if (isset($usu) && $usu!=false) {
            $_SESSION['id'] = $usu['id'];
            $_SESSION['nome'] = $usu['nome'];
            $_SESSION['email'] = $usu['email'];
            $_SESSION['cont'] = 0;
            $message = "Login efetuado com sucesso";
            $img = "../imgs/noterror.png";
        }
        else {
            $_SESSION['cont']++;
            $_SESSION['exp'] = time()+150;
            $message = "CPF ou senha não cadastrados.";
        }
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
