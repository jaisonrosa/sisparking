<?php
/**
 * Cliente.class [ MODEL ]
 * 
 * Responsável por fazer a minupulação de dados e inserção no banco de dados
 *
 * @author jaison
 */
class Cliente {
    private $mensagem;
    private $result = null;

    /**
     * @param array $dados deve ser um array de 1 posição
     * 
     * ['cliente'] = [nome,email,telefone,identificador,tipo] 
     */
    public function cadastrarCliente(array $dados) {
        $create = new Create();
        $create->exeCreate(DB_TABELA_CLIENTE, $dados);
        if ($create->getResult()) {
            //retornara o ultimo ID da tabela ao inserir ou retornará null caso não seja possível cadastrar
            $this->result = $create->getResult();
            $this->mensagem = "cadastro realizado com sucesso";
        }
    }

    public function buscarClientes($query, $parseString = null) {
        $read = new Read();
        $read->fullRead($query, $parseString);
        $this->result = $read->getResult();

        if (!$read->getResult()) {
            $this->mensagem = "Dados não existentes no sistema!";
            $this->result = false;
        }
    }

    /**
     * <b>Atualizar o cliente:</b> Envelope os dados em uma array atribuitivo e informe o id de um cliente
     * para atualiza-la no banco de dados!
     * @param INT $id = id do cliente
     * @param ARRAY $dados = Atribuitivo
     */
    public function editarCliente($id, array $dados) {

        if (array_key_exists("nome", $dados)) {
            $dados["nome"] = Check::retirarAcentos(ucwords(strtolower($dados["nome"])));
        }
        if (array_key_exists("identificador", $dados)) {
            $dados["identificador"] = Filter::toNumeric($dados["identificador"]);
        }

        $dados["id"] = (int) Filter::toNumeric($id);

        if (in_array('', $dados)) {
            $this->error = ["Erro ao Atualizar: Para atualizar este registro preencha todos os campos!"];
            $this->result = false;
        } else {
            $update = new Update();
            $update->exeUpdate(DB_TABELA_CLIENTE, $dados, "WHERE id = :id", "id={$dados["id"]}");

            if ($update->getRowCount() >= 1) {
                $this->result = $update->getResult();
            }
        }
    }

    /**
     * <b>exeDelete:</b> Deletar uma linha no banco
     * @param INT $id = id do item no banco
     */
    
    public function deleteCliente($id) {
        $idDelete = (int) Filter::toNumeric($id);
        
        $delete = new Delete();
        $delete->exeDelete(DB_TABELA_CLIENTE, "WHERE id = :id", "id={$idDelete}");
        
        $this->result = $delete->getResult();
        if ($this->result) {
            $this->mensagem = "O registro foi removido com sucesso!";
        } else {
            $this->mensagem = "Epa! Confere ai deu Bug ao deletar!";
        }
    }

    public function getResult() {
        return $this->result;
    }

    public function getMensagem() {
        return $this->mensagem;
    }
}