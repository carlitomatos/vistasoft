<?php


namespace Controller;

use Model\Contrato;
use Model\Pessoa;
use Model\Proprietario;
use Model\Repasse;
use Src\Controller;

class ProprietarioController extends Controller{

    private $join = 'pessoas ON pessoas.pessoa_id = proprietarios.pessoa_id';

    public function index(){
        return view('proprietarios/index.php');
    }

    public function list(){
        $dados = $this->request->all();


        if(isset($dados["draw"])){
            $clientes = Proprietario::all('',$this->join, $dados["length"], $dados["start"]);
            $count = Proprietario::count();
            $return = [
                "draw" => $dados["draw"],
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $clientes,
                "dados"=> $dados,
            ];

            return  response($return)->send();
        }
        $proprietarios = Proprietario::all('',$this->join );
        return response($proprietarios)->send();
    }

    public function details($id){
        $proprietario = Proprietario::find($id, $this->join);
        if($proprietario){
            $contratos = Contrato::all('proprietario_id = '. $proprietario->proprietario_id );
            foreach ($contratos as $contrato){
                $repasses = Repasse::all('contrato_id = '. $contrato["contrato_id"]);
                $contrato["repasses"] = $repasses;
            }
            $proprietario = $proprietario->toArray();
            $proprietario["contratos"] = $contratos;

            return response($proprietario)->send();
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