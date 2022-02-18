<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include '../../../set/conexion.php';
$datos_cot = isset($_POST['detalles']) ? $_POST['detalles'] : exit('Acción no permitida');
//API URL
$url = $api . 'terceros/datos/res/detalles/cotizacion/' . $datos_cot;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$det_cot = json_decode($result, true);
$data = explode('|', $datos_cot);
$id_cotizacion = $data[2];
$id_cot_tercero = $data[3];
?>
<!DOCTYPE html>
<html lang="es">
<?php include '../../../set/head.php' ?>

<body class="sb-nav-fixed sb-sidenav-toggled">
    <?php include '../../../set/navsuperior.php'; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid p-0">
                    <div class="card mb-5 mb-4">
                        <div class="card-header" id="divTituloPag">
                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fas fa-tasks fa-lg" style="color: #07CF74;"></i>
                                    DETALLES COTIZACIÓN COT-<?php echo $id_cotizacion ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="divCuerpoPag" style="min-height: 77vh;">
                            <form id="formDetalleCotizacion" name="formDetalleCotizacion">
                                <table id="tableDetalleCotiza" class="table table-striped table-bordered table-sm nowrap table-hover shadow" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Bien o sericio</th>
                                            <th>Cantidad</th>
                                            <th>Valor unitario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="number" name="valor[cot_ter]" value="<?php echo $id_cot_tercero ?>" hidden>
                                        <?php
                                        foreach ($det_cot as $dc) {
                                        ?> <tr>
                                                <td><?php echo $dc['bien_servicio'] ?></td>
                                                <td><?php echo $dc['cantidad'] ?></td>
                                                <td>
                                                    <input type="number" class="form-control altura" name="valor[<?php echo $dc['id_cot'] ?>]">
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <button class="btn btn-success" id="btnEnvCotiz">Enviar Cotización</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php include '../../../set/alerts.php'; ?>
    </div>
    <?php include '../../../set/scripts.php'; ?>
    <?php include '../../../set/footer.php' ?>
</body>

</html>