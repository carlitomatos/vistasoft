<?php

namespace Src;

class RouteCollection{
    protected $routesPost = [];
    protected $routesGet = [];
    protected $routesPut = [];
    protected $routesDelete = [];
    protected $routesNames = [];

    public function add($requestType, $pattern, $callback){
        switch($requestType){
            case 'post':
                return $this->addPost($pattern, $callback);
            case 'get':
                return $this->addGet($pattern, $callback);
            case 'put':
                return $this->addPut($pattern, $callback);
            case 'delete':
                return $this->addDelete($pattern, $callback);
            default:
                throw new \Exception('Método não implementado');
        }
    }

    public function where($requestType, $pattern){

        switch($requestType){
            case 'post':
                return $this->findPost($pattern);
            case 'get':
                return $this->findGet($pattern);
            case 'put':
                return $this->findPut($pattern);
            case 'delete':
                return $this->findDelete($pattern);
            default:
                throw new \Exception('Método não implementado');
        }
    }

    protected function parseUri($uri){
         if($uri == '/'){
            return $uri;
        }

        return implode('/', array_filter(explode('/', $uri)));
    }

    protected function findPost($patternSent){
        $patternSent = $this->parseUri($patternSent);

        foreach ($this->routesPost as $pattern => $callback){
            if(preg_match($pattern, $patternSent, $pieces)){
                return (object) ['callback' => $callback, 'uri' => $pieces];
            }
        }

        return false;
    }

    protected function findGet($patternSent){
        $patternSent = $this->parseUri($patternSent);
        foreach ($this->routesGet as $pattern => $callback){
            if(preg_match($pattern, $patternSent, $pieces)){
                return (object) ['callback' => $callback, 'uri' => $pieces];
            }
        }

        return false;
    }

    protected function findPut($patternSent){
        $patternSent = $this->parseUri($patternSent);

        foreach ($this->routesPut as $pattern => $callback){
            if(preg_match($pattern, $patternSent, $pieces)){
                return (object) ['callback' => $callback, 'uri' => $pieces];
            }
        }

        return false;
    }

    protected function findDelete($patternSent){
        $patternSent = $this->parseUri($patternSent);

        foreach ($this->routesDelete as $pattern => $callback){
            if(preg_match($pattern, $patternSent, $pieces)){
                return (object) ['callback' => $callback, 'uri' => $pieces];
            }
        }

        return false;
    }

    protected function definePattern($pattern){

        if($pattern != '/')
            $pattern = implode('/', array_filter(explode('/', $pattern)));

        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';

        if (preg_match("/\{[A-Za-z0-9\_\-]{1,}\}/", $pattern)) {
            $pattern = preg_replace("/\{[A-Za-z0-9\_\-]{1,}\}/", "[A-Za-z0-9]{1,}", $pattern);
        }

        return $pattern;
    }

    protected function parsePattern(array $pattern){
        $result['set'] = $pattern['set'] ?? null;
        $result['as'] = $pattern['as'] ?? null;
        $result['namespace'] = $pattern['namespace'] ?? null;

        return $result;

    }

    protected function addPost($pattern, $callback){
        if(is_array($pattern)){
            $settings = $this->parsePattern($pattern);
            $pattern = $settings['set'];
        }else{
            $settings = [];
        }
        $values = $this->toMap($pattern);
        $this->routesPost[$this->definePattern($pattern)] = [
            'callback' => $callback,
            'values' => $values,
            'namespace' => $settings['namespace'] ?? null
        ];

        if(isset($settings['as'])){
            $this->routesNames[$settings['as']] = $pattern;
        }

        return $this;
    }

    protected function addGet($pattern, $callback){
        if(is_array($pattern)){
            $settings = $this->parsePattern($pattern);
            $pattern = $settings['set'];
        }else{
            $settings = [];
        }
        $values = $this->toMap($pattern);
        $this->routesGet[$this->definePattern($pattern)] = [
            'callback' => $callback,
            'values' => $values,
            'namespace' => $settings['namespace'] ?? null
        ];


        if(isset($settings['as'])){
            $this->routesNames[$settings['as']] = $pattern;
        }

        return $this;
    }

    protected function addPut($pattern, $callback){
        if(is_array($pattern)){
            $settings = $this->parsePattern($pattern);
            $pattern = $settings['set'];
        }else{
            $settings = [];
        }
        $values = $this->toMap($pattern);
        $this->routesPut[$this->definePattern($pattern)] = [
            'callback' => $callback,
            'values' => $values,
            'namespace' => $settings['namespace'] ?? null
        ];

        if(isset($settings['as'])){
            $this->routesNames[$settings['as']] = $pattern;
        }

        return $this;
    }

    protected function addDelete($pattern, $callback){
        if(is_array($pattern)){
            $settings = $this->parsePattern($pattern);
            $pattern = $settings['set'];
        }else{
            $settings = [];
        }
        $values = $this->toMap($pattern);
        $this->routesDelete[$this->definePattern($pattern)] = [
            'callback' => $callback,
            'values' => $values,
            'namespace' => $settings['namespace'] ?? null
        ];

        if(isset($settings['as'])){
            $this->routesNames[$settings['as']] = $pattern;
        }

        return $this;
    }

    protected function strposarray(string $haystack, array $needles, int $offset = 0){
        $result = false;

        if(strlen($haystack) > 0 && count($needles) > 0){
            foreach($needles as $element){
                $result = strpos($haystack,$element,$offset);
                if($result !== false){
                    break;
                }
            }
        }
        return $result;
    }

    protected function toMap($pattern){
        $result = [];
        $needles = ['{', '[', '(', '\\'];
        $pattern = array_filter(explode('/',$pattern));

        foreach($pattern as $key => $element){
            $found = $this->strposarray($element,$needles);
            if($found !== false){
                if(substr($element, 0, 1) == '{'){
                    $result[preg_filter('/([\{\}])/', '', $element)] = $key - 1;
                }else{
                    $index = 'value_' . !empty($result) ? count($result) + 1 : 1;
                    array_merge($result, [$index => $key - 1]);
                }
            }
        }

        return count($result) > 0 ? $result : false;
    }

    public function isThereAnyHow($name){
        return $this->routesNames[$name] ?? false;
    }

    public function convert($pattern, $params)
    {
        if(!is_array($params)) {
            $params = array($params);
        }

        $positions = $this->toMap($pattern);
        if($positions === false) {
            $positions = [];
        }
        $pattern = array_filter(explode('/', $pattern));

        if(count($positions) < count($pattern)) {
            $uri = [];
            foreach($pattern as $key => $element)
            {
                if(in_array($key - 1, $positions))
                {
                    $uri[] = array_shift($params);
                } else {
                    $uri[] = $element;
                }
            }
            return implode('/', array_filter($uri));

        }
        return false;
    }


}