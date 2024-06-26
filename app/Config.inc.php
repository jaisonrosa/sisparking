<?php
ini_set('default_charset','UTF-8');
//definindo horário local
date_default_timezone_set('America/Sao_Paulo');
//CONFIGURACAO DE BANCO ###################################
define("HOST",'localhost');
define("USER",'root');
define("PASS",'');
define("BASE",'sisparking');

//CONFIGURACAO TABELAS DO BANCO ###################################
define("DB_TABELA_CLIENTE",'cliente');
define("DB_TABELA_VEICULO",'veiculo');
define("DB_TABELA_VAGA",'vaga');
define("DB_TABELA_LOCACAO",'locacao');
define("DB_TABELA_TAXA",'taxa');


//AUTO_LOAD DE CLASSES ###################################
function my_autoload($class) {
    $diretorio = ['conn', 'helper', 'models'];
    $flagDir = false;
    
    foreach ($diretorio as $dirName) {        
        // Use barras normais para melhor compatibilidade
        $arquivo = __DIR__ . "/{$dirName}/{$class}.class.php";
        
        if (!$flagDir && file_exists($arquivo) && !is_dir($arquivo)) {
            require_once($arquivo);
            $flagDir = true;
            error_log("Arquivo carregado: $arquivo");
        } else {
            error_log("Arquivo não encontrado: $arquivo");
        }
    }
    
    if (!$flagDir) {
        trigger_error("Não foi possível incluir o arquivo {$class}.class.php", E_USER_ERROR);
        die;
    }
}

spl_autoload_register("my_autoload");

//TRATAMENTO DE ERROR ####################################
//constantes de css -> mensagens de erro
define('MS_SUCCESS','alert-success');
define('MS_INFO','alert-info');
define('MS_ALERT','alert-warning');
define('MS_ERROR','alert-danger');

function frontErro($erroMensagem, $erro, $erroDie = null) {
    $class = ($erro == E_USER_NOTICE ? MS_INFO : ($erro == E_USER_WARNING ? MS_ALERT : ($erro == E_USER_ERROR ? MS_ERROR : $erro)));
    echo "<div class='alert {$class} alert-dismissible' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
    . "<span aria-hidden='true'>&times;</span></button>";
    echo "{$erroMensagem}";
    echo "</div>";
    
    if($erroDie){
        die;
    }
}

function backErro($erro, $erroMensagem, $erroFile, $erroLine) {
    $class = ($erro == E_USER_NOTICE ? MS_INFO : ($erro == E_USER_WARNING ? MS_ALERT : ($erro == E_USER_ERROR ? MS_ERROR : $erro)));
    echo "<p class='alert {$class}'><b>Erro na linha:{$erroLine}</b> ::{$erroMensagem}<br>";
    echo "<small>arquivo:{$erroFile}</small></p>";
    
    if($erro == E_USER_ERROR){
        die;
    }
}
//Define qual a função o php deve chamar quando ocorrer um erro de sistema
set_error_handler("backErro");