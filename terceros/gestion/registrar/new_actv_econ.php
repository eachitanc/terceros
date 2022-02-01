<?php
session_start();
if (!isset($_SESSION['id_otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include '../../../set/conexion.php';
$idt = $_POST['idTercero'];
$id_actv_econ = $_POST['slcActvEcon'];
$finic = date('Y-m-d', strtotime($_POST['datFecInicio']));
$estado = '1';
$iduser = $_SESSION['id_otro'];
$tipuser = 'otro';
//API URL
$url =$api.'terceros/datos/res/nuevo/actividad';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$data = [
    "id_tercero" => $idt,
    "id_actividad" => $id_actv_econ,
    "finic" => $finic,
    "id_user" => $iduser,
    "tipo_user" => $tipuser,
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