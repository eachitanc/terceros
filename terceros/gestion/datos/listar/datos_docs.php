<?php
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$id_t = $_POST['id_t'];
//API URL
$url =$api.'terceros/datos/res/listar/docs/' . $id_t;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$docs = json_decode($result, true);
if ($docs !== '0') {
    foreach ($docs as $d) {
        $id_doc = $d['id_docster'];
        $editar = '<a value="' . $id_doc . '" class="btn btn-outline-primary btn-sm btn-circle shadow-gb editar" title="Editar"><span class="fas fa-pencil-alt fa-lg"></span></a>';
        $estado = $d['fec_vig'] > date('Y-m-d') ? '<div class="activo">SI</div>' : '<div class="inactivo">NO</div>';
        $ruta = substr($d['ruta_doc'] . $d['nombre_doc'], 3);
        $borrar = '<a value="' . $id_doc . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb borrar" title="Eliminar"><span class="fas fa-trash-alt fa-lg"></span></a>';
        $data[] = [
            'id_doc' => $id_doc,
            'tipo' => mb_strtoupper($d['descripcion']),
            'fec_inicio' => $d['fec_inicio'],
            'fec_vigencia' => $d['fec_vig'],
            'vigente' => '<div class="text-center">' . $estado . '</div>',
            'doc' => '<div class="text-center"><a class="btn btn-outline-danger btn-sm btn-circle shadow-gb descargar" value="'.$id_doc.'" title="Descargar"><span class="far fa-file-pdf fa-lg"></span></a></div>',
            'botones' => '<div class="center-block">' . $editar . $borrar . '</form></div>',
        ];
    }
} else {
    $data = [];
}

$datos = ['data' => $data];
//header('Content-Type: application/json');
echo json_encode($datos);
