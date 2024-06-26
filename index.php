<?php
require_once './app/Config.inc.php';
$vaga = new Read();
$vaga->exeRead(DB_TABELA_VAGA);

$busca = new Locacao();
$busca->buscarLocacoesPorStatus(1);
$locacoesAtivas = $busca->getResult();

$vagaCarros = [];
$vagaMotos = [];
$vagaUtilitarios = [];

$fechaDiv = "";

foreach ($vaga->getResult() as $key => $valor) {

    switch ((int) $valor['taxa']) {
        case 1:
            $vagaCarros[] = $valor;
            break;
        case 2:
            $vagaMotos[] = $valor;
            break;
        case 3:
            $vagaUtilitarios[] = $valor;
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu de Navegação</title>
        <link rel="stylesheet" href="styles.css">
        <script>

            function applyDynamicScripts() {
                // Função para atualizar o label do identificador
                function updateIdentificadorLabel() {
                    const tipoPessoa = document.getElementById('tipo_pessoa');
                    if (tipoPessoa) {
                        const identificadorLabel = document.getElementById('identificador_label');
                        tipoPessoa.addEventListener('change', function () {
                            if (this.value === 'fisica') {
                                identificadorLabel.textContent = 'CPF:';
                            } else if (this.value === 'juridica') {
                                identificadorLabel.textContent = 'CNPJ:';
                            } else {
                                identificadorLabel.textContent = 'CPF:';
                            }
                        });
                    }
                }

                updateIdentificadorLabel();
            }


        </script>
    </head>
    <body>
        <?php
            require_once './templates/sidebar.php';
        ?>
        <div class="content">
            <h1>Bem-vindo ao Sistema de Gerenciamento</h1>
            <p>Selecione uma opção no menu para começar.</p>
            <div class="block-container">
                <div class="block">
                    <h2>Carros</h2>
                    <?php
                    $lista1 = "";
                    $i = 0;

                    foreach ($vagaCarros as $value) {

                        $class = "vaga-livre";
                        $link = "registrar_locacao.php?vaga=" . $value['id'];
                        $i++;

                        if ($i == 1) {
                            $lista1 .= "<div class='parking-row'>";
                        }
                        if ($value['status'] == 1) {
                            $class = "vaga-ocupada";
                            $link = "locacao.php?vaga=" . $value['id'];
                        }

                        $lista1 .= "<a href='{$link}' class='parking-space {$class}'>Vaga {$value['posicao']}</a>";
                        if ($i == 5) {
                            $lista1 .= "</div>";
                            $i = 0;
                        }
                    }
                    echo $lista1;
                    ?>
                </div>

                <div class="block">
                    <h2>Motos</h2>
                    <?php
                    $lista2 = "";
                    $i = 0;

                    foreach ($vagaMotos as $value) {

                        $class = "vaga-livre";
                        $link = "registrar_locacao.php?vaga=" . $value['id'];
                        $i++;

                        if ($i == 1) {
                            $lista2 .= "<div class='parking-row'>";
                        }
                        if ($value['status'] == 1) {
                            $class = "vaga-ocupada";
                            $link = "locacao.php?vaga=" . $value['id'];
                        }

                        $lista2 .= "<a href='{$link}' class='parking-space {$class}'>Vaga {$value['posicao']}</a>";
                        if ($i == 5) {
                            $lista2 .= "</div>";
                            $i = 0;
                        }
                    }
                    echo $lista2;
                    ?>
                </div>

                <div class="block">
                    <h2>Utilitários</h2>
                    <?php
                    $lista3 = "";
                    $i = 0;
                    foreach ($vagaUtilitarios as $value) {

                        $class = "vaga-livre";
                        $link = "registrar_locacao.php?vaga=" . $value['id'];
                        $i++;

                        if ($i == 1) {
                            $lista3 .= "<div class='parking-row'>";
                        }
                        if ($value['status'] == 1) {
                            $class = "vaga-ocupada";
                            $link = "locacao.php?vaga=" . $value['id'];
                        }

                        $lista3 .= "<a href='{$link}' class='parking-space {$class}'>Vaga {$value['posicao']}</a>";
                        if ($i == 5) {
                            $lista3 .= "</div>";
                            $i = 0;
                        }
                    }
                    echo $lista3;
                    ?>
                </div>
            </div>
            <br><br><br>
            <h2>Listar Locações Ativas</h2>
            <table>
                <tbody><tr>
                        <th>Veículo</th>
                        <th>Vaga</th>
                        <th>Custo</th>
                        <th>Entrada</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    $html = "";
                    foreach ($locacoesAtivas as $key => $value) {

                        $html .= "<tr>";
                        $html .= "<td>placa:{$value['placa']} | {$value['modelo']}</td>";
                        $html .= "<td>posição:{$value['posicao']} | tipo:{$value['tipo_vaga']}</td>";
                        $html .= "<td>R$:{$value['custo']}</td>";
                        $html .= "<td>{$value['inicio']}</td>";
                        $html .= "<td class='action-buttons'>";
                        $html .= "<a href='locacao.php?vaga={$value['id_vaga']}'>";
                        $html .= "<button class='edit-button'>Detalhar</button>";
                        $html .= "</a>";
                    }

                    echo $html;
                    ?>

                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
