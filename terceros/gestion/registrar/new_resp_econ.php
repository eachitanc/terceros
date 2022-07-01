<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include '../../../set/conexion.php';
$idt = $_POST['idTercero'];
$id_resp_econ = $_POST['slcRespEcon'];
$iduser =  $_SESSION['id_otro'];
$tipouser = 'otro';

//API URL
$url =$api.'terceros/datos/res/nuevo/responsabilidad';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$data = [
    "id_terero" => $idt,
    "id_responsabilidad" => $id_resp_econ,
    "id_user" => $iduser,
    "tipo_user" => $tipouser,
    "nit_reg" => $_SESSION['cc_nit'],
];
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo json_decode($result);