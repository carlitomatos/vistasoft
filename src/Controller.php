<?php


namespace Src;

class Controller{
    public $request;

    public function __construct(){
        $this->request = new Request();
    }
}