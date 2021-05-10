<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">

    <title>Ryze - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
</head>
<body>
    <div class="row login">
        <div class="col s12 l4 offset-l4">
            <div class="card">
                <div class="card-action red white-text">
                    <h3>Login</h3>
                </div>
                <div class="card-content">
                    <form action="usuario/login.php" method="POST">
                        <div class="form-field">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" required>
                        </div><br>

                        <div class="form-field">
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" required>
                        </div><br>

                        <div class="form-field">
                            <label>
                                <input type="checkbox" name="lembrar">
                                <span>Lembrar de mim</span>
                            </label>
                        </div><br>

                        <div class="form-field">
                            <label>
                                <span><a href="cadastro.php">Cadastrar-se</a></span>
                            </label>
                        </div><br>
                        <br>

                        <div class="form-field center-align">
                            <input class="btn-large red" type="reset" name="cancelar" value="Cancelar">
                            <input class="btn-large red" type="submit" name="login" value="Login">
                        </div><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>