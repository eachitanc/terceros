<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include '../../../set/conexion.php';
$idter = $_POST['idt'];
$actpass = $_POST['actpass'];
$newpass = $_POST['pass'];
$iduser = $_SESSION['id_otro'];
$tipuser = 'otro';
//API URL
$url =$api.'terceros/datos/res/datos/id/' . $idter;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$tercero = json_decode($result, true);
if ($tercero[0]['password'] === $actpass) {
    //API URL
    $url =$api.'terceros/datos/res/modificar/pass';
    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = [
        "newpass" => $newpass,
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
} else {
    echo 'Contraseña actual Incorrecta';
}
