<?php

function dd($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function url($uri){
    return request()->getBaseUrl().$uri;
}