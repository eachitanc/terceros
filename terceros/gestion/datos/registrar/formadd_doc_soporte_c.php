<?php
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$idT = $_SESSION['id_otro'];
//API URL
$url = $api . 'terceros/datos/res/lista/actividades';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$actividades = json_decode($result, true);
?>
<div class="px-0">
    <div class="shadow">
        <div class="card-header" style="background-color: #16a085 !important;">
            <h5 style="color: white;">ADJUNTAR DOCUMENTOS SOPORTE DE CONTRATO</h5>
        </div>
        <form id="formAddActvEcon">
            <input type="number" id="idTercero" name="idTercero" value="<?php echo $idT ?>" hidden>
            <div class="form-row px-4 pt-2">
                <div class="form-group col-md-10">
                    <label for="slcActvEcon" class="small"></label>
                    <select id="slcActvEcon" name="slcActvEcon" class="form-control form-control-sm py-0 sm" aria-label="Default select example">
                        <option value="0">-- Seleccionar --</option>
                        <?php
                        foreach ($actividades as $a) {
                            echo '<option value="' . $a['id_actividad'] . '">' . $a['codigo_ciiu'] . ' || ' . $a['descripcion'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="datFecInicio" class="small">FECHA INICIO</label>
                    <input type="date" class="form-control form-control-sm" id="datFecInicio" name="datFecInicio">
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary btn-sm" id="btnAddActvEcon">Agregar</button>
                <a type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> Cancelar</a>
            </div>
            <br>
        </form>
    </div>
</div>