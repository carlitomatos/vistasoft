<?php

namespace Src;

use Exception;
use PDO;

final class Connection{

    private static $connection;

    private function __construct(){}

    private function __clone(){}

    private function __wakeup(){}

    private static function load(string $file): array{
        $file = dirname(__FILE__, 2).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$file;
        if (file_exists($file)) {
            $dados = parse_ini_file($file);
        } else {
            throw new Exception('Erro: Arquivo não encontrado');
        }
        return $dados;
    }

    private static function make(array $dados): PDO{
        $sgdb = isset($dados['sgdb']) ? $dados['sgdb'] : NULL;
        $usuario = isset($dados['usuario']) ? $dados['usuario'] : NULL;
        $senha = isset($dados['senha']) ? $dados['senha'] : NULL;
        $banco = isset($dados['banco']) ? $dados['banco'] : NULL;
        $servidor = isset($dados['servidor']) ? $dados['servidor'] : NULL;
        $porta = isset($dados['porta']) ? $dados['porta'] : NULL;

        if(!is_null($sgdb) && !is_null($usuario) && !is_null($senha) && !is_null($banco) && !is_null($servidor)){
            switch (strtoupper($sgdb)){
                case 'MYSQL' : $porta = isset($porta) ? $porta : 3306;
                    return new PDO("mysql:host={$servidor};port={$porta};dbname={$banco}", $usuario, $senha);
                    break;
                case 'MSSQL' : $porta = isset($porta) ? $porta : 1433;
                    return new PDO("mssql:host={$servidor},{$porta};dbname={$banco}", $usuario, $senha);
                    break;
                case 'PGSQL' : $porta = isset($porta) ? $porta : 5432;
                    return new PDO("pgsql:dbname={$banco}; user={$usuario}; password={$senha}, host={$servidor};port={$porta}");
                    break;
                case 'SQLITE' : return new PDO("sqlite:{$banco}");
                    break;
                case 'OCI8' : return new PDO("oci:dbname={$banco}", $usuario, $senha);
                    break;
                case 'FIREBIRD' : return new PDO("firebird:dbname={$banco}", $usuario, $senha);
                    break;
            }
        }else{
            throw new Exception('Erro: tipo de banco de dados não informado, ou faltam informações no arquivo de configuração');
        }
    }

    public static function getInstance(string $file): PDO{
        if(self::$connection == NULL){
            self::$connection = self::make(self::load($file));
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection->exec("set names utf8");
        }
        return self::$connection;
    }
}