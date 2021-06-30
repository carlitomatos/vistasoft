<?php


namespace Controller;

use Model\Pessoa;
use Model\Proprietario;
use Src\Controller;

class ProprietarioController extends Controller{

    private $join = 'pessoas ON pessoas.pessoa_id = proprietarios.pessoa_id';
    public function list(){
        $proprietarios = Proprietario::all('',$this->join );
        return response($proprietarios)->send();
    }

    public function details($id){
        $proprietario = Proprietario::find($id, $this->join);
        if($proprietario){
            return response($proprietario->toArray())->send();
        }

        return response(["msg"=>"Proprietario não encontrado"], 404)->send();
    }

    public function save(){
        $dados = $this->request->all();
        if(count($dados)){
            $pessoa = new Pessoa();
            $pessoa->nome = $dados["nome"];
            $pessoa->email = $dados["email"];
            $pessoa->telefone = $dados["telefone"];
            $id = $pessoa->save();

            $proprietario = new Proprietario();
            $proprietario->pessoa_id = $id;
            $proprietario->dia_repasse = $dados["dia_repasse"];
            $id = $proprietario->save();

            $proprietario = Proprietario::find($id, $this->join);

            return response($proprietario->toArray())->send();

        }


        return response('',500)->send();
    }

    public function update(){
        $dados = $this->request->all();

        $proprietario = Proprietario::find( $dados["proprietario_id"], $this->join);

        if($proprietario){
            $pessoa = new Pessoa();
            $pessoa->pessoa_id = $proprietario->pessoa_id;
            $pessoa->nome = $dados["nome"];
            $pessoa->email = $dados["email"];
            $pessoa->telefone = $dados["telefone"];
            $pessoa->save();

            $proprietario = Proprietario::find($dados["proprietario_id"], $this->join);
            $proprietario->dia_repasse = $dados["dia_repasse"];
            $proprietario->save();
            
            return response($proprietario->toArray())->send();
        }

        return response(["msg"=>"Proprietario não encontrado"], 404)->send();

    }

    public function delete($id){
        $proprietario = Proprietario::find($id, $this->join);

        if($proprietario){
            $pessoa = Pessoa::find($proprietario->pessoa_id);
            $proprietario->delete();
            $pessoa->delete();

            return response(['msg'=>'Proprietario excluido com sucesso'])->send();
        }

        return response(["msg"=>"Proprietario não encontrado"], 404)->send();
    }
}