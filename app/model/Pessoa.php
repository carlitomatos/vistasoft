<?php


namespace Model;

use Src\Model;

class Pessoa extends Model{
    protected $table = 'pessoas';
    protected $idField = 'pessoa_id';
    protected $logTimestamp = false;
}