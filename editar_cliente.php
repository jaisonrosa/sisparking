<?php
require_once './app/Config.inc.php';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$cliente = new Cliente();
$cliente->buscarClientes("SELECT * FROM " . DB_TABELA_CLIENTE . " WHERE id=:id", "id={$id}");
$dados = $cliente->getResult()[0];
if (!isset($dados)) {
    header('Location: listar_clientes.php');
    exit;
}

$dados['tipo_pessoa'] = ($dados['tipo_pessoa'] == 1) ? "física" : "jurídica";
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Editar Cliente</title>
        <link rel="stylesheet" href="styles.css">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Função para atualizar o label do identificador
                function updateIdentificadorLabel() {
                    const tipoPessoa = document.getElementById('tipo_pessoa');
                    if (tipoPessoa) {
                        const identificadorLabel = document.getElementById('identificador_label');
                        tipoPessoa.addEventListener('change', function () {
                            if (this.value === 'física') {
                                identificadorLabel.textContent = 'CPF:';
                            } else if (this.value === 'jurídica') {
                                identificadorLabel.textContent = 'CNPJ:';
                            } else {
                                identificadorLabel.textContent = 'CPF:';
                            }
                        });

                        // Inicializa o valor do label quando a página carrega
                        if (tipoPessoa.value === 'física') {
                            identificadorLabel.textContent = 'CPF:';
                        } else if (tipoPessoa.value === 'jurídica') {
                            identificadorLabel.textContent = 'CNPJ:';
                        }
                    }
                }

                // Obter o valor do parâmetro tipo de pessoa e definir o option correspondente no select
                function setaLabelIdentificador() {
                    const tipo = '<?= $dados['tipo_pessoa'] ?>';
                    if (tipo) {
                        document.getElementById('tipo_pessoa').value = tipo;
                    }
                    updateIdentificadorLabel();
                }

                updateIdentificadorLabel();
                setaLabelIdentificador();
            });

        </script>
    </head>
    <body>
        <?php
            require_once './templates/sidebar.php';
        ?>
        <div class="content">
            <h2>Editar Cliente</h2>
            <form method="post" class="form-container" action="processa_cadastro_cliente.php">
                <input type="hidden" name="id_cliente" value="<?= $id ?>">
                <input type="hidden" name="action" value="editar">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?= $dados['nome'] ?>"><br><br>

                <label for="tipo_pessoa">Tipo de Pessoa:</label>
                <select id="tipo_pessoa" name="tipo_pessoa">
                    <option value="física">Pessoa Física</option>
                    <option value="jurídica">Pessoa Jurídica</option>
                </select><br><br>

                <label for="identificador" id="identificador_label">CPF</label>
                <input type="text" id="identificador" name="identificador" value="<?= $dados['identificador'] ?>"><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= $dados['email'] ?>"><br><br>

                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" value="<?= $dados['telefone'] ?>"><br><br>



                <button type="submit">editar</button>
            </form>
        </div>
    </body>
</html>