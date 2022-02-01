<?php
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include('../../../set/conexion.php');
$estado = $_POST['e'];
$idter = $_POST['idt'];
$iduser = $_SESSION['id_otro']; 
$tipuser = 'otro'; 

//API URL
$url =$api.'terceros/datos/res/modificar/estado/actividad';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$data = [
    "estado" => $estado,
    "idter" => $idter,
    "iduser" => $iduser,
    "tipuser" => $tipuser,
];
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo json_decode($result);