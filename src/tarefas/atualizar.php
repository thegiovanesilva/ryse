<?php
    @session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: /");
    }
    
    require_once("../classes/Tarefa.php");

    $tarefa = new Tarefa();
    
    // Validação de dados
    $id = $_GET['id'];

    $t_ret = $tarefa->buscarTarefas($_SESSION['id'], $id);

    if ($t_ret == "Falha na consulta" || !count($t_ret)){   
        header("Location: visualizar.php");
    }
    $t_ret = $t_ret[$id];
    if(!isset($t_ret['repete'])) $t_ret['repete'] = [];
?>
<?php include("../includes/header.php") ?>

<!--n Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<link rel="stylesheet" href="criar.css"/>

<main class="container">
    <form method="post" action="confirma-atualiza.php?id=<?=$id?>">
        <div class="mb-3">
            <label for="name" class="form-label">Nome da Tarefa</label>
            <input type="text" name="nome" class="form-control" id="name" value="<?=$t_ret['nome']?>" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" name="descricao" class="form-control" id="descricao" value="<?=$t_ret['descricao']?>"required>
        </div>

        <div class="mb-3">
            <label for="intervalos_estimados" class="form-label">Intervalos estimados</label>
            <input type="number" name="intervalos_estimados" class="form-control" id="intervalos_estimados" value="<?=$t_ret['intervalos_estimados']?>" min="1" required>
        </div>

        <!-- Definição do prazo -->
        <div class="form-check">
            <input onchange="alternar_prazo();" class="form-check-input" type="radio" name="prazo" value="data-limite" id="data-limite" <?= (isset($t_ret['data_limite'])) ? "checked" : "" ?>
>
            <label class="form-check-label" for="data-limite">
                Data limite
            </label>
        </div>
        <div class="form-check">
            <input onchange="alternar_prazo();" class="form-check-input" type="radio" name="prazo" value="prazo-recorrente" id="prazo-recorrente" <?= (isset($t_ret['data_limite'])) ? "" : "checked" ?> >
            <label class="form-check-label" for="prazo-recorrente">
                Prazo recorrente
            </label>
        </div>

        <input type="text" name="data_fim" value="<?=$t_ret['data_fim']?>" hidden>

        <!-- Definição dos dias dos prazos -->
        <br>
        <?php if(isset($t_ret['data_limite'])){?>
        <div id="data-limite-div">
        <?php }else {?>
        <div id="data-limite-div" hidden>
        <?php }?>
            <div class="form-group"> <!-- Date input -->
                <label class="control-label" for="date">Date</label>
                <input class="form-control" id="date" name="date" placeholder="DD/MM/YYYY" type="text" value="<?=date("d/m/Y",  strtotime($t_ret['data_limite']))?>"/>
            </div>
        </div>

        
        <?php if(isset($t_ret['data_limite'])){ ?>
        <div id="prazo-recorrente-div" hidden>
        <?php }else{?>
        <div id="prazo-recorrente-div">
        <?php } ?>
            <table class="table">
                <tr>
                   <th>Domingo</th>
                   <th>Segunda</th>
                   <th>Terça</th>
                   <th>Quarta</th>
                   <th>Quinta</th>
                   <th>Sexta</th>
                   <th>Sabado</th>
                </tr>
                <tr>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Sun" id="check-domingo" <?= (in_array('Sun', $t_ret['repete'])) ? "checked" : ""; ?> >
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Mon" id="check-segunda" <?= (in_array('Mon', $t_ret['repete'])) ? "checked" : ""; ?>>
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Tue" id="check-terca" <?= (in_array('Tue', $t_ret['repete'])) ? "checked" : ""; ?>>
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Wed" id="check-quarta" <?= (in_array('Wed', $t_ret['repete'])) ? "checked" : ""; ?>>
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Thu" id="check-quinta" <?= (in_array('Thu', $t_ret['repete'])) ? "checked" : ""; ?>>
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Fri" id="check-sexta" <?= (in_array('Fri', $t_ret['repete'])) ? "checked" : ""; ?>>
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Sat" id="check-sabado" <?= (in_array('Sat', $t_ret['repete'])) ? "checked" : ""; ?>>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
</main>

<script src="criar.js"></script>

<?php include("../includes/footer.php") ?>
