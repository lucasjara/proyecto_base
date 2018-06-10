<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 06-05-2018
 * Time: 0:25
 */
?>
<link rel="stylesheet" href="<?php echo base_url('/public/css/Morris/morris.css') ?>">
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading" style="background-color:#00CCFF;">
            <div class="panel-title pull-left">Bienvenido al Sistema</div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title pull-left"><p>Sistema Control de Existencia!!!</p></div>
                            <div class="panel-title pull-right"></div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-success">
                                <strong>Bienvenido</strong> Felicitaciones por acceder al Sistema de Control de Existencia.
                                <p><b>Consejos Usuario:</b></p>
                                <ul>
                                    <li><strong>Recordar</strong> Se recomienda realizar un cambio de contraseña cada 6 meses.</li>
                                    <li><strong>Recordar</strong> Si necesita orientacion del sistema debe acceder a los cursos disponibles en la plataformas del Servicio </li>
                                    <li><strong>Recordar</strong> En caso de encontrarse ante una duda o falla puede comunicarse al numero .... con ... encargado de Soporte</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-primary">
                            <div class="panel-heading">STOCK ACTUAL PRODUCTOS</div>
                        </div>
                        <div class="panel-body">
                            <div id="grafico_stock_productos_existentes" style=" height: 200px;" ></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title pull-left">
                                <p>CANTIDAD INGRESO DE STOCK SISTEMA</p>
                            </div>
                            <div class="panel-title pull-right">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div id="grafico_stock_lineal" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title pull-left"><p>Ultimos Movimientos</p></div>
                            <div class="panel-title pull-right"></div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <table id="tabla_movimientos" class="table table-hover table-striped table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>MOVIMIENTO</th>
                                    <th>PRODUCTO</th>
                                    <th>CANTIDAD</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            
        </div>
    </div>
</div>
<script src="<?php echo base_url('/public/graficos/morris.min.js') ?>"></script>
<script src="<?php echo base_url('/public/graficos/raphael-min.js') ?>"></script>
<script src="<?php echo base_url('/public/js/control_existencia/script.js') ?>"></script>
