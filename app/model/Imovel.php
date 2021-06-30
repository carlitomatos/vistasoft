<?php


namespace Model;

use Src\Model;

class Imovel extends Model{
    protected $table = 'imoveis';
    protected $idField = 'imovel_id';
    protected $logTimestamp = false;
}