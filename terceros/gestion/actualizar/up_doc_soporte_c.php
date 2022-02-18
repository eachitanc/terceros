<?php
session_start();
if (!isset($_SESSION['id_otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include('../../../set/conexion.php');
$iddoc = $_POST['id_doc'];
$idtipdoc = $_POST['slcTipoDoc'];
$otro = $_POST['txtCual'];
$iduser = $_SESSION['id_otro'];
$tipuser = 'otro';
$nom_archivo = isset($_FILES['fileDocCt']['name']) ? $_FILES['fileDocCt']['name'] : '';
$temporal = isset($_FILES['fileDocCt']['tmp_name']) ? file_get_contents($_FILES['fileDocCt']['tmp_name']) : '';
$temporal = base64_encode($temporal);
//API URL
$url = $api . 'terceros/datos/res/modificar/documento_soporte';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$data = [
    'iddoc' => $iddoc,
    'idtipdoc' => $idtipdoc,
    'otro' => $otro,
    'nom_archivo' => $nom_archivo,
    'iduser' => $iduser,
    'tipuser' => $tipuser,
    'temporal' => $temporal,
];
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
