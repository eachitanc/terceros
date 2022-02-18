<?php
session_start();
if (!isset($_SESSION['id_otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$estado = isset($_POST['estado']) ? $_POST['estado'] : exit('Acción no permitida');
$id_doc = $_POST['id'];
$iduser = $_SESSION['id_otro'];
//API
$url = $api . 'terceros/datos/res/actualizar/estado_doc_soporte';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$data = [
    "estado" => $estado,
    "id_doc" => $id_doc,
    "iduser" => $iduser,
    "tipuser" => 'otro',
];
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo  json_decode($result, true);
