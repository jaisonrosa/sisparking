<?php

/**
 * Connection.class [CONEXÃO]
 * Classe Abstrata que retornará uma conexão
 * Retorna um objeto PDO por meio do método estatico getConnection();
 * @author Jaison
 */
abstract class Connection {

    private static $host = HOST;
    private static $user = USER;
    private static $pass = PASS;
    private static $base = BASE;

    /** @var PDO retorna um obj PDO */
    private static $connect = null;

    private static function conectar() {
        try {
            if (self::$connect == null) {
                //cada banco tem o seu formato de DSN
                $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$base;
                //configura como o meu banco vai trabalhar, nesta caso config os caracteres como UTF8
                $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                self::$connect = new PDO($dsn, self::$user, self::$pass, $options);
            }
        } catch (Exception $e) {
            backErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            die;
        }
        //aqui setamos o tipo de erro que o PDO vai trabalhar
        self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //aqui retornamos a conexão
        return self::$connect;
    }

    protected static function getConnection() {
        return self::conectar();
    }

}
