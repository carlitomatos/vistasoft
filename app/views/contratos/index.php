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
<div class="app" id="contratos">
    <div class="layout">
        <?php include_once dirname(__FILE__, 2) .'/layout/header.php'?>
        <?php include_once dirname(__FILE__, 2).'/layout/side.php'?>



        <!-- Page Container START -->
        <div class="page-container">

            <!-- Content Wrapper START -->
            <div class="main-content">
                <div class="page-header">
                    <h2 class="header-title">Contratos</h2>
                    <div class="header-sub-title">
                        <nav class="breadcrumb breadcrumb-dash">
                            <a href="<?php echo route('index')?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Início</a>
                            <span class="breadcrumb-item active">Contratos</span>
                        </nav>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <a href="#" class="btn btn-primary m-r-5">Novo Contrato</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Contratos Cadastrados</h4>
                    </div>
                    <div class="card-body">
                        <table id="tblContratos" class="table">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Proprietário</th>
                                <th>Locatário</th>
                                <th>Data Início</th>
                                <th>Data Fim</th>
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
</div>


<?php include_once dirname(__FILE__, 2).'/layout/scripts.php'?>
<script src="<?php echo url('vue/contratos.js');?>"></script>

</body>

</html>
