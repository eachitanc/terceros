<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../index.php");</script>';
    exit();
}
include('../../../set/conexion.php');
$idter = $_POST['idTercero'];
$genero = $_POST['slcGenero'];
$fecNacimiento = date('Y-m-d', strtotime($_POST['datFecNacimiento']));
$tipodoc = $_POST['slcTipoDocEmp'];
$cc_nit = $_POST['txtCCempleado'];
$nomb1 = $_POST['txtNomb1Emp'];
$nomb2 = $_POST['txtNomb2Emp'];
$ape1 = $_POST['txtApe1Emp'];
$ape2 = $_POST['txtApe2Emp'];
$razonsoc = $_POST['txtRazonSocial'];
$pais = $_POST['slcPaisEmp'];
$dpto = $_POST['slcDptoEmp'];
$municip = $_POST['slcMunicipioEmp'];
$dir = $_POST['txtDireccion'];
$mail = $_POST['mailEmp'];
$tel = $_POST['txtTelEmp'];
$iduser = $_SESSION['id_otro'];
$tipouser = 'otro';
$nit_act = $_SESSION['cc_nit'];
//API URL
$url =$api.'terceros/datos/res/modificar/tercero/' . $idter;
$ch = curl_init($url);
$data = [
    "slcGenero" => $genero,
    "datFecNacimiento" => $fecNacimiento,
    "slcTipoDocEmp" => $tipodoc,
    "txtCCempleado" => $cc_nit,
    "txtNomb1Emp" => $nomb1,
    "txtNomb2Emp" => $nomb2,
    "txtApe1Emp" => $ape1,
    "txtApe2Emp" => $ape2,
    "txtRazonSocial" => $razonsoc,
    "slcPaisEmp" => $pais,
    "slcDptoEmp" => $dpto,
    "slcMunicipioEmp" => $municip,
    "txtDireccion" => $dir,
    "mailEmp" => $mail,
    "txtTelEmp" => $tel,
    "id_user" => $iduser,
    "tipuser" => $tipouser,
    "nit_emp" => $nit_act
];
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo json_decode($result, true);
