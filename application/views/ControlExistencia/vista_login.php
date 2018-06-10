<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 13-05-2018
 * Time: 18:10
 */
?>
<div class="row" style="margin-top: 50px;">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading"
                 style="color: white;background: linear-gradient(to right,#1F4661 ,#04BBBF);height: 70px; ">
                <div class="panel-title text-center"><strong>INICIO DE SESION</strong></div>
            </div>
            <div class="panel-body" style="background-color: #F2F2F5;">
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-4" style="margin-left: 50px;">
                        <br>
                        <div class="form-group">
                            <input type="text" class="form-control input-lg" id="add_usuario" name="usuario"
                                   value="" placeholder="Usuario" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control input-lg" id="add_password" name="password"
                                   value="" placeholder="Contraseña" required>
                        </div>
                        <button type="submit" id="btn_login" class="btn btn-primary btn-lg pull-right">Ingresar
                        </button>
                        <!--<button type="reset" class="btn btn-default">Limpiar</button>-->
                        <br><br>
                    </div>
                    <div class="col-md-6" style="margin-left: 50px;">
                        <img class="img-responsive" src="<?php echo base_url('/public/img/img_login.jpg') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#btn_login").on('click', function () {
            var array = {
                usuario: $("#add_usuario").val(),
                password: $("#add_password").val()
            };
            var request = envia_ajax('/proyecto_base/control_existencia/logeo', array);
            request.fail(function () {
                $("#modal_generico_body").html('Error al enviar peticion porfavor recargue la pagina');
                $("#modal_generico").modal('show');
            });
            request.done(function (data) {
                if (data.respuesta == "S") {
                    $(location).attr('href','/proyecto_base/control_existencia');
                }
                else {
                    $("#modal_generico_body").html(data.data);
                    $("#modal_generico").modal('show');
                }
            });
        });

        function envia_ajax(url, data) {
            var variable = $.ajax({
                url: url,
                method: "POST",
                data: data,
                "dataSrc": "data",
                dataType: "json"
            });
            return variable;
        }
    });
</script>