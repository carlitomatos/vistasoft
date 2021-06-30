<?php


namespace App\controller;

use Model\Repasse;
use Src\Controller;

class RepasseController extends Controller{

    public function list($contratoId){
        $mensalidades = Repasse::all('contrato_id = ' . $contratoId);
        return response($mensalidades)->send();
    }

    public function update(){
        $dados = $this->request->all();
        $mensalidade = Repasse::find($dados["repasse_id"]);
        $mensalidade->paga = $dados["realizado"];
        $mensalidade->save();

        return response($mensalidade->toArray())->send();
    }
}