<?php
require_once './app/Config.inc.php';
$id_vaga = filter_input(INPUT_GET, 'vaga', FILTER_SANITIZE_NUMBER_INT);
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Registrar Locação</title>
        <link rel="stylesheet" href="styles.css">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Obter o valor do parâmetro tipo de pessoa e definir o option correspondente no select
                function setaSelectVaga() {
                    const id = '<?= $id_vaga ?>';
                    if (id) {
                        document.getElementById('vaga').value = id;
                    }
                }

                setaSelectVaga();
            });

        </script>
    </head>
    <body>
        <?php
            require_once './templates/sidebar.php';
        ?>
        <div class="content">
            <h2>Registrar Locação</h2>
            <form method="post" class="form-container" action="processa_cadastro_locacao.php">
                <input type="hidden" name="action" value="cadastrar">


                <label for="vaga">Vagas Locação:</label>
                <select id="vaga" name="id_vaga">
                    <?php
                    $lista2 = new Locacao();
                    $lista2->buscarVagas();

                    $html = "";
                    if ($lista2->getResult()) {


                        foreach ($lista2->getResult() as $posicao => $vaga) {
                            $tipo = "indefinido";
                            switch ($vaga['taxa']) {
                                case 1:
                                    $tipo = "carro";
                                    break;
                                case 2:
                                    $tipo = "moto";
                                    break;
                                case 3:
                                    $tipo = "utilitário";
                                    break;
                            }

                            $html .= "<option value='{$vaga['id']}'>posição:{$vaga['posicao']} - {$tipo}</option>";
                        }
                        echo $html;
                    }
                    ?>

                </select><br><br>

                <label for="veiculo">Veículo:</label>
                <select id="veiculo" name="id_veiculo">
                    <option value="">Selecionar o veiculo</option>
                    <?php
                    $lista = new Veiculo();
                    $lista->buscarVeiculo("SELECT id,placa,modelo FROM " . DB_TABELA_VEICULO . " ORDER BY id DESC;");
                    $html = "";
                    if ($lista->getResult()) {

                        foreach ($lista->getResult() as $posicao => $veiculo) {
                            $html .= "<option value='{$veiculo['id']}'>placa:{$veiculo['placa']} | modelo:{$veiculo['modelo']} </option>";
                        }
                        echo $html;
                    }
                    ?>

                </select><br><br>

                <button type="submit">Locar Vaga</button>
            </form>
        </div>
    </body>
</html>
