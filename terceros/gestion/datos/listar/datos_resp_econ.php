<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$id_t = $_POST['id_t'];
//API URL
$url =$api.'terceros/datos/res/lista/resp_econ/' . $id_t;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$responsabilidades = json_decode($result, true);
if ($responsabilidades !== '0') {
    foreach ($responsabilidades as $r) {
        $idre = $r['id_resptercero'];
        if($r['estado'] == '1'){
            $estado = '<button class="btn-estado"><span class="fas fa-toggle-on fa-lg estado activo" value="' . $idre . '" title="Activo"></span></button>';
        }else{
            $estado = '<button class="btn-estado"><span class="fas fa-toggle-off fa-lg estado inactivo" value="' . $idre . '" title="Inactivo"></span></button>';
        }
        $borrar = '<a value="' . $idre . '" class="btn btn-outline-danger btn-sm btn-circle shadow-gb borrar" title="Eliminar"><span class="fas fa-trash-alt fa-lg"></span></a>';
        $data[] = [
            'codigo' => $r['codigo'],
            'descripcion' => mb_strtoupper($r['descripcion']),
            'estado' => '<div class="text-center">' . $estado . '</div>',
            'botones' => '<div class="text-center">'.$borrar.'</div>',
        ];
    }
} else {
    $data = [];
}

$datos = ['data' => $data];
//header('Content-Type: application/json');
echo json_encode($datos);
