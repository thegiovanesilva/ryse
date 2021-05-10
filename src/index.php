<?php include("includes/header.php") ?>
    <!-- CSS -->
    <link href="css/index.css" rel="stylesheet">
    <div class='area'>
        <div class="left">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ullamcorper porttitor neque at placerat. Ut placerat nisl in metus tristique efficitur. Aenean tincidunt dignissim finibus. Nulla sapien sapien, hendrerit quis feugiat sed, convallis ac dolor. Proin nulla magna, mattis nec nisi eget, dapibus mollis dui. Mauris mi felis, vulputate nec quam at, tincidunt pharetra ipsum. Maecenas dictum nisi in purus posuere varius in ut augue. Phasellus lobortis nisl sit amet diam ornare, et lacinia tellus molestie. Vivamus lobortis ultrices condimentum. Suspendisse et molestie ipsum. Praesent fermentum turpis et euismod pulvinar. Sed malesuada auctor ligula eu fringilla.

    Sed sed risus nec ante ullamcorper suscipit. Phasellus id viverra neque. Vestibulum pretium odio nec ornare mattis. Aenean scelerisque feugiat mi, sed efficitur odio imperdiet nec. Ut quis ante commodo, vulputate ipsum non, lobortis dolor. Curabitur porttitor, odio sed semper dapibus, nulla leo vestibulum diam, sit amet consectetur risus libero pulvinar nulla. Nulla ornare, quam in fringilla varius, nunc dui sagittis nunc, in ullamcorper lorem leo eu nisi. Fusce sodales faucibus dolor vel sodales. Sed vel pretium dui. Nam vel ligula vitae sapien blandit pharetra. Vivamus pretium nisi vulputate eros auctor sollicitudin. Nulla faucibus maximus auctor. In sit amet ex sem. Pellentesque hendrerit, arcu eget ornare lacinia, magna libero lobortis leo, at interdum magna massa ut leo.

    Fusce tempus, orci at pulvinar fermentum, mauris dui lacinia lectus, a feugiat tellus elit ullamcorper quam. Ut fringilla faucibus odio, in lobortis tellus volutpat et. Nam scelerisque risus vel diam ultrices faucibus. Donec tempor eros eget orci tincidunt semper. Fusce ullamcorper egestas nunc nec hendrerit. Praesent facilisis dictum justo eu pretium. Nullam dictum, tellus at consectetur sodales, nulla felis sagittis risus, at pulvinar mauris nunc in lectus. Nunc a nulla lectus.

    Suspendisse commodo tempor felis, a dapibus erat efficitur sit amet. Nam sagittis arcu ac odio euismod malesuada sit amet a purus. Nam auctor, arcu sit amet lacinia vulputate, diam dui tristique ex, sed gravida est quam sed justo. Etiam vel gravida massa. Morbi elit dolor, ullamcorper ut dictum eu, viverra non turpis. Suspendisse eget eleifend tortor. Suspendisse tempus finibus tortor. Integer sit amet euismod tortor, quis tempus sem. Vestibulum eu vulputate lectus. Donec aliquet a elit at tempus. Sed id imperdiet dolor, at pharetra magna.

    Fusce nec consequat neque, ut porttitor lacus. Vivamus arcu sapien, viverra vel risus sit amet, commodo interdum lorem. Proin ut aliquet arcu. Vivamus molestie egestas erat vel lobortis. Vivamus ullamcorper felis ac ullamcorper efficitur. Donec eget velit dui. Suspendisse semper enim eu quam placerat, eu pretium turpis gravida. Nulla faucibus semper nisl at accumsan. Donec tempor tincidunt urna non imperdiet. Pellentesque vehicula aliquam risus et vulputate. Proin consequat in est quis malesuada. Proin tincidunt felis non libero tincidunt facilisis. Sed scelerisque iaculis erat, at dapibus tortor imperdiet vel. Proin non venenatis leo, quis convallis dui. Curabitur id rutrum risus.</p>
        </div>
        <div class="right">
            <?php if (isset($_SESSION['id'])){ ?>
                <div>
                    <h3>Seja bem vindo <?=$_SESSION['nome']?></h3>
                </div>
                <?php }else{ ?>
                <div class='login'>
                    <form action="usuario/login.php" method="POST" class="form">
                        <div class="div-email">
                            <label for="email">E-mail: </label>
                            <input type="email" class="texto" name="email" required>
                        </div><br>

                        <div class="div-senha">
                            <label for="senha">Senha: </label>
                            <input type="password"  class="texto" name="senha" required>
                        </div><br>

                        <div class="acessar">
                            <input type="submit" class="botao" name="login" value="Login">
                        </div><br>
                    </form>
                    <div class="linha"></div>
                    <a href="usuario/cadastro.php"><button class="botaoC">Cadastrar-se</button></a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php include("includes/footer.php") ?>
