<?php


namespace Model;

use Src\Model;

class Endereco extends Model{
    protected $table = 'enderecos';
    protected $idField = 'endereco_id';
    protected $logTimestamp = false;
}