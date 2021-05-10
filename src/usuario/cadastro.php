<?php 
    $msg = "";

    $nome = isset($_POST['nome'])? $_POST['nome'] : "";
    $email = isset($_POST['email'])? $_POST['email'] : "";

    if (isset($_POST['email']) && isset($_POST['nome']) && isset($_POST['senha'])){
        if (isset($_POST['senhaR'])){
            if ($_POST['senha'] == $_POST['senhaR']){
                require_once ("../classes/Usuario.php");
                $usu = new Usuario();
                $ret = $usu->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha']);
                if ($ret) header("Location: login.php");
                else $msg = "Ocorreu um erro no cadastro. Tente novamente"; 
            }else{
                $msg = "As senhas não coincidem";
            }
        }else{
            $msg = "É necessario confirmar a sua senha";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">

    <title>Ryze - Cadastro</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
</head>
<body>
    <div class="row login">
        <div class="col s12 l4 offset-l4">
            <div class="card">
                <div class="card-action red white-text">
                    <h3>Cadastro</h3>
                </div>
                <div class="card-content">
                    <form action="" method="POST">
                        <div class="form-field">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" value="<?=$email?>" required>
                        </div><br>

                        <div class="form-field">
                            <label for="senha">Nome</label>
                            <input type="text" name="nome" value="<?=$nome?>" required>
                        </div><br>

                        <div class="form-field">
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" required>
                        </div><br>

                        <div class="form-field">
                            <label for="senha">Repita sua senha</label>
                            <input type="password" name="senhaR" required>
                        </div><br>

                        <div class=form-field>
                            <span id="erroLogin"><?=$msg?></span>
                        </div></br>

                        <div class="form-field center-align">
                            <input class="btn-large red" type="reset" name="cancelar" value="Cancelar" onClick="JavaScript: window.history.back();">
                            <input class="btn-large red" type="submit" name="login" value="Confirmar">
                        </div><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>