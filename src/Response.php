<?php


namespace Src;


class Response{
    protected $status;
    protected $data;

    protected $headers = array(
        'Cache-Control: no-cache',
        'Pragma: no-cache',
        'Content-Type: application/json',
    );

    function __construct($data, $status = 200, $content = false){
        $this->data = $data;
        $this->status = $status;
        if($content)
            $this->header($content);
    }

    protected function header($content){
        $this->headers[] = $content;
    }

    function send(){

        $response = new \stdClass;
        $response->status = $this->status;
        if(isset($this->data)){
            $response->data = $this->data;
        };

        foreach($this->headers as $header){
            header($header,true);
        };

        http_response_code($this->status);


        echo json_encode($response);
        die();
    }

}