<?php
require_once './app/Config.inc.php';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$veiculo = new Veiculo();
$veiculo->buscarVeiculo("SELECT * FROM " . DB_TABELA_VEICULO . " WHERE id=:id", "id={$id}");

if (!isset($veiculo->getResult()[0])) {
    header('Location: listar_veiculos.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Editar Veículo</title>
        <link rel="stylesheet" href="styles.css">
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                // Obter o valor do parâmetro tipo de pessoa e definir o option correspondente no select
                function setaSelects() {
                    const tipo = '<?= $veiculo->getResult()[0]['tipo_veiculo'] ?>';
                    const prop = '<?= $veiculo->getResult()[0]['id_cliente'] ?>';

                    if (tipo) {
                        document.getElementById('tipo_veiculo').value = tipo;
                    }
                    if (prop) {
                        document.getElementById('cliente').value = prop;
                    }
                }

                setaSelects();
            });

        </script>
    </head>
    <body>
        <?php
            require_once './templates/sidebar.php';
        ?>
        <div class="content">
            <h2>Editar Veículo</h2>
            <form method="post" class="form-container"action="processa_cadastro_veiculo.php">
                <input type="hidden" name="action" value="editar">
                <input type="hidden" name="id_veiculo" value="<?= $id ?>">
                <label for="cliente">Cliente:</label>
                <select id="cliente" name="id_cliente">
                    <option value="">Selecionar cliente</option>
                    <?php
                    require_once './app/Config.inc.php';

                    $lista = new Cliente();
                    $lista->buscarClientes("SELECT id,nome FROM " . DB_TABELA_CLIENTE . " ORDER BY id DESC;");
                    $html = "";
                    if ($lista->getResult()) {

                        foreach ($lista->getResult() as $posicao => $cliente) {
                            $html .= "<option value='{$cliente['id']}'>{$cliente['nome']}</option>";
                        }
                        echo $html;
                    }
                    ?>

                </select><br><br>

                <select id="tipo_veiculo" name="tipo_veiculo">
                    <option value="">Selecionar tipo de veículo</option>
                    <option value="1">Carro</option>
                    <option value="2">Moto</option>
                    <option value="3">Utilitário</option>
                    <!-- Adicione outras opções de clientes aqui -->
                </select><br><br>

                <label for="placa">Placa:</label>
                <input type="text" id="modelo" maxlength="7" class="placa" name="placa" value="<?= $veiculo->getResult()[0]['placa'] ?>"><br><br>


                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" value="<?= $veiculo->getResult()[0]['modelo'] ?>"><br><br>

                <label for="ano">Ano:</label>
                <input type="number" id="ano" name="ano" value="<?= $veiculo->getResult()[0]['ano'] ?>"><br><br>

                <button type="submit">Editar</button>
            </form>
        </div>
    </body>
</html>