<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$id_ct = isset($_POST['id_con_super']) ? $_POST['id_con_super'] : exit('Acción no permitida: Supervisar');
//API URL
$url = $api . 'terceros/datos/res/detalles/documentos/contrato_supervisar/' . $id_ct;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$det_contrato = json_decode($result, true);
//API URL
$url = $api . 'terceros/datos/res/listar/contrato_acta/' . $id_ct;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$acta_contrato = json_decode($result, true);

if (!empty($acta_contrato)) {
    $ruta = base64_encode($acta_contrato['ruta_contrato'] . $acta_contrato['nombre_contrato']);
    $num = 1;
    $nom_doc = 'CONTRATO CC-' . $acta_contrato['id_contrato'];
    $data[] = [
        'num' => $num,
        'doc' => $nom_doc,
        'archivo' => ' <div class="center-block"><a value="' . $ruta . '|' . strtolower($nom_doc) . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb descargar" title="Descargar"><span class="fas fa-file-pdf fa-lg"></span></a></div>',
        'estado' => '',
    ];
    if ($acta_contrato['estado'] == 1) {
        $num = 2;
        $ruta = base64_encode($acta_contrato['ruta'] . $acta_contrato['nombre']);
        $nom_doc = 'ACTA DESIGNACION SUPERVISOR';
        $data[] = [
            'num' => $num,
            'doc' => $nom_doc,
            'archivo' => ' <div class="center-block"><a value="' . $ruta . '|' . strtolower($nom_doc) . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb descargar" title="Descargar"><span class="fas fa-file-pdf fa-lg"></span></a></div>',
            'estado' => '<div class="center-block"><a id="btnDevActaDesigSuperv" value="' . $acta_contrato['id_c_rec'] . '" class="btn btn-outline-success btn-sm btn-circle shadow-gb" title="Enviar Acta Designación"><span class="fas fa-share-square fa-lg"></span></a></div>',
        ];
    }
    foreach ($det_contrato as $ds) {
        $num++;
        $id_doc = $ds['id_doc_c'];
        if ($ds['id_tipo_doc'] == 99) {
            $nom_doc = $ds['otro_tipo'];
        } else {
            $nom_doc = $ds['descripcion'];
        }
        switch ($ds['estado']) {
            case '1':
                $estado = '<a value="' . $id_doc . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb rechazar" title="Rechazar"><span class="fas fa-times-circle fa-lg"></span></a>' . '<a value="' . $id_doc . '" class="btn btn-outline-success btn-sm btn-circle shadow-gb aprobar" title="Aprobar"><span class="fas fa-check-circle fa-lg"></span></a>';
                break;
            case '2':
                $estado = '<span class="fas fa-check-circle fa-lg shadow-gb rounded-circle" style="color:#2ECC71;" title="Aprobado"></span>';
                break;
            case '3':
                $estado = '<span class="fas fa-times-circle fa-lg shadow-gb rounded-circle" style="color:#E74C3C;" title="Rechazado"></span></a>';
                break;
        }
        if ($ds['id_tipo_doc'] == 98) {
            $estado = null;
        }
        $ruta = base64_encode($ds['ruta_doc_c'] . $ds['nom_doc_c']);
        $data[] = [
            'num' => $num,
            'doc' => mb_strtoupper($nom_doc),
            'archivo' => '<div class="center-block"><a value="' . $ruta . '|' . strtolower($nom_doc) . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb descargar" title="Descargar"><span class="fas fa-file-pdf fa-lg"></span></a></div>',
            'estado' => '<div class="center-block">' . $estado . '</div>',
        ];
    }
} else {
    $data = [];
}

$datos = ['data' => $data];
//header('Content-Type: application/json');
echo json_encode($datos);
