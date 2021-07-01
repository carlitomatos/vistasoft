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
<div class="app" id="clientes">
    <div class="layout">
        <?php include_once dirname(__FILE__, 2) .'/layout/header.php'?>
        <?php include_once dirname(__FILE__, 2).'/layout/side.php'?>



        <!-- Page Container START -->
        <div class="page-container">

            <!-- Content Wrapper START -->
            <div class="main-content">
                <div class="page-header">
                    <h2 class="header-title">Clientes</h2>
                    <div class="header-sub-title">
                        <nav class="breadcrumb breadcrumb-dash">
                            <a href="<?php echo route('index')?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Início</a>
                            <span class="breadcrumb-item active">Clientes</span>
                        </nav>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" v-on:click="novoCliente">Novo Cliente</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Clientes Cadastrados</h4>
                    </div>
                    <div class="card-body">
                        <table id="tblClientes" class="table">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Ações</th>
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
    <div class="modal fade cadastro-cliente">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">Novo Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form ref="salvarForm" v-on:submit="salvar" action="<?php echo route('api.cliente.save')?>">
                        <div class="form-group row">
                            <label for="nome" class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-10">
                                <input type="text" v-model="cliente.nome" class="form-control" id="nome"  name="nome" placeholder="Nome">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" v-model="cliente.email" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefone" class="col-sm-2 col-form-label">Telefone</label>
                            <div class="col-sm-10">
                                <input type="text" v-model="cliente.telefone" class="form-control" id="telefone" name="telefone" placeholder="Telefone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade update-cliente">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">Atualizar Cliente: {{cliente.nome}}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form ref="atualizarForm" v-on:submit="atualizar" action="<?php echo route('api.cliente.update')?>">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-10">
                                <input type="text" v-model="cliente.nome" class="form-control"  name="nome" placeholder="Nome">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" v-model="cliente.email" class="form-control" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Telefone</label>
                            <div class="col-sm-10">
                                <input type="text" v-model="cliente.telefone" class="form-control"  name="telefone" placeholder="Telefone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.urlApiClientes = '<?php echo route('api.clientes.list'); ?>'
    window.urlApiClientesDelete = '<?php echo route('api.cliente.delete'); ?>'
</script>
<?php include_once dirname(__FILE__, 2).'/layout/scripts.php'?>
<script src="<?php echo url('vue/clientes.js');?>"></script>


</body>

</html>
