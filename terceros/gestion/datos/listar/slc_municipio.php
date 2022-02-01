<?php

session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$id_dpto = $_POST['dpto'];
$res = "";
//API URL
$url = $api . 'terceros/datos/res/municipios/' . $id_dpto;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$municipios = json_decode($result, true);
if ($municipios !== '0') {
    $res .= '<option value="0">--Elegir Municipio--</option>';
    foreach ($municipios as $m) {
        $res .= '<option value="' . $m['id_municipio'] . '">' . $m['nom_municipio'] . '</option>';
    }
}

echo $res;
