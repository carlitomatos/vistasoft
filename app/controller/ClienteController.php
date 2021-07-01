<?php

namespace Controller;

use Model\Cliente;
use Model\Contrato;
use Model\Pessoa;
use Src\Controller;

class ClienteController extends Controller {

    private  $join = 'pessoas ON pessoas.pessoa_id = clientes.pessoa_id';

    public function index(){
        return view('clientes/index.php');
    }


    public function list(){
        $dados = $this->request->all();


        if(isset($dados["draw"])){
            $clientes = Cliente::all('',$this->join, $dados["length"], $dados["start"]);
            $count = Cliente::count();
            $return = [
                "draw" => $dados["draw"],
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $clientes,
                "dados"=> $dados,
            ];

            return  response($return)->send();
        }

        $clientes = Cliente::all('',$this->join, 50);

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
            $pessoa->pessoa_id = $cliente->pessoa_id;
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
        $contratos = Contrato::count('*','cliente_id = '. $cliente->cliente_id);

        if($contratos > 0){
            return response(['msg'=>'Não é possível excluir pois o CLiente possui contratos'],409)->send();
        }

        if($cliente){
            $pessoa = Pessoa::find($cliente->pessoa_id);
            $cliente->delete();
            $pessoa->delete();

            return response(['msg'=>'Cliente excluido com sucesso'])->send();
        }

        return response(["msg"=>"Cliente não encontrado"], 404)->send();
    }
}