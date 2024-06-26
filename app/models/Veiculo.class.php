<?php
/**
 * Veiculo.class [ MODEL ]
 * 
 * Responsável por fazer a minupulação de dados e inserção no banco de dados
 *
 * @author jaison
 */
class Veiculo {
    private $mensagem;
    private $result = null;
    private $tabela = DB_TABELA_VEICULO;
    private $dados;

    /**
     * @param array $dados deve ser um array de 1 posição
     * 
     * ['veiculo'] = [id_cliente,tipo_veiculo,modelo,ano] 
     */
    public function cadastrarVeiculo(array $dados) {
        $this->dados = $dados;
        $create = new Create();
        $create->exeCreate($this->tabela, $this->dados);
        if ($create->getResult()) {
            //retornara o ultimo ID da tabela ao inserir ou retornará null caso não seja possível cadastrar
            $this->result = $create->getResult();
            $this->mensagem = "cadastro realizado com sucesso";
        }
    }

    public function buscarVeiculo($query, $parseString = null) {
        $read = new Read();
        $read->fullRead($query, $parseString);
        $this->result = $read->getResult();

        if (!$read->getResult()) {
            $this->mensagem = "Dados não existentes no sistema!";
            $this->result = false;
        }
    }

    /**
     * <b>Atualizar o veiculo:</b> Envelope os dados em uma array atribuitivo e informe o id de um veiculo
     * para atualiza-la no banco de dados!
     * @param INT $id = id do veiculo
     * @param ARRAY $dados = Atribuitivo
     */
    public function editarVeiculo($id, array $dados) {

        if (array_key_exists("modelo", $dados)) {
            $dados["modelo"] = Check::retirarAcentos(ucwords(strtolower($dados["modelo"])));
        }
        
        $dados["id"] = (int) Filter::toNumeric($id);

        if (in_array('', $dados)) {
            $this->error = ["Erro ao Atualizar: Para atualizar este registro preencha todos os campos!"];
            $this->result = false;
        } else {
            $update = new Update();
            $update->exeUpdate($this->tabela, $dados, "WHERE id = :id", "id={$dados["id"]}");

            if ($update->getRowCount() >= 1) {
                $this->result = $update->getResult();
            }
        }
    }

    /**
     * <b>exeDelete:</b> Deletar uma linha no banco
     * @param INT $id = id do item no banco
     */
    
    public function deleteVeiculo($id) {
        $idDelete = (int) Filter::toNumeric($id);
        
        $delete = new Delete();
        $delete->exeDelete($this->tabela, "WHERE id = :id", "id={$idDelete}");
        
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