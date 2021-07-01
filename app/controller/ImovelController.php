<?php


namespace Controller;

use Model\Endereco;
use Model\Imovel;
use Src\Controller;

class ImovelController extends Controller{

    private $join = 'proprietarios ON proprietarios.proprietario_id = imoveis.proprietario_id '.
    'JOIN enderecos on enderecos.endereco_id = imoveis.endereco_id';

    public function index(){
        return view('imoveis/index.php');
    }

    public function list(){
        $imoveis = Imovel::all('',$this->join);
        return response($imoveis)->send();
    }

    public function details($id){
        $imovel = Imovel::find($id, $this->join);
        if($imovel){
            return response($imovel->toArray())->send();
        }

        return response(["msg"=>"Imóvel não encontrado"], 404)->send();
    }

    public function save(){
        $dados = $this->request->all();
        if(count($dados)){
            $endereco = new Endereco();
            $endereco->cep = $dados["cep"];
            $endereco->logradouro = $dados["logradouro"];
            $endereco->numero = $dados["numero"];
            $endereco->complemento = $dados["complemento"];
            $endereco->bairro = $dados["bairro"];
            $endereco->cidade = $dados["cidade"];
            $endereco->uf = $dados["uf"];
            $id = $endereco->save();

            $imovel = new Imovel();
            $imovel->endereco_id = $id;
            $imovel->proprietario_id = $dados["proprietario_id"];
            $id = $imovel->save();

            $imovel = Imovel::find($id, $this->join);

            return response($imovel->toArray())->send();

        }


        return response('',500)->send();
    }

    public function update(){
        $dados = $this->request->all();

        $imovel = Imovel::find($dados["imovel_id"], $this->join);

        if($imovel){
            $endereco = Endereco::find($imovel->endereco_id);
            $endereco->cep = $dados["cep"];
            $endereco->logradouro = $dados["logradouro"];
            $endereco->numero = $dados["numero"];
            $endereco->complemento = $dados["complemento"];
            $endereco->bairro = $dados["bairro"];
            $endereco->cidade = $dados["cidade"];
            $endereco->uf = $dados["uf"];
            $endereco->save();

            $imovel = Imovel::find($dados["imovel_id"], $this->join);

            return response($imovel->toArray())->send();
        }

        return response(["msg"=>"Imóvel não encontrado"], 404)->send();

    }

    public function delete($id){
        $imovel = Imovel::find($id, $this->join);

        if($imovel){
            $endereco = Endereco::find($imovel->endereco_id);
            $imovel->delete();
            $endereco->delete();

            return response(['msg'=>'Imóvel excluido com sucesso'])->send();
        }

        return response(["msg"=>"Imóvel não encontrado"], 404)->send();
    }
}