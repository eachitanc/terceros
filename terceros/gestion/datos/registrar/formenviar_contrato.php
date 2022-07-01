<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
$id_contrato = $_POST['id'];
?>
<div class="px-0">
    <div class="shadow">
        <div class="card-header" style="background-color: #16a085 !important;">
            <h5 style="color: white;">ENVIAR CONTRATO</h5>
        </div>
        <form id="formEnviarContrato">
            <input type="hidden" id="id_contrato_rec" value="<?php echo $id_contrato ?>">
            <div class="form-row px-4 pt-2">
                <div class="form-group col-md-12">
                    <label for="fileContrato" class="small">SELECIONAR UN ARCHIVO</label>
                    <input type="file" class="form-control-file border" name="fileContrato" id="fileContrato">
                </div>
            </div>
            <div class="form-row px-4 pt-2">
                <div class="text-center pb-3">
                    <button class="btn btn-primary btn-sm" id="btnSubirContrato">Enviar</button>
                    <a type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>