<?php

namespace Controller;

use Model\Cliente;
use Model\Pessoa;
use Src\Controller;

class ClienteController extends Controller {

    private  $join = 'pessoas ON pessoas.pessoa_id = clientes.pessoa_id';

    public function list(){
        $clientes = Cliente::all('',$this->join());
        return response($clientes)->send();
    }

    public function details($id){
        $cliente = Cliente::find($id, $this->join);
        if($cliente){
            return response($cliente->toArray())->send();
        }

        return response(["msg"=>"Cliente não encontrado"], 404)->send();
    }

    public function save(){
        $dados = $this->request->all();
        if(count($dados)){
            $pessoa = new Pessoa();
            $pessoa->nome = $dados["nome"];
            $pessoa->email = $dados["email"];
            $pessoa->telefone = $dados["telefone"];
            $id = $pessoa->save();

            $cliente = new Cliente();
            $cliente->pessoa_id = $id;
            $id = $cliente->save();

            $cliente = Cliente::find($id, $this->join);

            return response($cliente->toArray())->send();

        }


        return response('',500)->send();
    }

    public function update(){
        $dados = $this->request->all();

        $cliente = Cliente::find($dados["cliente_id"], $this->join);

        if($cliente){
            $pessoa = new Pessoa();
            $pessoa->pessoa_id = $cliente[0]['pessoa_id'];
            $pessoa->nome = $dados["nome"];
            $pessoa->email = $dados["email"];
            $pessoa->telefone = $dados["telefone"];
            $pessoa->save();

            $cliente = Cliente::find($dados["cliente_id"], $this->join);

            return response($cliente->toArray())->send();
        }

        return response(["msg"=>"Cliente não encontrado"], 404)->send();

    }

    public function delete($id){
        $cliente = Cliente::find($id, $this->join);

        if($cliente){
            $pessoa = Pessoa::find($cliente->pessoa_id);
            $cliente->delete();
            $pessoa->delete();

            return response(['msg'=>'Cliente excluido com sucesso'])->send();
        }

        return response(["msg"=>"Cliente não encontrado"], 404)->send();
    }
}