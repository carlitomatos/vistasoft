<?php

namespace Src;

class Request{
    protected $files;
    protected $base;
    protected $uri;
    protected $method;
    protected $protocol;
    protected $server;
    protected $data = [];

    public function __construct(){
        $this->base = $_SERVER['REQUEST_URI'];
        $this->uri = $_REQUEST['uri'] ?? '/';
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        $this->server = $_SERVER['SERVER_NAME'];
        $this->setData();

        if(count($_FILES) > 0 ){
            $this->setFiles();
        }
    }

    protected function setData(){
        switch($this->method){
            case 'get':
                $this->data = $_GET;
                break;
            case 'post':
            case 'head':
            case 'put':
            case 'delete':
            case 'options':
                $this->data = json_decode(file_get_contents('php://input'),true);
                #parse_str(file_get_contents('php://input'), $this->data);
        }
    }

    protected function setFiles(){
        foreach ($_FILES as $key => $value) {
            $this->files[$key] = $value;
        }
    }

    public function getBase(){
        return $this->base;
    }
    public function uri(){
        return $this->uri;
    }

    public function method(){
        return $this->method;
    }

    public function getBaseUrl(){
        return $this->protocol . '://'.($this->server == 'localhost' ? $this->server . '/'
                . explode('/',$this->base)[1] . '/' : $this->server);
    }

    public function all(){
        return $this->data;
    }

    public function __isset($key){
        return isset($this->data[$key]);
    }

    public function __get($key){
        if(isset($this->data[$key])){
            return $this->data[$key];
        }
        return false;
    }

    public function hasFile($key){
        return isset($this->files[$key]);
    }

    public function file($key){
        if(isset($this->files[$key])){
            return $this->files[$key];
        }
        return false;
    }
}