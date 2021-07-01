<?php


namespace Controller;

use Model\Contrato;
use Model\Mensalidade;
use Model\Proprietario;
use Model\Repasse;
use Src\Controller;
use DateTime;

class ContratoController extends Controller {
    private $join = 'clientes ON clientes.cliente_id = contratos.cliente_id '
    .'JOIN proprietarios ON proprietarios.proprietario_id = contratos.proprietario_id '
    .'JOIN imoveis ON imoveis.imovel_id = contratos.imovel_id';
    private $format = 'Y-m-d';

    public function index(){
        return view('contratos/index.php');
    }

    public function list(){
        $contratos = Contrato::all('',$this->join);
        return response($contratos)->send();
    }

    public function details($id){
        $contrato = Contrato::find($id, $this->join);
        if($contrato){
            return response($contrato->toArray())->send();
        }

        return response(["msg"=>"Contrato não encontrado"], 404)->send();
    }

    public function save(){
        $dados = $this->request->all();
        $diasValorProporcional = false;
        $ultimoDiaMes = 31;
        if(count($dados)){
            $dataInicio = date_create_from_format($this->format,$dados["data_inicio"]);
            $dataFim = date_create_from_format($this->format,$dados["data_fim"]);

            $diaDataInicio = (int) $dataInicio->format('d');

            if($diaDataInicio != 1){
                $ultimoDiaMes = (int) date_create_from_format($this->format,
                    date("Y-m-t", $dataInicio->getTimestamp()))->format('d');
                $diasValorProporcional = $ultimoDiaMes - $diaDataInicio;
            }

            $contrato = new Contrato();
            $contrato->imovel_id = $dados["imovel_id"];
            $contrato->proprietario_id = $dados["proprietario_id"];
            $contrato->cliente_id = $dados["cliente_id"];
            $contrato->data_inicio = $dataInicio->format($this->format);
            $contrato->data_fim = $dataFim->format($this->format);
            $contrato->taxa_admin = $dados["taxa_admin"];
            $contrato->valor_aluguel = $dados["valor_aluguel"];
            $contrato->valor_condominio = $dados["valor_condominio"];
            $contrato->valor_iptu = $dados["valor_iptu"];
            $id = $contrato->save();

            $mensalidades = array();
            $repasses = array();

            $proprietario = Proprietario::find($contrato->proprietario_id);

            for($x = 1; $x <= 12; $x++){
                $mensalidade = new Mensalidade();
                $repasse = new Repasse();

                if($diasValorProporcional && $x==1){
                    $mensalidade->valor = $this->calcMensalidade($contrato->valor_aluguel,
                        $contrato->valor_condominio, $contrato->valor_iptu,
                        $diasValorProporcional, $ultimoDiaMes);
                    $repasse->valor = $this->calcRepasse($contrato->valor_aluguel,
                        $contrato->valor_iptu,$contrato->taxa_admin, $diasValorProporcional, $ultimoDiaMes);
                }else{
                    $mensalidade->valor = $this->calcMensalidade($contrato->valor_aluguel,
                        $contrato->valor_condominio, $contrato->valor_iptu);
                    $repasse->valor = $this->calcRepasse($contrato->valor_aluguel,
                        $contrato->valor_iptu,$contrato->taxa_admin);
                }

                $dataInicio->modify('first day of next month');

                $mensalidade->contrato_id = $id;
                $mensalidade->vencimento = $dataInicio->format($this->format);
                $idMensalidade = $mensalidade->save();
                $mensalidade->mensalidade_id = $idMensalidade;

                $mensalidades[] = $mensalidade->toArray();


                $repasse->data_repasse = $dataInicio->format('Y-m-'.$proprietario->dia_repasse);
                $idRepasse = $repasse->save();
                $repasse->repasse_id = $idRepasse;
                $repasses[] = $repasse->toArray();
            }

            $contrato = Contrato::find($id, $this->join);

            return response([
                "contrato"=>$contrato->toArray(),
                "mensalidades"=>$mensalidades,
                "repasses"=>$repasses
            ])->send();

        }


        return response('',500)->send();
    }

    private function calcMensalidade($valorAluguel, $valorCondominio, $valorIptu,$diasValorProporcional = false, $ultimoDiaMes = false){
        if($diasValorProporcional && $ultimoDiaMes)
            $valorAluguel = round($valorAluguel / $ultimoDiaMes * $diasValorProporcional);

        return $valorAluguel + $valorCondominio + $valorIptu;
    }

    private function calcRepasse($valorAluguel, $valorIptu, $taxaAdmin, $diasValorProporcional = false, $ultimoDiaMes = false){
        if($diasValorProporcional && $ultimoDiaMes)
            $valorAluguel = round($valorAluguel / $ultimoDiaMes * $diasValorProporcional);

        return ($valorAluguel + $valorIptu) -  ($valorAluguel + $valorIptu) * $taxaAdmin / 100;
    }


    public function update(){
        $dados = $this->request->all();

        $contrato = Contrato::find($dados["contrato_id"], $this->join);

        if($contrato){
            $contrato = new Contrato();
            $contrato->contrato_id = $dados["contrato_id"];
            $contrato->imovel_id = $dados["imovel_id"];
            $contrato->proprietario_id = $dados["proprietario_id"];
            $contrato->cliente_id = $dados["cliente_id"];
            $contrato->data_inicio = $dados["data_inicio"];
            $contrato->data_fim = $dados["data_fim"];
            $contrato->taxa_admin = $dados["taxa_admin"];
            $contrato->valor_aluguel = $dados["valor_aluguel"];
            $contrato->valor_condominio = $dados["valor_condominio"];
            $contrato->valor_iptu = $dados["valor_iptu"];

            $contrato = Contrato::find($dados["contrato_id"], $this->join);

            return response($contrato->toArray())->send();
        }

        return response(["msg"=>"Contrato não encontrado"], 404)->send();

    }

    public function delete($id){
        $contrato = Contrato::find($id);

        if($contrato){
            $contrato->delete();

            return response(['msg'=>'Contrato excluido com sucesso'])->send();
        }

        return response(["msg"=>"Contrato não encontrado"], 404)->send();
    }
}