<?php
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include '../../../set/conexion.php';
$datos = isset($_REQUEST['valor']) ? $_REQUEST['valor'] : exit('Acción no permitida');
$datos['id_tercero'] = $_SESSION['id_otro'];
//API URL
$url = $api . 'terceros/datos/res/nuevo/cotizacion/valores';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$payload = json_encode($datos);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo json_decode($result);
