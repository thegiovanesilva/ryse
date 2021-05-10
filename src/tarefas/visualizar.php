<link rel="stylesheet" href="visualizar.css">
<?php include("../includes/header.php") ?>
<?php

    require_once ("../classes/Tarefa.php");
    $tarefa = new Tarefa();
    $tarefas = $tarefa->buscarTarefas();

    function impressao($value, $id, $today, $fim, $tarefasDia = false){
        $tmp = array_filter($value, function($valor) {
            return $valor == '';
        });
        foreach ($tmp as $key=>$val){
            $value[$key] = "null";
        }             

        echo ("<li><h3>".$value['nome']."</h3>");
        echo ("<p>".$value['descricao']."</p>");    

        echo "<p>Intervalos feitos hoje: ".(isset($value["intervalos"]) ? $value["intervalos"] : 0)."/".$value["intervalos_estimados"]."</p>";

        if (isset($value['data_limite']) && $value['data_limite'] != 'null') {
            echo ("<p>Data limite: ".date("d/m/Y", strtotime($value['data_limite']))."</p>");
        }
        
        if (isset($value['data_fim']) && $fim != NULL) {
            echo ("<p>Ultima vez atualizada ".date("d/m/Y", strtotime($value['data_fim']))."</p>");
        }

        if (!empty($value['repete'])){
            echo ("<div class='table'>".
                    ((in_array("Sun", $value['repete']))? "<p class='selecionado' style='background-color: rgb(8, 255, 20);'>D</p>" : "<p class='selecionado' style='background-color: rgb(8, 136, 255);'>D</p>")
                .
                    ((in_array("Mon", $value['repete']))? "<p class='selecionado' style='background-color: rgb(8, 255, 20);'>S</p>" : "<p class='selecionado' style='background-color: rgb(8, 136, 255);'>S</p>")
                .
                    ((in_array("Tue", $value['repete']))? "<p class='selecionado' style='background-color: rgb(8, 255, 20);'>T</p>" : "<p class='selecionado' style='background-color: rgb(8, 136, 255);'>T</p>")
                .
                    ((in_array("Wed", $value['repete']))? "<p class='selecionado' style='background-color: rgb(8, 255, 20);'>Q</p>" : "<p class='selecionado' style='background-color: rgb(8, 136, 255);'>Q</p>")
                .
                    ((in_array("Thu", $value['repete']))? "<p class='selecionado' style='background-color: rgb(8, 255, 20);'>Q</p>" : "<p class='selecionado' style='background-color: rgb(8, 136, 255);'>Q</p>")
                .
                    ((in_array("Fri", $value['repete']))? "<p class='selecionado' style='background-color: rgb(8, 255, 20);'>S</p>" : "<p class='selecionado' style='background-color: rgb(8, 136, 255);'>S</p>")
                .
                    ((in_array("Sat", $value['repete']))? "<p class='selecionado' style='background-color: rgb(8, 255, 20);'>S</p>" : "<p class='selecionado' style='background-color: rgb(8, 136, 255);'>S</p>")
                ."</div>");
        }

        echo ("<div class='icon'>");
            if ($tarefasDia) { echo ("<a class='done' href='confirma-concluido.php?id=$id' title='Concluir'><i class='material-icons'>bookmark_border</i></a>"); }
            echo ("<a class='contador' href='../contador/index.php?id=$id' title='Abrir temporizador'><i class='material-icons'>access_alarms</i></a>");
            echo ("<a class='edit' href='atualizar.php?id=$id' title='Editar'><i class='material-icons'>edit</i></a>");
            echo ("<a class='del' href='apagar.php?id=$id' title='Deletar'><i class='material-icons'>delete</i></a>");
        echo ("</div>");
        echo ("</li>");
    }
?>

    <main class="tela">
        <div class="tarefas">
            <h1 class="titulo">Tarefas do dia</h1>
            <ul class="lista">
                <?php 
                    foreach ($tarefas as $id=>$value) {
						$today = new DateTime(date('Y-m-d'));
						$limit = $value['data_limite'] != NULL? new DateTime(date($value['data_limite'])) : NULL;
                        $fim = $value['data_fim'] != NULL? new DateTime(date($value['data_fim'])) : NULL;

						if ( (
                            ($limit != NULL && $limit != $today) ||
                            (isset($value['repete']) && array_search(substr(date('l'),0,3), $value['repete']) == -1) ||
                            (($limit != NULL && $limit == $today) && ($fim != NULL && $fim == $today)) ||
                            ((isset($value['repete']) && array_search(substr(date('l'),0,3), $value['repete']) != -1) && ($fim != NULL && $fim == $today))) 
                        ) {     
							continue; 
						}
                        impressao($value, $id, $today,$fim, true);
                    }
                ?>  
            </ul>
        </div>

        <div class="tarefas">

            <h1 class="titulo">Tarefas Gerais</h1>
            
            <ul class="lista">
                <?php
                
                    foreach ($tarefas as $id=>$value) {
						$today = new DateTime(date('Y-m-d'));
						$limit = $value['data_limite'] != NULL? new DateTime(date($value['data_limite'])) : NULL;
                        $fim = $value['data_fim'] != NULL? new DateTime(date($value['data_fim'])) : NULL;
                        
						if ( !(
                            ($limit != NULL && $limit != $today) ||
                            (isset($value['repete']) && array_search(substr(date('l'),0,3), $value['repete']) == -1) ||
                            (($limit != NULL && $limit == $today) && ($fim != NULL && $fim == $today)) ||
                            ((isset($value['repete']) && array_search(substr(date('l'),0,3), $value['repete']) != -1) && ($fim != NULL && $fim == $today))) 
                        ) {     
							continue; 
						}
						impressao($value, $id, $today, $fim);
                    }
                ?>  
            </ul>
        </div>
    </main>
<script src="visualizar.js"></script>
<?php include("../includes/footer.php") ?>