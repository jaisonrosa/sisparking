<?php

require_once './app/Config.inc.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$dados = array_map('strip_tags', $dados);

if(isset($dados['id_veiculo'])){
    $id = $dados['id_veiculo'];
    unset($dados['id_veiculo']);
}

$action = $dados['action'];
unset($dados['action']);

//O tipo de pessoa no BD será representado por 1 - fisica e 2 - juridica
//setando como pessoa física

$veiculo = new Veiculo();

switch ($action) {
    case 'cadastrar':
        $veiculo->cadastrarVeiculo($dados);
        // Código para cadastrar um veiculo
        break;

    case 'editar':
        $veiculo->editarVeiculo($id, $dados);
        // Código para editar um cliente
        break;

    case 'excluir':
        $veiculo->deleteVeiculo($id);
        // Código para excluir um cliente
        break;
    
    default:
        echo "Ação inválida";
        // Código para tratar ações inválidas
        break;
}

// Adicione aqui a lógica para salvar os dados no banco de dados
// Redireciona para a página de listagem de clientes
header('Location: listar_veiculos.php');
exit;
