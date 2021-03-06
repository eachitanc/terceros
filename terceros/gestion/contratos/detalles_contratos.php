<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include '../../../set/conexion.php';
$id_contrato = isset($_POST['det_contrato']) ? $_POST['det_contrato'] : exit('Acción no permitida');
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
                                    <div id="id_contrato_d"></div>
                                    DOCUMENTOS SOPORTE CONTRATO
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="divCuerpoPag" style="min-height: 73vh;">
                            <input type="hidden" id="id_ct" value="<?php echo $id_contrato ?>">
                            <div class="table-responsive">
                                <table id="tableDocSopContrato" class="table table-striped table-bordered table-sm nowrap table-hover shadow" style="width:100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Documento</th>
                                            <th>Archivo</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modificarDocSopContrato">
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <a class="btn btn-secondary" href="../detalles_tercero.php">Regresar</a>
                            </div>
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