<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
//API URL
$id_t = isset($_SESSION['id_otro']) ? $_SESSION['id_otro'] : exit('No se ha podido obtener el id del usuario');
$nit = isset($_POST['slcEmpresa']) ? $_POST['slcEmpresa'] : exit('Acción no permitida');
$anio = $_POST['numAnioCertifica'];
$tipo = $_POST['slcTipoCertificado'];
$data = $nit . '|' . $anio . '|' . $tipo . '|' . $id_t;
$url = $api . 'terceros/datos/res/consulta/certificados/' . $data;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$forms220 = json_decode($result, true);
$res = [];
if ($forms220 == '0') {
    $res['status'] = 0;
    $res['response'] =  'No se ha encontrado un certificado disponible para la empresa seleccionada';
} else {
    $res['status'] = 1;
    $res['response'] =  base64_encode($forms220);
}
echo json_encode($res);
