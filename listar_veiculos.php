<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Listar Veículos</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php
            require_once './templates/sidebar.php';
        ?>
        <div class="content">
            <h2>Listar Veículos</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Placa</th>
                    <th>Modelo</th>
                    <th>Tipo</th>
                    <th>Ano</th>
                    <th>Proprietário</th>
                    <th>Ações</th>
                </tr>
                <!-- Exemplo de dados -->
                <?php
                require_once './app/Config.inc.php';

                $lista = new Veiculo();
                $lista->buscarVeiculo("SELECT * FROM " . DB_TABELA_VEICULO . " ORDER BY id DESC;");
                $linha = "";
                if ($lista->getResult()) {

                    $cliente = new Cliente();

                    foreach ($lista->getResult() as $posicao => $veiculo) {

                        $tipo = "";
                        switch ($veiculo['tipo_veiculo']) {
                            case 1:
                                $tipo = "carro";
                                break;
                            case 2:
                                $tipo = "moto";
                                break;
                            case 3:
                                $tipo = "utilitário";
                                break;

                            default:
                                $tipo = "indefinido";
                                break;
                        }

                        $cliente->buscarClientes("SELECT nome FROM cliente " . DB_TABELA_CLIENTE . " WHERE id=:id", "id={$veiculo['id_cliente']}");

                        $linha .= "<tr>";
                        $linha .= "<td>{$veiculo['id']}</td>";
                        $linha .= "<td>{$veiculo['placa']}</td>";
                        $linha .= "<td>{$veiculo['modelo']}</td>";
                        $linha .= "<td>{$veiculo['tipo_veiculo']}</td>";
                        $linha .= "<td>{$veiculo['ano']}</td>";
                        $linha .= "<td>{$cliente->getResult()[0]['nome']}</td>";

                        $linha .= "<td class='action-buttons'>";
                        $linha .= "<a href='editar_veiculo.php?id=" . $veiculo['id'] . "'><button class='edit-button'>Editar</button></a>";
                        $linha .= "<form method='post' action='processa_cadastro_veiculo.php' style='display:inline-block;'>";
                        $linha .= "<input type='hidden' name='id_veiculo' value='{$veiculo['id']}'>";
                        $linha .= "<input type='hidden' name='action' value='excluir'>";
                        $linha .= "<button type='submit' class='delete-button'>Excluir</button>";
                        $linha .= "</form>";
                        $linha .= "</td>";
                        $linha .= "</tr>";
                    }
                }
                echo $linha;
                ?>
            </table>
        </div>
    </body>
</html>
