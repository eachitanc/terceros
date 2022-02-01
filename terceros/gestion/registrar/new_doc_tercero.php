<?php
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include '../../../set/conexion.php';
if (isset($_FILES['fileDoc'])) {
    $idt = $_POST['idTercero'];
    $tipodoc = $_POST['slcTipoDocs'];
    $fini = date('Y-m-d', strtotime($_POST['datFecInicio']));
    $fvig = date('Y-m-d', strtotime($_POST['datFecVigencia']));
    $iduser = isset($_SESSION['user']) ? $_SESSION['id_user'] : $_SESSION['id_otro'];
    $tipuser = isset($_SESSION['user']) ? 'user' : 'otro';
    $date = new DateTime('now', new DateTimeZone('America/Bogota'));
    $nom_archivo = $tipodoc . '_' . date('YmdGis') . '_' . $_FILES['fileDoc']['name'];
    $nom_archivo = strlen($nom_archivo) >= 101 ? substr($nom_archivo, 0, 100) : $nom_archivo;
    $temporal = file_get_contents($_FILES['fileDoc']['tmp_name']);
    $temporal = base64_encode($temporal);
    //API URL
    $url =$api.'terceros/datos/res/nuevo/documento';
    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = [
        "idt" => $idt,
        "tipodoc" => $tipodoc,
        "fini" => $fini,
        "fvig" => $fvig,
        "iduser" => $iduser,
        "tipuser" => $tipuser,
        "nom_archivo" => $nom_archivo,
        "temporal" => $temporal,
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
    echo 'No se ha adjuntado ningún archivo';
}
