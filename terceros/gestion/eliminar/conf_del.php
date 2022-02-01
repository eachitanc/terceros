<?php

session_start();
if (!isset($_SESSION['otro'])) {
        echo '<script>window.location.replace("../../../index.php");</script>';
        exit();
}
include('../../../set/conexion.php');
$id = $_POST['id'];
$tip = $_POST['tip'];
$_SESSION['del'] = $id;
$res['msg'] = "<div class='text-center'>¿Seguro que desea eliminar este registro?</div>";
$res['btns'] = '<button type="submit" class="btn btn-primary btn-sm" id="btnConfirDel' . $tip . '">Aceptar</button>
        <button type="button" class="btn btn-danger btn-sm"  data-dismiss="modal">Cancelar</button>';
echo json_encode($res);