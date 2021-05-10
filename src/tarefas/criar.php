<?php include("../includes/header.php") ?>

<!--n Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<link rel="stylesheet" href="criar.css"/>

<main class="container">
    <form method="post" action="confirma.php">
        <div class="mb-3">
            <label for="name" class="form-label">Nome da Tarefa</label>
            <input type="text" name="nome" class="form-control" id="name" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" name="descricao" class="form-control" id="descricao" required>
        </div>

        <div class="mb-3">
            <label for="intervalos_estimados" class="form-label">Intervalos estimados</label>
            <input type="number" name="intervalos_estimados" class="form-control" id="intervalos_estimados" min="1" value="1" required>
        </div>

        <!-- Definição do prazo -->
        <div class="form-check">
            <input onchange="alternar_prazo();" class="form-check-input" type="radio" name="prazo" value="data-limite" id="data-limite" checked>
            <label class="form-check-label" for="data-limite">
                Data limite
            </label>
        </div>
        <div class="form-check">
            <input onchange="alternar_prazo();" class="form-check-input" type="radio" name="prazo" value="prazo-recorrente" id="prazo-recorrente">
            <label class="form-check-label" for="prazo-recorrente">
                Prazo recorrente
            </label>
        </div>

        <!-- Definição dos dias dos prazos -->
        <br>
        <div id="data-limite-div">
            <div class="form-group"> <!-- Date input -->
                <label class="control-label" for="date">Date</label>
                <input class="form-control" id="date" name="date" placeholder="DD/MM/YYYY" type="text" required/>
            </div>
        </div>

        <div id="prazo-recorrente-div" hidden>
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
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Sun" id="check-domingo">
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Mon" id="check-segunda">
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Tue" id="check-terca">
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Wed" id="check-quarta">
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Thu" id="check-quinta">
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Fri" id="check-sexta">
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="recorrente[]" value="Sat" id="check-sabado">
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
