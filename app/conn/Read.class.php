<?php
/**
 * <b>Read.class:</b>
 * Classe destinada as leituras genéricas de nosso sistema
 *
 * @author Jaison
 */
class Read extends Connection {

    private $select; // recebe a nossa query
    private $places; // recebe os campos que serão lidos
    private $result; // flag para sabermos se foi inserido ou não

    /** @var PDOStatement - responsável pela nossa query - utilizaresmo metodos da classe PDOStatement */
    private $read;

    /** @var PDO */
    private $connection;

    //métodos públicos

    /**
     * <b>exeRead:</b> Executa uma leitura simples junto ao banco de dados 
     * utilizando prepared statements.
     * Basta informar o nome da tabela.
     * 
     * @param STRING $tabela = Informa a tabela que vai fazer a leitura;
     * @param STRING $termos = ex WHERE | ORDER | LIMIT | OFFSET
     * @param STRING $parseString = links
     * 
     * */
    public function exeRead($tabela, $termos = null, $parseString = null) {
        if (!empty($parseString)) {
            //armazenando dentro do places os valores recebidos em $parceString
            parse_str($parseString, $this->places);
            //montanto o nosso select
        }
        $this->select = "SELECT * FROM {$tabela} {$termos}";
        //echo $this->select;
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
     * <b>fullRead:</b> executa query passada manualmente.
     * @param STRING $query = query SQL
     * @param STRING $name Description STRING $parseString = links
     * 
     * */
    public function fullRead($query, $parseString = null){
        $this->select = (string) $query;
        if(!empty($parseString)){
            //armazenando dentro do places os valores recebidos em $parceString
            parse_str($parseString, $this->places);
        }
        $this->execute();
    }
    
    /**
     * <b>Contar Linhas:</b> Retorna o número de registros encontrados pela query.
     * 
     * @return INT $valor = Quantidade de registros encontrados no BD;
     * */
    public function getRowCount(){
        return $this->read->rowCount();
    }
    
    /**
     * <b>Alterar Places:</b> Chame esta função após fazer uma leitura no banco de dados.
     * O objetivo é alterar os valores dos links passados na leitura
     * do método utilizado, exeRead ou fullRead
     * */
    public function setPlaces($parseString){
        //armazenando dentro do places os valores recebidos em $parceString
        parse_str($parseString, $this->places);
        $this->execute();
    }


    //métodos privados

    /**
     * Obtem o objeto PDO e prepara a nossa query
     * */
    private function connect() {
        $this->connection = parent::getConnection();
        $this->read = $this->connection->prepare($this->select);
        //define o retorno do PDO como array
        $this->read->setFetchMode(PDO::FETCH_ASSOC);
    }

    /*
     * Criamos a sintaxe para utilizar na query com Prepared Statements
     * */

    private function getSintaxe() {
        if ($this->places) {
            foreach ($this->places as $vinculo => $valor) {
                if ($vinculo == 'limit' || $vinculo == 'offset') {
                    $valor = (int) $valor;
                }
                $this->read->bindValue(":{$vinculo}", $valor, (is_int($valor) ? PDO:: PARAM_INT : PDO::PARAM_STR));
            }
        }
    }

    /*
     * Obtem a conexao, a sintaxe e executa a query
     * */

    private function execute() {
        $this->connect();
        try {
            $this->getSintaxe();
            $this->read->execute();
            $this->result = $this->read->fetchAll();
        } catch (Exception $e) {
            $this->result = null;
            frontErro("<b>Erro ao ler:</b> {$e->getMessage()} ERRO #{$e->getCode()}",MS_ERROR, true);
        }
    }

}
