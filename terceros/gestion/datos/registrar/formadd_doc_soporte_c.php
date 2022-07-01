<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
$id_contrato = isset($_POST['id_contr']) ? $_POST['id_contr'] : exit('Acción no permitida');
include('../../../../set/conexion.php');
//API URL
$url = $api . 'terceros/datos/res/listar/tipo/docs_contrato';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$tipo_docs = json_decode($result, true);
?>
<div class="px-0">
    <div class="shadow">
        <div class="card-header" style="background-color: #16a085 !important;">
            <h5 style="color: white;">ADJUNTAR DOCUMENTOS SOPORTE DE CONTRATO</h5>
        </div>
        <form id="formAdjDocsCnto">
            <input type="hidden" id="id_devuelto" name="id_devuelto" value="<?php echo $id_contrato ?>">
            <div class="form-row px-4 pt-2">
                <div class="form-group col-md-4">
                    <label for="slcTipoDoc" class="small">TIPO DE ARCHIVO</label>
                    <select id="slcTipoDoc" name="slcTipoDoc" id="slcTipoDoc" class="form-control form-control-sm py-0 sm" aria-label="Default select example">
                        <option value="0">-- Seleccionar --</option>
                        <?php
                        foreach ($tipo_docs as $td) {
                            echo '<option value="' . $td['id_doc_sop'] . '">' . $td['descripcion'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-8">
                    <label for="fileDocCt" class="small">SELECIONAR UN ARCHIVO</label>
                    <input type="file" class="form-control-file border" name="fileDocCt" id="fileDocCt">
                </div>
            </div>
            <div class="form-row px-4" id="divCual" style="display: none;">
                <div class="form-group col-md-4">
                    <label for="txtCual" class="small">¿Cúal?</label>
                    <input type="text" class="form-control form-control-sm" id="txtCual" name="txtCual">
                </div>
            </div>
            <div class="form-row px-4 pt-2">
                <div class="text-center pb-3">
                    <button class="btn btn-primary btn-sm" id="btnDocsSoporteC">Adjuntar</button>
                    <a type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>