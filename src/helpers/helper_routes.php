<?php

use Src\Route;
use Src\Request;
use Src\Response;
use Src\View;

function request(){
    return new Request();
}

function response($data, $status = 200, $content = false){
    return new Response($data, $status, $content);
}

function view($file = null, $params = []){
    return new View($file, $params);
}


function resolve($request = null){
    if(is_null($request)){
        $request = request();
    }
    return Route::resolve($request);
}


function route($name, $params = null){
    return Route::translate($name, $params);
}

function redirect($pattern){
    return resolve($pattern);
}

function back(){
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
}