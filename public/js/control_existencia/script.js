$(document).ready(function () {

    var request = envia_ajax('/proyecto_base/ControlExistencia/graficos');
    request.fail(function () {
        $("#modal_generico_body").html('Error al enviar peticion porfavor recargue la pagina');
        $("#modal_generico").modal('show');
    });
    request.done(function (data) {
        if (data.respuesta == "S") {
            var arreglo = [];
            data.grafico_stock.forEach(function (element) {
                arreglo.push({label: element.PRODUCTO, value: element.CANTIDAD});
            })
            Morris.Donut({
                element: 'grafico_stock_productos_existentes',
                data: arreglo
            });
            var arreglo_lineal = [];
            data.grafico_lineal.forEach(function (element) {
                arreglo_lineal.push({y: element.FECHA, a: element.CANTIDAD});
            });
            Morris.Line({
                element: 'grafico_stock_lineal',
                data: arreglo_lineal,
                xkey: "y",
                ykeys: "a",
                labels: ['Cantidad'],
                xLabelFormat: function (x) {
                    return x.getDate();
                }
            });
            $("#tabla_movimientos").DataTable({
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                "language": {
                    "url": "/codeigniter/public/Spanish.json"
                },
                "columns":[
                    {"data": "TIPO_MOVIMIENTO",
                        "className": "text-center"},
                    {"data": "PRODUCTO"},
                    {"data": "CANTIDAD"}
                ],
                "data": data.movimientos,
            })
        }
        else {
            $("#modal_generico_body").html(data.data);
            $("#modal_generico").modal('show');
        }
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