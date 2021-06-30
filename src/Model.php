<?php

namespace Src;

use PDO;
use Exception;

abstract class Model
{

    private static $connection;
    private $content;
    protected $table = NULL;
    protected $idField = NULL;
    protected $logTimestamp;

    public function __construct()
    {
        if(!self::$connection){
            self::setConnection(Connection::getInstance('db.ini'));
        }

        if(!is_bool($this->logTimestamp)){
            $this->logTimestamp = TRUE;
        }

        if($this->table == NULL){
            $this->table = strtolower(get_class($this));
        }
        if($this->idField == NULL){
            $this->idField = 'id';
        }
    }

    public function __set($parameter, $value)
    {
        $this->content[$parameter] = $value;
    }

    public function __get($parameter)
    {
        return $this->content[$parameter];
    }

    public function __isset($parameter)
    {
        return isset($this->content[$parameter]);
    }

    public function __unset($parameter)
    {
        if (isset($parameter)) {
            unset($this->content[$parameter]);
            return true;
        }
        return false;
    }

    private function __clone()
    {
        if (isset($this->content[$this->idField])) {
            unset($this->content[$this->idField]);
        }
    }

    public function toArray()
    {
        return $this->content;
    }

    public function fromArray(array $array)
    {
        $this->content = $array;
    }

    public function toJson()
    {
        return json_encode($this->content);
    }

    public function fromJson(string $json)
    {
        $this->content = json_decode($json);
    }

    private function format($value)
    {
        if (is_string($value) && !empty($value)) {
            return "'" . addslashes($value) . "'";
        } else if (is_bool($value)) {
            return $value ? 'TRUE' : 'FALSE';
        } else if ($value !== '') {
            return $value;
        } else {
            return "NULL";
        }
    }

    private function convertContent()
    {
        $newContent = array();
        foreach ($this->content as $key => $value) {
            if (is_scalar($value)) {
                $newContent[$key] = $this->format($value);
            }
        }
        return $newContent;
    }

    public function save(){
        $newContent = $this->convertContent();

        if(isset($this->content[$this->idField])){
            $sets = array();

            foreach($newContent as $key => $value){
                if($key === $this->idField || $key == 'created_at' || $key == 'updated_at')
                    continue;
                $sets[] = "{$key} = {$value}";
            }

            if($this->logTimestamp === TRUE){

                $sets[] = "updated_at = '" . date('Y-m-d H:i:s') . "'";
            }
            $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE {$this->idField} = {$this->content[$this->idField]};";
        }else{
            if($this->logTimestamp === TRUE){
                $newContent['created_at'] = "'" . date('Y-m-d H:i:s') . "'";
                $newContent['updated_at'] = "'" . date('Y-m-d H:i:s') . "'";
            }
            $sql = "INSERT INTO {$this->table} (" . implode(', ', array_keys($newContent)) . ') VALUES (' . implode(',', array_values($newContent)) . ');';
        }

        if (self::$connection) {
            self::$connection->exec($sql);

            #dd(self::$connection->query('SELECT LAST_INSERT_ID()')->fetchColumn());
            return $this->content[$this->idField] ?? self::$connection->lastInsertId();;
        }else{
            throw new Exception("Não há conexão com Banco de dados!");
        }
    }

    public static function find($parameter, string $join = '')
    {
        $class = get_called_class();
        $idField = (new $class())->idField;
        $idField = is_null($idField) ? 'id' : $idField;
        $table = (new $class())->table;
        $table =(is_null($table) ? strtolower($class) : $table);

        $sql = 'SELECT * FROM ' . $table;
        $sql .= ($join !== '') ? " JOIN {$join}" : "";
        $sql .= ' WHERE ' . (($join !== '') ? $table.'.'.$idField : $idField);
        $sql .= " = {$parameter} ;";


        if (self::$connection) {
            $result = self::$connection->query($sql);

            if ($result) {
                $newObject = $result->fetchObject(get_called_class());
            }

            return $newObject;
        } else {
            throw new Exception("Não há conexão com Banco de dados!");
        }
    }

    public function delete()
    {
        if (isset($this->content[$this->idField])) {

            $sql = "DELETE FROM {$this->table} WHERE {$this->idField} = {$this->content[$this->idField]};";

            if (self::$connection) {
                return self::$connection->exec($sql);
            } else {
                throw new Exception("Não há conexão com Banco de dados!");
            }
        }
    }

    public static function all(string $filter = '', string $join = '' ,int $limit = 0, int $offset = 0){
        $class = get_called_class();
        $table = (new $class())->table;
        $sql = 'SELECT * FROM ' . (is_null($table) ? strtolower($class) : $table);
        $sql .= ($join !== '') ? " JOIN {$join}" : "";
        $sql .= ($filter !== '') ? " WHERE {$filter}" : "";
        $sql .= ($limit > 0) ? " LIMIT {$limit}" : "";
        $sql .= ($offset > 0) ? " OFFSET {$offset}" : "";
        $sql .= ';';

        if (self::$connection){
            $result = self::$connection->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
            #return $result->fetchAll(PDO::FETCH_CLASS, get_called_class());
        }else{
            throw new Exception("Não há conexão com Banco de dados!");
        }
    }

    public static function findFisrt(string $filter = '', string $join = ''){
        return self::all($filter, $join,1);
    }

    public static function count(string $fieldName = '*', string $filter = '', string $join = ''){
        $class = get_called_class();
        $table = (new $class())->table;
        $sql = "SELECT count($fieldName) as t FROM " . (is_null($table) ? strtolower($class) : $table);
        $sql .= ($join !== '') ? " JOIN {$join}" : "";
        $sql .= ($filter !== '') ? " WHERE {$filter}" : "";
        $sql .= ';';
        if (self::$connection) {
            $q = self::$connection->prepare($sql);
            $q->execute();
            $a = $q->fetch(PDO::FETCH_ASSOC);
            return (int) $a['t'];
        } else {
            throw new Exception("Não há conexão com Banco de dados!");
        }
    }

    public static function setConnection(PDO $connection){
        self::$connection = $connection;
    }
}