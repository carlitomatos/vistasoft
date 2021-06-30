<?php


namespace Src;

use Exception;

class View{
    private $file;
    private $params;
    private $contents;

    private $viewsFolder;

    public function __construct($file = null, $params = []){
        $this->viewsFolder = dirname(__FILE__, 2). DIRECTORY_SEPARATOR . 'app'
            . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
        $this->setView($this->viewsFolder.$file);

        $this->params = $params;
        $this->showContents();
    }

    private function setView($file){
        if(file_exists($file))
            $this->file = $file;
        else
            throw new Exception("Arquivo View '$file' não existe");
    }

    private function getContents(){
        ob_start();
        if(isset($this->file))
            require_once $this->file;
        $this->contents = ob_get_contents();
        ob_end_clean();
        return $this->contents;
    }

    private function showContents(){
        echo $this->getContents();
        die();
    }

    public function getParams(){
        return $this->params;
    }

    public function setParams(array $params){
        $this->params = $params;
    }

    public function getView(){
        return $this->file;
    }

}