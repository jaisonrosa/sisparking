<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Cadastrar Veículo</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php
            require_once './templates/sidebar.php';
        ?>
        <div class="content">
            <h2>Cadastrar Veículo</h2>
            <form method="post" class="form-container" action="processa_cadastro_veiculo.php">
                <input type="hidden" name="action" value="cadastrar">
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
                <input type="text" id="modelo" maxlength="7" class="placa" name="placa"><br><br>


                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo"><br><br>

                <label for="ano">Ano:</label>
                <input type="number" id="ano" name="ano"><br><br>

                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </body>
</html>