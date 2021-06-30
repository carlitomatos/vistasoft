<?php


namespace Model;

use Src\Model;

class Repasse extends Model{
    protected $table = 'repasses';
    protected $idField = 'repasse_id';
    protected $logTimestamp = false;
}