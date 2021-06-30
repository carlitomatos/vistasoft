<?php


namespace Model;

use \Src\Model;

class Cliente extends Model{
    protected $table = 'clientes';
    protected $idField = 'cliente_id';
    protected $logTimestamp = false;

}