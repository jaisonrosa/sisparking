<?php

/**
 * Veiculo.class [ MODEL ]
 * 
 * Responsável por fazer a minupulação de dados e inserção no banco de dados
 *
 * @author jaison
 */
class Locacao {

    private $mensagem;
    private $result = null;
    private $tabela = DB_TABELA_LOCACAO;
    private $dados;

    /**
     * @param array $dados deve ser um array de 1 posição
     * 
     * ['veiculo'] = [id_cliente,tipo_veiculo,modelo,ano] 
     */
    public function iniciarLocacao(array $dados) {
        $this->dados = $dados;
        $this->dados['status'] = 1;
        $this->dados['custo'] = 0.00;

        $novaLocacao = new Create();
        $novaLocacao->exeCreate($this->tabela, $this->dados);

        $status['status'] = 1;
        $vaga = new Update();
        $vaga->exeUpdate(DB_TABELA_VAGA, $status, "WHERE id = :id", "id={$dados["id_vaga"]}");

        if ($novaLocacao->getResult()) {
            //retornara o ultimo ID da tabela ao inserir ou retornará null caso não seja possível cadastrar
            $this->result = $novaLocacao->getResult();
            $this->mensagem = "cadastro realizado com sucesso";
        }
    }

    public function buscarVagas($status = 0) {
        //$status 0 = livre
        //$status 1 = ocupado

        $read = new Read();
        $read->fullRead("SELECT * FROM " . DB_TABELA_VAGA . " WHERE status = :status ORDER BY id DESC", "status={$status}");
        $this->result = $read->getResult();

        if (!$read->getResult()) {
            $this->mensagem = "Dados não existentes no sistema!";
            $this->result = false;
        }
    }

    public function buscarLocacaoAtivaPorVaga($vaga) {

        $read = new Read();
        $read->fullRead("SELECT cliente.nome, cliente.telefone, veiculo.modelo, veiculo.placa, locacao.id, locacao.inicio, vaga.posicao, vaga.taxa, taxa.taxa_hora FROM " . DB_TABELA_LOCACAO . " INNER JOIN " . DB_TABELA_VEICULO . " ON locacao.id_veiculo = veiculo.id INNER JOIN " . DB_TABELA_CLIENTE . " ON veiculo.id_cliente = cliente.id INNER JOIN " . DB_TABELA_VAGA . " ON locacao.id_vaga = vaga.id INNER JOIN 
    " . DB_TABELA_TAXA . " ON vaga.taxa = taxa.id WHERE vaga.id = :id_vaga AND locacao.status =1", "id_vaga={$vaga}");
        $this->result = $read->getResult()[0];

        if (!$read->getResult()) {
            $this->mensagem = "Dados não existentes no sistema!";
            $this->result = false;
            return;
        }

        $this->result['tipo_vaga'] = $this->retornaTipoVeiculo($this->result['taxa']);
        $this->result['custo'] = $this->calcularAluguel($this->result['inicio'], $this->result['taxa_hora']);
        $this->result['fim'] = date('Y-m-d H:i:s');
    }

    public function buscarLocacoesPorStatus($status) {
        $read = new Read();
        $read->fullRead("SELECT veiculo.modelo, veiculo.placa, vaga.id AS id_vaga, vaga.posicao, locacao.inicio, vaga.taxa, taxa.taxa_hora FROM " . DB_TABELA_LOCACAO . " INNER JOIN " . DB_TABELA_VEICULO . " ON locacao.id_veiculo = veiculo.id INNER JOIN " . DB_TABELA_VAGA . " ON locacao.id_vaga = vaga.id INNER JOIN " . DB_TABELA_TAXA . " ON vaga.taxa = taxa.id WHERE locacao.status = :status;", "status={$status}");
        $this->result = $read->getResult();

        if (!$read->getResult()) {
            $this->mensagem = "Dados não existentes no sistema!";
            $this->result = false;
            return;
        }

        foreach ($this->getResult() as $key => $value) {
            $this->result[$key]['tipo_vaga'] = $this->retornaTipoVeiculo($value['taxa']);
            $this->result[$key]['custo'] = $this->calcularAluguel($value['inicio'], $value['taxa_hora']);
        }
    }

    private function retornaTipoVeiculo($tipo) {
        switch ($tipo) {
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
                $tipo = "não identificado";
                break;
        }
        return $tipo;
    }

    private function calcularAluguel($inicio, $taxa) {
        // Data e hora de chegada e encerramento (exemplos)
        $dataHoraChegada = $inicio;
        $dataHoraEncerramento = date('Y-m-d H:i:s');
        

        $taxaPorHora = $taxa; // Taxa por hora em reais
        // Converter datas para objetos DateTime
        $datetime1 = new DateTime($dataHoraChegada);
        $datetime2 = new DateTime($dataHoraEncerramento);

        // Calcular a diferença entre as datas
        $interval = $datetime1->diff($datetime2);

        // Total de horas (inclui horas e minutos)
        $totalHoras = $interval->h + ($interval->i / 60);
        if ($interval->d > 0) {
            $totalHoras += $interval->d * 24; // Adicionar horas dos dias completos
        }

        // Calcular o custo total
        $custoTotal = $totalHoras * $taxaPorHora;

        // Formatar o custo total para exibir com duas casas decimais
        $custoTotalFormatado = number_format($custoTotal, 2, ',', '.');

        return $custoTotalFormatado;
    }

    public function encerrarLocacao($id, array $dados) {
        $this->dados = $dados;
        $this->dados['status'] = 0;
        $this->dados['custo'] = str_replace(['R$', ' '], '', $this->dados['custo']);
        $this->dados['custo'] = str_replace(',', '.', $this->dados['custo']);

        $locacao = new Update();
        $locacao->exeUpdate($this->tabela, $this->dados, "WHERE id = :id", "id={$id}");

        $status['status'] = 0;
        $vaga = new Update();
        $vaga->exeUpdate(DB_TABELA_VAGA, $status, "WHERE id = :id", "id={$dados["id_vaga"]}");

        if ($locacao->getResult()) {
            //retornara o ultimo ID da tabela ao inserir ou retornará null caso não seja possível cadastrar
            $this->result = $locacao->getResult();
            $this->mensagem = "cadastro realizado com sucesso";
        }
    }

    public function getResult() {
        return $this->result;
    }

//
//    public function getMensagem() {
//        return $this->mensagem;
//    }
}
