<?php


namespace Model;

use Src\Model;

class Mensalidade extends Model{
    protected $table = 'mensalidades';
    protected $idField = 'mensalidade_id';
    protected $logTimestamp = false;
}