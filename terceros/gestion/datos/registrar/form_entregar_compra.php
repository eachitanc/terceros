<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$id_c = $_POST['id'];
//API URL
$url = $api . 'terceros/datos/res/lista/compra_entregado/' . $id_c;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$separar = explode('|', $id_c);
$compra_entregada = json_decode($result, true);
if ($compra_entregada != '0') {
    //API URL
    $id_empresa = $compra_entregada['nit'];
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
            order: [
                [0, "desc"]
            ],
        });
        $('#tableCotizaEnviada').wrap('<div class="overflow" />');
    </script>
    <div class="px-0">
        <div class="shadow">
            <div class="card-header" style="background-color: #16a085 !important;">
                <h5 style="color: white;">ENTREGAR COMPRA</h5>
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
            <div id="entrega_completa" class="alert alert-danger" role="alert" style="display: none;">
                <strong style="color: white;">LA ENTREGA SE HA REALIZADO EN SU TOTALIDAD.</strong>
            </div>
            <div id="contTablaEntrega" class="px-4">
                <form id="formCantEntrega">
                    <table id="tableCotizaEnviada" class="table table-striped table-bordered table-sm nowrap table-hover shadow" width="100%">
                        <thead>
                            <tr>
                                <th>Bien o sericio</th>
                                <th>Cantidad Contratada</th>
                                <th>Entrega # 1</th>
                                <?php
                                for ($i = 2; $i <= $compra_entregada['num_entregas']['entregas']; $i++) {
                                    echo '<th>Entrega # ' . $i . ' </th>';
                                }
                                ?>
                                <th>Cantidad Pendiente</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_entrega = 0;
                            foreach ($compra_entregada['listado'] as $ce) {
                            ?>
                                <tr>
                                    <td class="text-left"><?php echo $ce['bien_servicio'] ?></td>
                                    <td><?php echo $ce['cantid'] ?></td>
                                    <?php
                                    $array_entregado = $compra_entregada['entregas'];
                                    $c_entregado = 0;
                                    foreach ($array_entregado as $ae) {
                                        if ($ae['id_val_cot'] == $ce['id_val_cot']) {
                                            $c_entregado += $ae['cantidad_entrega'];
                                            echo '<td>' . $ae['cantidad_entrega'] . '</td>';
                                        }
                                    }
                                    ?>
                                    <td>
                                        <?php
                                        if ($ce['cantid'] > $c_entregado) {
                                            $pendiente = $ce['cantid'] - $c_entregado;
                                            $total_entrega += $pendiente;
                                        ?>
                                            <input type="number" class="form-control form-control-sm altura" name="entrega[<?php echo $ce['id_val_cot'] ?>]" id="entrega[]" value="<?php echo $pendiente ?>" min=0 max=<?php echo $pendiente ?>>
                                        <?php
                                        } else {
                                            echo '<input type="number" class="form-control form-control-sm altura" name="entrega[' . $ce['id_val_cot'] . ']" id="entrega[]" value="0" min=0 max=0 readonly>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="pendits" value="<?php echo $total_entrega ?>">
                    <input type="hidden" name="id_conto" value="<?php echo $compra_entregada['id_c'] ?>">
                </form>
            </div>
        </div>
        <div class="text-right pt-3">
            <?php if ($total_entrega > 0) { ?>
                <a type="button" class="btn btn-success btn-sm" id="btnEntregarCompra"> Entregar</a>
            <?php } else { ?>
                <script>
                    document.getElementById("entrega_completa").style.display = 'block';
                </script>
            <?php } ?>
            <a type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</a>
        </div>
    </div>
<?php
} else {
    echo 'Error al intentar obtener datos de contrato';
}
