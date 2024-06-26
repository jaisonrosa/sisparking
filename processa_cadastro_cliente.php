<?php

require_once './app/Config.inc.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$dados = array_map('strip_tags', $dados);

if(isset($dados['id_cliente'])){
    $id = $dados['id_cliente'];
    unset($dados['id_cliente']);
}

$action = $dados['action'];
unset($dados['action']);

if ($dados['tipo_pessoa'] === "jurídica") {
    $dados['tipo_pessoa'] = 2;
} else {
    $dados['tipo_pessoa'] = 1;
}

//O tipo de pessoa no BD será representado por 1 - fisica e 2 - juridica
//setando como pessoa física

$cliente = new Cliente();

switch ($action) {
    case 'cadastrar':
        $cliente->cadastrarCliente($dados);
        // Código para cadastrar um cliente
        break;

    case 'editar':

        $cliente->editarCliente($id, $dados);
        // Código para editar um cliente
        break;

    case 'excluir':
        $cliente->deleteCliente($id);
        // Código para excluir um cliente
        break;

    default:
        echo "Ação inválida";
        // Código para tratar ações inválidas
        break;
}


// Adicione aqui a lógica para salvar os dados no banco de dados
// Redireciona para a página de listagem de clientes
header('Location: listar_clientes.php');
exit;
