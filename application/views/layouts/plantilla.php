<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 14-01-2018
 * Time: 20:40
 */
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Control de Existencia</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo base_url('/public/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/select2/dist/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/select_bootstrap/dist/select2-bootstrap.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/select_bootstrap/dist/select2-bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/css/datatables.css') ?>">
    <!-- Carga Inicial por carga de plantilla-->
    <script src="<?php echo base_url('/public/js/jquery.js') ?>"></script>
</head>
<body>
<!-- comienzo banner -->
<div class="row">
    <div name="banner" style="color: white; height: 100px;background: linear-gradient(to right,#1F4661 , #04BBBF); ">
        <div class="col-md-4" style="margin-left: 20px;margin-top: 10px;">
            <h2>Servicio de Salud Araucanía Sur</h2>
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-1">
            <img src="<?php echo base_url('/public/img/logo-ssas.png') ?>" style="width: 125px;height: 113px;">
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- fin banner -->
<div class="row">
    <!-- contenedor menu lateral -->
    <div class="col-md-2" style="height: 800px; margin-top: -12px; ">
        <!-- menu lateral -->
        <div class="nav-side-menu">
            <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
            <div class="menu-list">
                <ul id="menu-content" class="menu-content collapse out">
                    <li>
                        <a href="#">
                            <i class="fa fa-dashboard fa-lg"></i> Sistema de Control de Existencia
                        </a>
                    </li>
                    <!-- Inventario -->
                    <li data-toggle="collapse" data-target="#products" class="collapsed active">
                        <a href="#">
                            <span class="glyphicon glyphicon-list-alt"></span>
                            <i class="fa fa-gift fa-lg"></i> Inventario
                            <i class="glyphicon glyphicon-chevron-down"></i>
                        </a>
                    </li>
                    <ul class="sub-menu collapse" id="products">
                        <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 1 ){?>
                        <li class="active">
                            <span class="glyphicon glyphicon-shopping-cart"></span>
                            <a href="<?php echo base_url('/mantenedores/productos') ?>">Mantenedor Productos</a></li>
                        <?php } ?>
                        <li>
                            <span class="glyphicon glyphicon-globe"></span>
                            <a href="<?php echo base_url('/control_existencias/stock') ?>">Control de existencia</a>
                        </li>
                    </ul>
                    <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 1 ){?>
                    <li>
                        <a href="<?php echo base_url('/mantenedores/usuarios') ?>">
                            <span class="glyphicon glyphicon-user"></span>
                            <i class="fa fa-user fa-lg"></i> Mantenedor Usuarios
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo base_url('/control_existencia') ?>">
                            <span class="glyphicon glyphicon-th-large"></span>
                            <i class="fa fa-users fa-lg"></i> Dashboard
                        </a>
                    </li>
                    <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 1 ){?>
                    <li>
                        <a href="<?php echo base_url('/gestion/mercado_publico') ?>">
                            <span class="glyphicon glyphicon-briefcase"></span>
                            <i class="fa fa-users fa-lg"></i> Modulo Mercado Publico
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo base_url('/control_existencia/login') ?>"><i class="glyphicon glyphicon-off"></i>Salir </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- fin contenedor menu lateral -->
    <br>
    <!-- contenedor centro -->
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10" >
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Inicio</a>
                    </li>
                    <li class="active">
                        Sistema Control de Existencia
                    </li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row">
            <div class="col-md-12" style="margin-left: 20px;">
                <!-- contenedor centro de relleno -->
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style=" ">
                    <?php echo $content_for_layout; ?>
                </div>
                <!-- contenedor centro de relleno -->
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- contenedor centro -->
</div>
</body>
<style>
    hr {
        -moz-border-bottom-colors: none;
        -moz-border-image: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: #EEEEEE -moz-use-text-color #FFFFFF;
        border-style: solid none;
        border-width: 1px 0;
        margin: 18px;
    }

    .select2 {
        width: 100% !important;
    }

    .dataTables_filter {
        width: 50%;
        float: right;
        text-align: right;
    }

    /* css del menu */
    .nav-side-menu {
        overflow: auto;
        font-family: verdana;
        font-size: 12px;
        font-weight: 200;
        background-color: #F2F2F5;
        position:;
        top: 0px;
        width: 250px;
        height: 100%;
        color: black;
    }

    .nav-side-menu .brand {
        background-color: #23282e;
        line-height: 50px;
        display: block;
        text-align: center;
        font-size: 14px;
    }

    .nav-side-menu .toggle-btn {
        display: none;
    }

    .nav-side-menu ul,
    .nav-side-menu li {
        list-style: none;
        padding: 0px;
        margin: 0px;
        line-height: 35px;
        cursor: pointer;
    }

    .nav-side-menu ul :not(collapsed) .arrow:before,
    .nav-side-menu li :not(collapsed) .arrow:before {
        font-family: FontAwesome;
        content: "\f078";
        display: inline-block;
        padding-left: 10px;
        padding-right: 10px;
        vertical-align: middle;
        float: right;
    }

    /*  Menu activo */
    .nav-side-menu ul .active,
    .nav-side-menu li .active {
        border-left: 3px solid #04BBBF;
        background-color: #d4d4de;
    }

    /*  Menu activo */
    .nav-side-menu ul .sub-menu li.active,
    .nav-side-menu li .sub-menu li.active {
        color: black;
    }

    .nav-side-menu ul .sub-menu li.active a,
    .nav-side-menu li .sub-menu li.active a {
        color: black;
    }

    /*  sub menu */
    .nav-side-menu ul .sub-menu li,
    .nav-side-menu li .sub-menu li {
        background-color: #d4d4de;
        border: none;
        line-height: 28px;
        
        margin-left: 0px;
    }

    /*  sub menu */
    .nav-side-menu ul .sub-menu li:hover,
    .nav-side-menu li .sub-menu li:hover {
        background-color: #A1A1A9;
    }

    .nav-side-menu ul .sub-menu li:before,
    .nav-side-menu li .sub-menu li:before {
        font-family: FontAwesome;
        content: "\f105";
        display: inline-block;
        padding-left: 10px;
        padding-right: 10px;
        vertical-align: middle;
    }

    .nav-side-menu li {
        padding-left: 0px;
        border-left: 3px solid #F2F2F5;
       
    }

    .nav-side-menu li a {
        text-decoration: none;
        color: black;
    }

    .nav-side-menu li a i {
        padding-left: 10px;
        width: 20px;
        padding-right: 20px;
    }

    .nav-side-menu li:hover {
        border-left: 3px solid #04BBBF;
        background-color: #d4d4de;
        -webkit-transition: all 1s ease;
        -moz-transition: all 1s ease;
        -o-transition: all 1s ease;
        -ms-transition: all 1s ease;
        transition: all 1s ease;
    }

    @media (max-width: 767px) {
        .nav-side-menu {
            position: relative;
            width: 100%;
            margin-bottom: 10px;
        }

        .nav-side-menu .toggle-btn {
            display: block;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 10px;
            z-index: 10 !important;
            padding: 3px;
            background-color: #ffffff;
            color: black;
            width: 40px;
            text-align: center;
        }

        .brand {
            text-align: left !important;
            font-size: 22px;
            padding-left: 20px;
            line-height: 50px !important;
        }
    }

    @media (min-width: 767px) {
        .nav-side-menu .menu-list .menu-content {
            display: block;
        }
    }

    body {
        margin: 0px;
        padding: 0px;
    }

    /*  fin css del menu */
</style>
<div class="modal fade" id="modal_generico" tabindex="-1"
     role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
                <h3 id="titulo_modal_generico"></h3>
            </div>
            <div class="modal-body">
                <h4 id="modal_generico_body"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('/public/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('/public/js/datatables.js') ?>"></script>
<script src="<?php echo base_url('/public/js/integracion_datatables.js') ?>"></script>
<script src="<?php echo base_url('/public/select2/dist/js/select2.min.js') ?>"></script>
</html>

