<?php
/**
 * View.class [ HELPER MVC]
 * Responsável por carregar o template, povoar e exibir a view e incluir arquivos PHP no sistema
 * @copyright (c) 2016, Jaison Jose da Rosa
 * @author jaison
 * Arquitetura MVC
 */
class View {
    
    private $data; // recebe os dados
    private $keys; // armazenar os links
    private $values; // valores a serem substituidos
    private $template; // onde será carregado no nosso template html
    
    //responsavel por carregar o template HTML. só é validos os arquivos tpl.html
    public function load($template){
        $this->template = (string) $template; //recebe a string
        $this->template = file_get_contents($this->template . '.tpl.html'); // carregamos o html contido no caminho da string.
        //var_dump($this->template); //debug
    }
    
    public function show(array $data){
        $this->setKeys($data);
        $this->setValues($data);
        return $this->showView();
    }
    
    public function request($file, array $data){
        extract($data);
        require("{$file}.inc.php");
    }
    
        //PRIVATES
    
    private function setKeys($data){
        $this->data = $data;
        $this->keys = explode('&', '#' . implode("#&#", array_keys($this->data)) . '#');
        //var_dump($this->keys);
    }
    
    private function setValues($data){
        $this->values = array_values($this->data);
    }
    
    private function showView(){
        //echo str_replace($this->keys, $this->values, $this->template);
        return str_replace($this->keys, $this->values, $this->template);
    }
}
