<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$idT = $_SESSION['id_otro'];
//API URL
$url = $api . 'terceros/datos/res/lista/responsabilidades';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$responsabilidad = json_decode($result, true);
$error = "Debe diligenciar este campo";
?>
<div class="px-0">
    <div class="shadow">
        <div class="card-header" style="background-color: #16a085 !important;">
            <h5 style="color: white;">REGISTRAR RESPONSABILIDAD ECONÓMICA DE TERCERO</h5>
        </div>
        <form id="formAddRespEcon">
            <input type="number" id="idTercero" name="idTercero" value="<?php echo $idT ?>" hidden>
            <div class="form-row px-4 pt-2">
                <div class="form-group col-md-12">
                    <label for="slcRespEcon" class="small">RESPONSABILIDAD ECONÓMICA</label>
                    <select id="slcRespEcon" name="slcRespEcon" class="form-control form-control-sm py-0 sm" aria-label="Default select example">
                        <option value="0">-- Seleccionar --</option>
                        <?php
                        foreach ($responsabilidad as $re) {
                            echo '<option value="' . $re['id_responsabilidad'] . '">' . $re['codigo'] . ' || ' . $re['descripcion'] . '</option>';
                        }
                        ?>
                    </select>

                </div>
                <div class="text-center pb-3">
                    <button class="btn btn-primary btn-sm" id="btnAddRespEcon">Agregar</button>
                    <a type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> Cancelar</a>
                </div>
        </form>
    </div>
</div>