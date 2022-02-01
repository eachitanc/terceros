<?php
session_start();
include 'conexion.php';
$res = array();
$usuario = $_POST['user'];
$contrasena = ($_POST['pass']);
//API URL
$url = $api . 'terceros/datos/res/login/' . $usuario;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$tercero = json_decode($result, true);
if ($tercero != 0) {
    if ($tercero['cc_nit'] === $usuario && $tercero['password'] === $contrasena) {
        $_SESSION['id_otro'] = $tercero['id_tercero'];
        $_SESSION['otro'] = $tercero['nombre1'];
        $_SESSION['cc_nit'] = $tercero['cc_nit'];
        $res['mensaje'] = 1;
    } else {
        $res['mensaje'] = 0;
    }
} else {
    $res['mensaje']  = 'Usuario no registrado en el sistema';
}
echo json_encode($res);
