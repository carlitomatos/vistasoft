<?php
$params = $this->getParams();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>VistaSoft</title>

    <?php include_once dirname(__FILE__, 2) .'/layout/css.php'?>

</head>

<body>
<div class="app" id="imoveis">
    <div class="layout">
        <?php include_once dirname(__FILE__, 2) .'/layout/header.php'?>
        <?php include_once dirname(__FILE__, 2).'/layout/side.php'?>



        <!-- Page Container START -->
        <div class="page-container">

            <!-- Content Wrapper START -->
            <div class="main-content">
                <div class="page-header">
                    <h2 class="header-title">Imóveis</h2>
                    <div class="header-sub-title">
                        <nav class="breadcrumb breadcrumb-dash">
                            <a href="<?php echo route('index')?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Início</a>
                            <span class="breadcrumb-item active">Imóveis</span>
                        </nav>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary m-r-5"  v-on:click="novo">Novo Imóvel</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Imóveis Cadastrados</h4>
                    </div>
                    <div class="card-body">
                        <table id="tblImoveis" class="table">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Proprietário</th>
                                <th>Cidade</th>
                                <th>UF</th>
                                <th>Acoes</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Content Wrapper END -->

        </div>
        <!-- Page Container END -->
    </div>
    <div class="modal fade cadastro-imovel">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">Novo imovel</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form ref="salvarFormImovel" v-on:submit="salvar" action="<?php echo route('api.imovel.save')?>">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Proprietário</label>
                                <input v-on:click="getProprietarios" readonly type="text" class="form-control" v-model="imovel.proprietario.nome" placeholder="Clique para selecionar o proprietário">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>CEP</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.cep" placeholder="CEP">
                            </div>
                            <div class="form-group col-md-8">
                                <label>Logradouro</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.logradouro" placeholder="Logradouro">
                            </div>
                            <div class="form-group col-md-1">
                                <label>Nº</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.numero" placeholder="Nº">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Complemento</label>
                            <input type="text" class="form-control" v-model="imovel.endereco.complemento" placeholder="Complemento">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>Bairro</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.bairro" placeholder="Bairro">
                            </div>
                            <div class="form-group col-md-5">
                                <label>Cidade</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.cidade" placeholder="Cidade">
                            </div>
                            <div class="form-group col-md-2">
                                <label>UF</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.uf" placeholder="UF">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade update-imovel">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">Atualizar imovel: {{imovel.nome}}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form ref="atualizarFormImovel" v-on:submit="atualizar" action="<?php echo route('api.imovel.update')?>">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Proprietário</label>
                                <input readonly type="text" class="form-control" v-model="imovel.proprietario.nome" placeholder="Clique para selecionar o proprietário">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>CEP</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.cep" placeholder="CEP">
                            </div>
                            <div class="form-group col-md-8">
                                <label>Logradouro</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.logradouro" placeholder="Logradouro">
                            </div>
                            <div class="form-group col-md-1">
                                <label>Nº</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.numero" placeholder="Nº">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Complemento</label>
                            <input type="text" class="form-control" v-model="imovel.endereco.complemento" placeholder="Complemento">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>Bairro</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.bairro" placeholder="Bairro">
                            </div>
                            <div class="form-group col-md-5">
                                <label>Cidade</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.cidade" placeholder="Cidade">
                            </div>
                            <div class="form-group col-md-2">
                                <label>UF</label>
                                <input type="text" class="form-control" v-model="imovel.endereco.uf" placeholder="UF">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade detalhes-imovel">
        <div class="modal-dialog modal-dialog-scrollable  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">{{imovel.nome}}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <ul class="nav nav-tabs flex-column" id="detalhes" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="imovel-tab-vertical" data-toggle="tab" href="#imovel-vertical" role="tab" aria-controls="imovel-vertical" aria-selected="true">Detalhes</a>
                            </li>
                        </ul>

                        <div class="tab-content m-l-15" id="myTabContentVertical">
                            <div class="tab-pane fade show active" id="imovel-vertical" role="tabpanel" aria-labelledby="imovel-tab-vertical">
                                <form ref="detalhesFormImovel">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Proprietário</label>
                                            <input readonly type="text" class="form-control" v-model="imovel.proprietario.nome" placeholder="Clique para selecionar o proprietário">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label>CEP</label>
                                            <input readonly type="text" class="form-control" v-model="imovel.endereco.cep" placeholder="CEP">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Logradouro</label>
                                            <input readonly type="text" class="form-control" v-model="imovel.endereco.logradouro" placeholder="Logradouro">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label>Nº</label>
                                            <input readonly type="text" class="form-control" v-model="imovel.endereco.numero" placeholder="Nº">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input readonly type="text" class="form-control" v-model="imovel.endereco.complemento" placeholder="Complemento">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label>Bairro</label>
                                            <input readonly type="text" class="form-control" v-model="imovel.endereco.bairro" placeholder="Bairro">
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>Cidade</label>
                                            <input readonly type="text" class="form-control" v-model="imovel.endereco.cidade" placeholder="Cidade">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>UF</label>
                                            <input readonly type="text" class="form-control" v-model="imovel.endereco.uf" placeholder="UF">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade lista-proprietarios">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">Proprietarios</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a v-for="proprietario in proprietarios" :key="proprietario.proprietario_id" v-on:click="setProprietario(proprietario)" href="#" class="list-group-item list-group-item-action">
                            {{proprietario.nome}}
                        </a> </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    window.urlApiProprietarios = '<?php echo route('api.proprietarios.list'); ?>'
    window.urlApiImoveis = '<?php echo route('api.imoveis.list'); ?>'
    window.urlApiImoveisDelete = '<?php echo route('api.imovel.delete'); ?>'
</script>

<?php include_once dirname(__FILE__, 2).'/layout/scripts.php'?>
<script src="<?php echo url('vue/imoveis.js');?>"></script>

</body>

</html>
