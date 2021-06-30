<?php


namespace Model;

use Src\Model;

class Contrato extends Model{
    protected $table = 'contratos';
    protected $idField = 'contrato_id';
    protected $logTimestamp = false;
}