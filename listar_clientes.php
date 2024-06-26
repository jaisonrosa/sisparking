<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Listar Clientes</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php
            require_once './templates/sidebar.php';
        ?>
        <div class="content">
            <h2>Listar Clientes</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Pessoa</th>
                    <th>Ações</th>
                </tr>
                <?php
                require_once './app/Config.inc.php';

                $lista = new Cliente();
                $lista->buscarClientes("SELECT * FROM " . DB_TABELA_CLIENTE . " ORDER BY id DESC;");
                $linha = "";
                if ($lista->getResult()) {

                    foreach ($lista->getResult() as $posicao => $cliente) {
                        $tipo = "física";
                        if ($cliente['tipo_pessoa'] == 2) {
                            $tipo = "jurídica";
                        }
                        $linha .= "<tr>";
                        $linha .= "<td>{$cliente['id']}</td>";
                        $linha .= "<td>{$cliente['nome']}</td>";
                        $linha .= "<td>{$cliente['email']}</td>";
                        $linha .= "<td>{$cliente['telefone']}</td>";
                        $linha .= "<td>{$tipo}</td>";
                        $linha .= "<td class='action-buttons'>";
                        $linha .= "<a href='editar_cliente.php?id=" . $cliente['id'] . "'><button class='edit-button'>Editar</button></a>";
                        $linha .= "<form method='post' action='processa_cadastro_cliente.php' style='display:inline-block;'>";
                        $linha .= "<input type='hidden' name='id_cliente' value='{$cliente['id']}'>";
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