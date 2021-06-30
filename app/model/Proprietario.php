<?php


namespace Model;

use Src\Model;

class Proprietario extends Model{
    protected $table = 'proprietarios';
    protected $idField = 'proprietario_id';
    protected $logTimestamp = false;

}