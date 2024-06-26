<?php
require_once './app/Config.inc.php';
$vaga = filter_input(INPUT_GET, 'vaga', FILTER_SANITIZE_NUMBER_INT);

$busca = new Locacao();
$busca->buscarLocacaoAtivaPorVaga($vaga);
$locacao = $busca->getResult();
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Detalhamento da Locação</title>
        <link rel="stylesheet" href="styles.css">

    </head>
    <body>
        <?php
            require_once './templates/sidebar.php';
        ?>
        <div class="content">
            <div class="section">
                <h2>Vaga: <span class="highlight"><?= $locacao['posicao'] ?></span></h2>
                <p>Tipo: <?= $locacao['tipo_vaga'] ?> | Status: <span class="status status-ocupada">Ocupada</span></p>
            </div>

            <div class="section">
                <h2>Informações do Veículo</h2>
                <p>Modelo: <span><?= $locacao['modelo'] ?></span></p>
                <p>Placa: <span><?= $locacao['placa'] ?></span></p>
            </div>

            <div class="section">
                <h2>Informações do Cliente</h2>
                <p>Nome: <span><?= $locacao['nome'] ?></span></p>
                <p>Telefone: <span><?= $locacao['telefone'] ?></span></p>
            </div>

            <div class="section">
                <h2>Informações da Locação</h2>
                <p>Entrada: <span><?= $locacao['inicio'] ?></span></p>
                <p>Hora Atual: <span id="current-time"></span><?= $locacao['fim'] ?></p>
                <p>Custo Total: <span>R$ <?= $locacao['custo'] ?></span></p>
            </div>

            <form method="post" action="processa_cadastro_locacao.php">
                <input type="hidden" name="action" value="encerrar">
                <input type="hidden" name="id_locacao" value="<?= $locacao['id'] ?>">
                <input type="hidden" name="custo" value="<?= $locacao['custo'] ?>">
                <input type="hidden" name="fim" value="<?= $locacao['fim'] ?>">
                <input type="hidden" name="id_vaga" value="<?=$vaga?>">
                <div class="form-group margin-top-15">
                    <label for="pagamento">Forma de Pagamento</label>
                    <select id="pagamento" name="tipo_pagamento">
                        <option value="1">Dinheiro</option>
                        <option value="2">Cartão de Crédito</option>
                        <option value="3">Cartão de Débito</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit">Encerrar Locação</button>
                </div>
            </form>
        </div>
    </body>
</html>