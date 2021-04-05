<link href="temporizador.css" rel="stylesheet"/>

<?php include("../includes/header.php") ?>
    <main>
        <div class="screen">
            <h1 id="titulo">Temporizador</h1>
            <span id="tempo">25:00</span>

            <div id="imagens">
                <img src="../imgs/25min.jpg" id="imagem">
            </div>
                <input type="text" id="texto" value="Hora de trabalhar" disabled>            

            <input type="button" onClick=start() id="botao" value="Iniciar"/>

            <span value="Hora de trabalhar">Você Já fez:</span>

            <div id="contador"></div>
        </div>
    </main>
    <script src="contador.js"></script>
<?php include("../includes/footer.php") ?>
