
<link rel="stylesheet" href="visualizar.css">
<?php
    require_once ("../classes/Tarefa.php");
    $tarefa = new Tarefa();
    $res = $tarefa->buscarTarefas();
?>

<?php include("../includes/header.php") ?>
    <script>
        var tarefas_ret = {
        <?php
            foreach ($res as $key=>$value) {
                echo $key . ": {";
                echo "nome: '" . $value["nome"] . "',";
                echo "descricao: '" . $value["descricao"] . "',";
                if (!empty($value["data_limite"])) echo "data_limite: '" . $value["data_limite"] . "',";
                if (!empty($value["data_fim"])) echo "data_fim: '" . $value["data_fim"] . "',";
                if (!empty($value["repete"])) {
                    echo "repete: [";
                    foreach ($value["repete"] as $r) {
                        echo "'". $r. "',";
                    }
                    echo "]";
                }
                
                echo "},\n";
            }
        ?>
        }
    </script>
    <main>
        <div class="screen">
        <div class="tarefas-do-dia">
            <h1 id="titulo">Tarefas do dia</h1>
                <ol>
                    <li>Tarefa X
                    <table class="tarefa">
                        <tr>
                            <td>Nome</td>
                            <td>Tarefa</td>
                        </tr>
                        <tr>
                            <td>Descrição</td>
                            <td>Lacus nulla suspendisse metus, morbi</td>
                        </tr>
                        <tr>
                            <td>Data limite: 00/00/00</td>
                            <td>Data finalização: 00/00/00</td>
                            <td>Data recorrente: Domingo<td>
                        </tr>
                    </table>
                    </li>
                    <li>Tarefa Z
                    <table>
                        <tr>
                            <td>Nome</td>
                            <td>Tarefa</td>
                        </tr>
                        <tr>
                            <td>Descrição</td>
                            <td>Lacus nulla suspendisse metus, morbi</td>
                        </tr>
                        <tr>
                            <td>Data limite: 00/00/00</td>
                            <td>Data finalização: 00/00/00</td>
                            
                        </tr>
                    </table>
                    </li>

                <ol>
            </div>
            <div class="tarefas-gerais">
            <h1 id="titulo">Tarefas gerais</h1>
                <ol>
                    <li>Tarefa Y
                    <table>
                        <tr>
                            <td>Nome</td>
                            <td>Tarefa</td>
                        </tr>
                        <tr>
                            <td>Descrição</td>
                            <td>Lacus nulla suspendisse metus, morbi</td>
                        </tr>
                        <tr>
                            <td>Data limite: 00/00/00</td>
                            <td>Data finalização: 00/00/00</td>
                            <td>Data recorrente: Domingo<td>
                        </tr>
                    </table>
                    </li>

                <ol>
            </div>
</div>


<script>
<?
var hoje = data.getDay(); // 0-6 (zero=domingo)
var compare = {'dom':0, 'seg':1, 'ter':2, 
                'qua':3, 'qui':4, 'sex':5, 'sab':6};                
$itens = $tarefas_ret; 
 
foreach($itens as $e){
    if($e->repete && compare[$e->repete] == hoje){
        echo "$e->nome<br> $e->descricao<br> $e->data_limite<br> $e->data_fim<br>$e->repete<br>";
    }
    else if(!$e->repete || $e->repete == null){
        echo "$e->nome<br> $e->descricao<br> $e->data_limite<br> $e->data_fim<br>$e->repete<br>";
    }
    else {
        echo "não existem tarefas cadastradas!";
    }
?>

</script>

    </main>
<?php include("../includes/footer.php") ?>
