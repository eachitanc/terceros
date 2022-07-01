<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include '../../../set/conexion.php';
if (isset($_FILES['fileDocCt'])) {
    $id_cd = $_POST['id_contrato_d'];
    $tipodoc = $_POST['slcTipoDoc'];
    $tipodoc_otro = $_POST['txtCual'];
    $iduser = $_SESSION['id_otro'];
    $tipuser = 'otro';
    $nom_archivo = $tipodoc . '_' . date('YmdGis') . '_' . $_FILES['fileDocCt']['name'];
    $nom_archivo = strlen($nom_archivo) >= 101 ? substr($nom_archivo, 0, 100) : $nom_archivo;
    $temporal = file_get_contents($_FILES['fileDocCt']['tmp_name']);
    $temporal = base64_encode($temporal);
    //API URL
    $url = $api . 'terceros/datos/res/nuevo/doc_soporte_contrato';
    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = [
        "id_cd" => $id_cd,
        "tipodoc" => $tipodoc,
        "otro" => $tipodoc_otro,
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
