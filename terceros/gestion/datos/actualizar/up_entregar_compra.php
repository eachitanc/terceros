<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$entregas = isset($_REQUEST['entrega']) ? $_REQUEST['entrega'] : exit('Acción no permitida');
$entregas[0] = [
    "iduser" => $_SESSION['id_otro'],
    "tipuser" => 'otro',
    "pendientes" => $_POST['pendits'],
    "id_contrato" => $_POST['id_conto'],
];
//API URL
$url = $api . 'terceros/datos/res/actualizar/entrega_compra';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$payload = json_encode($entregas);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
print_r(json_decode($result, true));
