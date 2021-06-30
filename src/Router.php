<?php

namespace Src;

class Router{
    protected $routeCollection;
    protected $dispacher;

    public function __construct(){
        $this->routeCollection = new RouteCollection();
        $this->dispacher = new Dispacher();
    }

    public function get($pattern, $callback){
        $this->routeCollection->add('get', $pattern, $callback);
        return $this;
    }

    public function post($pattern, $callback){
        $this->routeCollection->add('post', $pattern, $callback);
        return $this;
    }

    public function put($pattern, $callback){
        $this->routeCollection->add('put', $pattern, $callback);
        return $this;
    }

    public function delete($pattern, $callback){
        $this->routeCollection->add('delete', $pattern, $callback);
        return $this;
    }

    public function find($requestType, $pattern){
        return $this->routeCollection->where($requestType, $pattern);
    }

    protected function dispach($route, $params, $namespace = "Controller\\"){
        return $this->dispacher->dispach($route->callback, $params, $namespace);
    }

    protected function notFound(){
        return header("HTTP/1.0 404 Not Found",true, 404);
    }

    protected function getValues($pattern, $positions){
        $result = [];

        $pattern = array_filter(explode('/', $pattern));
        foreach($pattern as $key => $value){
            if(in_array($key, $positions)){
                $result[array_search($key, $positions)] = $value;
            }
        }


        return $result;

    }

    public function resolve($request){
        $route = $this->find($request->method(), $request->uri());


        if($route){
            $params = $route->callback['values'] ? $this->getValues($request->uri(), $route->callback['values']) : [];
            return $this->dispach($route, $params);
        }

        return $this->notFound();
    }

    public function translate($name, $params){
        $pattern = $this->routeCollection->isThereAnyHow($name);

        if($pattern) {
            $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
            $server = $_SERVER['SERVER_NAME'] . '/';
            $uri = [];

            $root = explode(DIRECTORY_SEPARATOR,dirname(__FILE__, 2));
            $root = $root[count($root) - 1];

            foreach($array = array_filter(explode('/', $_SERVER['REQUEST_URI'])) as $key => $value) {
                if($value == $root){
                    $uri[] = $value;
                    break;
                }

                $uri[] = $value;
            }

            $uri = implode('/', array_filter($uri)) . '/';

            return $protocol . $server . $uri . $this->routeCollection->convert($pattern, $params);
        }
        return false;
    }
}