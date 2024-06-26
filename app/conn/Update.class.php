<?php
/**
 * <b>Updade.class:</b>
 * Classe destinada as atualizações genéricas de nosso sistema
 *
 * @author Jaison
 */
class Update extends Connection {

    private $tabela; // tabela que iremos trabalhar
    private $dados;
    private $termos; // recebe a nossa query
    private $places; // recebe os campos que serão lidos
    private $result; // flag para sabermos se foi inserido ou não

    /** @var PDOStatement - responsável pela nossa query - utilizaresmo metodos da classe PDOStatement */
    private $update;

    /** @var PDO */
    private $connection;

    //métodos públicos

    /**
     * <b>exeUpdate:</b> Executa uma atualização simples junto ao banco de dados 
     * utilizando prepared statements.
     * 
     * @param STRING $tabela = Informa a tabela que vai fazer a leitura;
     * @param ARRAY $dados = Recebemos os valores a serem inseridos
     * @param STRING $termos = ex WHERE | ORDER | LIMIT | OFFSET
     * @param STRING $parseString = links
     * 
     * */
    public function exeUpdate($tabela,array $dados,$termos,$parseString) {
        $this->tabela = (string) $tabela;
        $this->dados = $dados;
        $this->termos = (string) $termos;
        
        parse_str($parseString, $this->places);
        $this->getSintaxe();
        $this->execute();
    }

    /**
     * <b>Obter resultado:</b> Numero de registro encontrados.
     * @return ARRAY $valor = array com os resultados 
     * 
     * */
    public function getResult() {
        return $this->result;
    }
    
    /**
     * <b>Contar Linhas:</b> Retorna o número de registros encontrados pela query.
     * 
     * @return INT $valor = Quantidade de registros encontrados no BD;
     * */
    public function getRowCount(){
        return $this->update->rowCount();
    }
    
    /**
     * <b>Alterar Places:</b> Chame esta função após fazer uma leitura no banco de dados.
     * O objetivo é alterar os valores dos links passados na leitura
     * do método utilizado, exeRead ou fullRead
     * */
    public function setPlaces($parseString){
        //armazenando dentro do places os valores recebidos em $parceString
        parse_str($parseString, $this->places);
        $this->getSintaxe();
        $this->execute();
    }


    //métodos privados

    /**
     * Obtem o objeto PDO e prepara a nossa query
     * */
    private function connect() {
        $this->connection = parent::getConnection();
        $this->update = $this->connection->prepare($this->update);
    }

    /*
     * Criamos a sintaxe para utilizar na query com Prepared Statements
     * */

    private function getSintaxe() {
        foreach ($this->dados as $key => $value) {
            $place[] = $key . ' = :' . $key;
        }
        
        $place = implode(', ', $place);
        $this->update = "UPDATE {$this->tabela} SET {$place} {$this->termos}";
    }

    /*
     * Obtem a conexao, a sintaxe e executa a query
     * */

    private function execute() {
        $this->connect();
        try {
            if($this->update->execute(array_merge($this->dados, $this->places))){
                $this->result = true;
            }  
        } catch (Exception $e) {
            $this->result = null;
            frontErro("<b>Erro ao atualizar dados:</b> {$e->getMessage()} ERRO #{$e->getCode()}",MS_ERROR, true);
        }
    }

}
