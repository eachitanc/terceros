<?php
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}

$idD = $_SESSION['del'];
include('../../../set/conexion.php');
//API URL
$url = $api . 'terceros/datos/res/eliminar/documento_soporte_c/' . $idD;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$res = json_decode($result, true);
print_r($res);
