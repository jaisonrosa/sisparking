<?php

require_once './app/Config.inc.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$dados = array_map('strip_tags', $dados);

if(isset($dados['id_locacao'])){
    $id = $dados['id_locacao'];
    unset($dados['id_locacao']);
}

$action = $dados['action'];
unset($dados['action']);

//O tipo de pessoa no BD será representado por 1 - fisica e 2 - juridica
//setando como pessoa física

$locacao = new Locacao();

switch ($action) {
    case 'cadastrar':
        $locacao->iniciarLocacao($dados);
        // Código para cadastrar um veiculo
        break;

    case 'encerrar':
        $locacao->encerrarLocacao($id,$dados);
        // Código para editar um cliente
        break;

    case 'excluir':
        //$veiculo->deleteVeiculo($id);
        // Código para excluir um cliente
        break;
}

// Adicione aqui a lógica para salvar os dados no banco de dados
// Redireciona para a página de listagem de clientes
header('Location: index.php');
exit;

