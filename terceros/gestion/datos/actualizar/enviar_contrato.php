<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
if (isset($_FILES['fileContrato'])) {
    $id_contrato_rec = $_POST['id_contrato_rec'];
    $iduser = $_SESSION['id_otro'];
    $tipuser = 'otro';
    $nom_archivo = 'ccd' . '_' . date('YmdGis') . '_' . $_FILES['fileContrato']['name'];
    $nom_archivo = strlen($nom_archivo) >= 101 ? substr($nom_archivo, 0, 100) : $nom_archivo;
    $temporal = file_get_contents($_FILES['fileContrato']['tmp_name']);
    $temporal = base64_encode($temporal);
    //API URL
    $url = $api . 'terceros/datos/res/nuevo/contrato_devolver';
    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = [
        "id_contrato_rec" => $id_contrato_rec,
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
