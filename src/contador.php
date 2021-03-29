<link href="css/temporizador.css" rel="stylesheet"/>
<?php
    $minutos = 15;
    $segundos = 59;
?>

<?php include("includes/header.php") ?>
    <main>
        <div class="screen">
            <h1 id="titulo">Temporizador</h1>
            <p id="tempo"><?= $minutos ?>:<?= $segundos?></p>
        </div>
    </main>
<?php include("includes/footer.php") ?>
