<?php
session_start();
if (!isset($_SESSION['id_otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include('../../../set/conexion.php');
$id_ter = $_POST['id_ter'];
$iddoc = $_POST['id_doscter'];
$idtipdoc = $_POST['slcTipoDocs'];
$idtdocprueba = $_POST['idTipoDoc'];
$nombre = $_POST['nomTipoDoc'];
$archivo = $_POST['nom_archivo'];
$fecini = date('Y-m-d', strtotime($_POST['datFecInicio']));
$fecvig = date('Y-m-d', strtotime($_POST['datFecVigencia']));
$iduser = $_SESSION['id_otro'];
$tipuser = 'otro';
$nom_archivo = isset($_FILES['fileDoc']['name']) ? $_FILES['fileDoc']['name'] : $archivo;
$temporal = isset($_FILES['fileDoc']['tmp_name']) ? file_get_contents($_FILES['fileDoc']['tmp_name']) : '0';
$temporal = base64_encode($temporal);
if ($idtipdoc !== $idtdocprueba) {
    $partes = explode("_", $nombre);
    $indice = ['0' => $idtipdoc];
    $newname = implode("_", array_replace($partes, $indice));
    $nombre = $newname;
}
//API URL
$url =$api.'terceros/datos/res/modificar/documento';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$data = [
    'id_ter' => $id_ter,
    'iddoc' => $iddoc,
    'idtipdoc' => $idtipdoc,
    'nom_archivo' => $nom_archivo,
    'nombre' => $nombre,
    'archivo' => $archivo,
    'fecini' => $fecini,
    'fecvig' => $fecvig,
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
echo json_decode($result);
