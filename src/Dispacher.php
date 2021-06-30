<?php

namespace Src;

class Dispacher{

    public function dispach($callback, $params = [], $namespace = "Controller\\"){
        if(is_callable($callback['callback'])){
            return call_user_func($callback['callback'], array_values($params));
        }elseif(is_string($callback['callback'])){
            if(!!strpos($callback['callback'],'@') !== false){
                if(!empty($callback['namespace']))
                  $namespace = $callback['namespace'];

                $callback['callback'] = explode('@',$callback['callback']);
                $controller = $namespace.$callback['callback'][0];

                $method = $callback['callback'][1];

                $rc = new \ReflectionClass($controller);
                if($rc->isInstantiable() && $rc->hasMethod($method)){
                    return  call_user_func_array(array(new $controller, $method), array_values($params));
                }else{
                    throw new \Exception("Controller não pode ser instanciado ou método não existe");
                }
            }
        }
        throw new \Exception("Método não implementado");
    }
}