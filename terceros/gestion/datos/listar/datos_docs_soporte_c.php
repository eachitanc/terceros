<?php
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['otro'])) {
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
    $data[] = [
        'num' => $num,
        'doc' => 'CONTRATO CC-' . $det_contrato['contrato']['id_contrato'],
        'archivo' => ' <div class="center-block"><a value="' . $ruta . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb descargar" title="Descargar"><span class="fas fa-file-pdf fa-lg"></span></a></div>',
        'botones' => '',
    ];
    foreach ($det_contrato['docs'] as $ds) {
        $num++;
        $id_doc = $ds['id_doc_c'];
        $editar = '<a value="' . $id_doc . '" class="btn btn-outline-primary btn-sm btn-circle shadow-gb editar" title="Editar"><span class="fas fa-pencil-alt fa-lg"></span></a>';
        $borrar = '<a value="' . $id_doc . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb borrar" title="Eliminar"><span class="fas fa-trash-alt fa-lg"></span></a>';
        $ruta = base64_encode($ds['ruta_doc_c'] . $ds['nom_doc_c']);
        $data[] = [
            'num' => $num,
            'doc' => $id_doc,
            'archivo' => '<div class="center-block"><a value="' . $ruta . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb descargar" title="Descargar"><span class="fas fa-file-pdf fa-lg"></span></a></div>',
            'botones' => '<div class="center-block">' . $editar . $borrar . '</div>',
        ];
    }
} else {
    $data = [];
}

$datos = ['data' => $data];
//header('Content-Type: application/json');
echo json_encode($datos);
