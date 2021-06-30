<?php


namespace App\controller;

use Model\Mensalidade;
use Src\Controller;

class MensalidadeController extends  Controller{

    public function list($contratoId){
        $mensalidades = Mensalidade::all('contrato_id = ' . $contratoId);

        return response($mensalidades)->send();
    }

    public function update(){
        $dados = $this->request->all();
        $mensalidade = Mensalidade::find($dados["mensalidade_id"]);
        $mensalidade->paga = $dados["paga"];
        $mensalidade->save();

        return response($mensalidade->toArray())->send();
    }
}