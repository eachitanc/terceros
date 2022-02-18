<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$id_ct = $_POST['id_contr'];
//API URL
$url = $api . 'terceros/datos/res/detalles/contrato/' . $id_ct;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$det_contrato = json_decode($result, true);
if ($det_contrato != 0) {
    $ruta = base64_encode($det_contrato['contrato']['ruta_contrato'] . $det_contrato['contrato']['nombre_contrato']);
    $num = 1;
    $nom_doc = 'CONTRATO CC-' . $det_contrato['contrato']['id_contrato'];
    $data[] = [
        'num' => $num,
        'doc' => $nom_doc,
        'archivo' => ' <div class="center-block"><a value="' . $ruta . '|' . strtolower($nom_doc) . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb descargar" title="Descargar"><span class="fas fa-file-pdf fa-lg"></span></a></div>',
        'estado' => '',
        'botones' => '',
    ];
    foreach ($det_contrato['docs'] as $ds) {
        $num++;
        $id_doc = $ds['id_doc_c'];
        if ($ds['id_tipo_doc'] == 99) {
            $nom_doc = $ds['otro_tipo'];
        } else {
            $nom_doc = $ds['descripcion'];
        }
        if ($ds['estado'] == 2) {
            $estado = '<span class="fas fa-check-circle fa-lg shadow-gb rounded-circle" style="color:#2ECC71;" title="Aprobado"></span>';
            $editar = $borrar = null;
        } else if ($ds['estado'] == 1) {
            $estado = '<span class="fas fa-times-circle fa-lg shadow-gb rounded-circle" style="color:#838383;" title="Pendiente Aprobación"></span></a>';
            $editar = '<a value="' . $id_doc . '" class="btn btn-outline-primary btn-sm btn-circle shadow-gb editar" title="Editar"><span class="fas fa-pencil-alt fa-lg"></span></a>';
            $borrar = '<a value="' . $id_doc . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb borrar" title="Eliminar"><span class="fas fa-trash-alt fa-lg"></span></a>';
        } else {
            $estado = '<span class="fas fa-times-circle fa-lg shadow-gb rounded-circle" style="color:#E74C3C;" title="Rechazado"></span></a>';
            $editar = '<a value="' . $id_doc . '" class="btn btn-outline-primary btn-sm btn-circle shadow-gb editar" title="Editar"><span class="fas fa-pencil-alt fa-lg"></span></a>';
            $borrar = '<a value="' . $id_doc . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb borrar" title="Eliminar"><span class="fas fa-trash-alt fa-lg"></span></a>';
        }
        $ruta = base64_encode($ds['ruta_doc_c'] . $ds['nom_doc_c']);
        $data[] = [
            'num' => $num,
            'doc' => mb_strtoupper($nom_doc),
            'archivo' => '<div class="center-block"><a value="' . $ruta . '|' . strtolower($nom_doc) . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb descargar" title="Descargar"><span class="fas fa-file-pdf fa-lg"></span></a></div>',
            'estado' => '<div class="center-block">' . $estado . '</div>',
            'botones' => '<div class="center-block">' . $editar . $borrar . '</div>',
        ];
    }
} else {
    $data = [];
}

$datos = ['data' => $data];
//header('Content-Type: application/json');
echo json_encode($datos);
