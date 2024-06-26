<?php

/**
 * Check.class [ HELPER ]
 * Classe responsavel por manipular e validar os dados do sistema!
 * 
 * @author jaison
 * @copyright (c) 2016, Jaison Jose da Rosa
 */
class Check {

    private static $data;
    private static $format;

    /*
     * Metodo responsável por realizar a validação de email;
     * Retorna true para válido e false para inválido
     */

    public static function email($email) {
        self::$data = (string) $email;
        self::$format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if (preg_match(self::$format, self::$data)) {
            return true;
        }
        return false;
    }

    public static function urlAmigavel($name) {

        self::nome($name);

        self::$data = str_replace(' ', '-', self::$data);
        self::$data = str_replace(array('-----', '----', '---', '--'), '-', self::$data);

        return strtolower(self::$data);
    }

    public static function retirarAcentos($name) {
        self::$format = array();
        self::$format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        self::$format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        self::$data = strtr(utf8_decode($name), utf8_decode(self::$format['a']), utf8_decode(self::$format['b']));
        self::$data = strip_tags(trim(self::$data));

        return utf8_encode(self::$data);
    }

    public static function data($data, $s1 = "/", $s2 = "-") {
        self::$format = explode(' ', $data);
        self::$data = explode($s1, self::$format[0]);

        if (empty(self::$format[1])) {
            self::$format[1] = date('H:i:s');
        }

        self::$data = self::$data[2] . $s2 . self::$data[1] . $s2 . self::$data[0] . ' ' . self::$format[1];
        //self::$data = self::$data[2] . $s2 . self::$data[1] . $s2 . self::$data[0];

        return self::$data;
    }

    /*
     * Metodo responsável por truncar os textoa;
     * @string = texto a ser truncado;
     * @limite = numero de palavras que que devem retornar;
     * @pointer = valor opcional a ser concatenado no fim da string de retorno;
     * Retorna o texto truncado.
     */

    public static function truncarWord($string, $limite, $pointer = null) {
        self::$data = strip_tags(trim($string));
        self::$format = (int) $limite;

        $arrWords = explode(' ', self::$data);
        $numWords = count($arrWords);
        $newWords = implode(' ', array_slice($arrWords, 0, self::$format));

        $pointer = (empty($pointer) ? '...' : ' ' . $pointer);
        $result = (self::$format < $numWords ? $newWords . $pointer : self::$data);

        return $result;
    }

    public static function image($url, $descricao, $width = null, $height = null) {
        self::$data = 'uploads/' . $url;

        if (file_exists(self::$data) && !is_dir(self::$data)) {
            $path = HOME;
            $image = self::$data;
            return "<img src=\"{$path}/tim.php?src={$path}/{$image}&w={$width}&h={$height}\" alt=\"{$descricao}\">";
        }

        return false;
    }

//    public static function validarCpf($cpf) {
//        self::$data = Filter::toNumeric($cpf);
//        // Verifica se um número foi informado
//        if (empty(self::$data)) {
//            return false;
//        }
//
//        // Elimina possivel mascara
//        self::$data = preg_replace('[^0-9]', '', self::$data);
//        self::$data = str_pad(self::$data, 11, '0', STR_PAD_LEFT);
//
//        // Verifica se o numero de digitos informados é igual a 11 
//        if (strlen(self::$data) != 11) {
//            return false;
//        }
//        // Verifica se nenhuma das sequências invalidas abaixo 
//        // foi digitada. Caso afirmativo, retorna falso
//        else if (self::$data == '00000000000' ||
//                self::$data == '11111111111' ||
//                self::$data == '22222222222' ||
//                self::$data == '33333333333' ||
//                self::$data == '44444444444' ||
//                self::$data == '55555555555' ||
//                self::$data == '66666666666' ||
//                self::$data == '77777777777' ||
//                self::$data == '88888888888' ||
//                self::$data == '99999999999') {
//            return false;
//            // Calcula os digitos verificadores para verificar se o
//            // CPF é válido
//        } else {
//
//            for ($t = 9; $t < 11; $t++) {
//
//                for ($d = 0, $c = 0; $c < $t; $c++) {
//                    $d += self::$data{$c} * (($t + 1) - $c);
//                }
//                $d = ((10 * $d) % 11) % 10;
//                if (self::$data{$c} != $d) {
//                    return false;
//                }
//            }
//            return true;
//        }
//    }
//
//    public static function validarCnpj($cnpj) {
//        self::$data = Filter::toNumeric($cnpj);
//        //elimina possivel mascara
//        self::$data = preg_replace('/[^0-9]/', '', (string) self::$data);
//        // Valida tamanho
//        if (strlen(self::$data) != 14) {
//            return false;
//        }
//        // Verifica se nenhuma das sequências invalidas abaixo 
//        // foi digitada. Caso afirmativo, retorna falso
//        elseif (self::$data == '00000000000' ||
//                self::$data == '11111111111' ||
//                self::$data == '22222222222' ||
//                self::$data == '33333333333' ||
//                self::$data == '44444444444' ||
//                self::$data == '55555555555' ||
//                self::$data == '66666666666' ||
//                self::$data == '77777777777' ||
//                self::$data == '88888888888' ||
//                self::$data == '99999999999') {
//            return false;
//        }
//
//        // Valida primeiro dígito verificador
//        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
//            $soma += self::$data{$i} * $j;
//            $j = ($j == 2) ? 9 : $j - 1;
//        }
//        $resto = $soma % 11;
//        if (self::$data{12} != ($resto < 2 ? 0 : 11 - $resto))
//            return false;
//        // Valida segundo dígito verificador
//        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
//            $soma += self::$data{$i} * $j;
//            $j = ($j == 2) ? 9 : $j - 1;
//        }
//        $resto = $soma % 11;
//        return self::$data{13} == ($resto < 2 ? 0 : 11 - $resto);
//    }
}
