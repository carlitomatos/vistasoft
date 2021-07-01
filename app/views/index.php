<?php
$params = $this->getParams();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>VistaSoft</title>

    <!-- page css -->

    <!-- Core css -->
    <link href="<?php echo url('css/app.min.css');?>" rel="stylesheet">

</head>

<body>
<div class="app">
    <div class="layout">
        <?php include_once 'layout/header.php'?>
        <?php include_once 'layout/side.php'?>



        <!-- Page Container START -->
        <div class="page-container">

            <!-- Content Wrapper START -->
            <div class="main-content">
                <div class="page-header">
                    <h2 class="header-title">Início</h2>
                    <div class="header-sub-title">
                        <nav class="breadcrumb breadcrumb-dash">
                            <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Início</a>
                        </nav>
                    </div>
                </div>
                <!-- Content goes Here -->
            </div>
            <!-- Content Wrapper END -->

        </div>
        <!-- Page Container END -->
    </div>
</div>


<script src="<?php echo url('js/vendors.min.js');?>"></script>
<script src="<?php echo url('js/app.min.js');?>"></script>

</body>

</html>
