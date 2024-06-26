
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Cadastrar Cliente</title>
        <link rel="stylesheet" href="styles.css">
        <script>
            function applyDynamicScripts() {
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
                    }
                }

                updateIdentificadorLabel();
            }

            document.addEventListener('DOMContentLoaded', applyDynamicScripts);
        </script>
    </head>
    <body>
        <?php
            require_once './templates/sidebar.php';
        ?>
        <div class="content">
            <h2>Cadastrar Cliente</h2>
            <form method="post" class="form-container" action="processa_cadastro_cliente.php">
                <input type="hidden" name="action" value="cadastrar">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome"><br><br>

                <label for="tipo_pessoa">Tipo de Pessoa:</label>
                <select id="tipo_pessoa" name="tipo_pessoa">
                    <option value="física">Pessoa Física</option>
                    <option value="jurídica">Pessoa Jurídica</option>
                </select><br><br>

                <label for="identificador" id="identificador_label">CPF</label>
                <input type="text" id="identificador" name="identificador"><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email"><br><br>

                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone"><br><br>



                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </body>
</html>
