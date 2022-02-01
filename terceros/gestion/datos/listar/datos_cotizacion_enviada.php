<?php
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$id_c = $_POST['id'];
//API URL
$url = $api . 'terceros/datos/res/lista/cotizacion_enviada/' . $id_c;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$cot_enviada = json_decode($result, true);
if ($cot_enviada != '0') {
    //API URL
    $id_empresa = $cot_enviada[0]['nit_empresa'];
    $url = $api . 'terceros/datos/res/listar/empresas/' . $id_empresa;
    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $datos_empresa = json_decode($result, true);
?>
    <script>
        $('#tableCotizaEnviada').DataTable({
            dom: "<'row'<'col-md-2'l><'col-md-10'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ - _END_ registros de _TOTAL_ ",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ entradas en total )",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Ver _MENU_ Filas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": '<i class="fas fa-search fa-flip-horizontal" style="font-size:1.5rem; color:#2ECC71;"></i>',
                "zeroRecords": "No se encontraron registros",
                "paginate": {
                    "first": "&#10096&#10096",
                    "last": "&#10097&#10097",
                    "next": "&#10097",
                    "previous": "&#10096"
                },
            },
            "order": [
                [0, "desc"]
            ]
        });
        $('#tableCotizaEnviada').wrap('<div class="overflow" />');
    </script>
    <div class="px-0">
        <div class="shadow">
            <div class="card-header" style="background-color: #16a085 !important;">
                <h5 style="color: white;">COTIZACIÓN ENVIADA</h5>
            </div>
            <div class="px-4 py-4">
                <div class="shadow detalles-empleado">
                    <div class="row">
                        <div class="div-mostrar bor-top-left col-md-3">
                            <label class="lbl-mostrar">NIT</label>
                            <div class="div-cont"><?php echo $datos_empresa['nit'] . '-' . $datos_empresa['dig_ver'] ?></div>
                        </div>
                        <div class="div-mostrar bor-top-right col-md-9">
                            <label class="lbl-mostrar">RAZÓN SOCIAL</label>
                            <div class="div-cont"><?php echo $datos_empresa['nombre'] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="div-mostrar bor-bottom-left col-md-4">
                            <label class="lbl-mostrar">DEPARTAMENTO</label>
                            <div class="div-cont"><?php echo $datos_empresa['nombre_dpto'] ?></div>
                        </div>
                        <div class="div-mostrar  col-md-4">
                            <label class="lbl-mostrar">MUNICIPIO</label>
                            <div class="div-cont"><?php echo $datos_empresa['nom_municipio'] ?></div>
                        </div>
                        <div class="div-mostrar bor-bottom-right col-md-4">
                            <label class="lbl-mostrar">DIRECCION</label>
                            <div class="div-cont"><?php echo $datos_empresa['direccion'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <table id="tableCotizaEnviada" class="table table-striped table-bordered table-sm nowrap table-hover shadow" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Bien o sericio</th>
                            <th>Cantidad</th>
                            <th>Valor unitario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($cot_enviada as $ce) {
                        ?> <tr>
                                <td class="text-left"><?php echo $ce['bien_servicio'] ?></td>
                                <td><?php echo $ce['cantidad'] ?></td>
                                <td class="text-right">$ <?php echo $ce['valor'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-right pt-3">
            <a type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"> Aceptar</a>
        </div>
    </div>
<?php
} else {
    echo 'Error al intentar obtener cotización';
}
