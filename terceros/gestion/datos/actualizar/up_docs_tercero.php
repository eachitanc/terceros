<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$idDoc = $_POST['idD'];

//API URL
$url =$api.'terceros/datos/res/listar/tipo/docs';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$tipo_docs = json_decode($result, true);

//API URL
$url =$api.'terceros/datos/res/lista/documento/'.$idDoc;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$docs = json_decode($result, true);
?>
<div class="px-0">
    <div class="shadow">
        <div class="card-header" style="background-color: #16a085 !important;">
            <h5 style="color: white;">ACTUALIZAR CARGAR DOCUMENTOS</h5>
        </div>
        <form id="formAddDocsTercero" enctype="multipart/form-data">
            <input type="number" id="id_ter" name="id_ter" value="<?php echo $docs['id_tercero'] ?>" hidden>
            <input type="text" id="nom_archivo" name="nom_archivo" value="<?php echo $docs['nombre_doc'] ?>" hidden>
            <input type="number" id="id_doscter" name="id_doscter" value="<?php echo $idDoc ?>" hidden>
            <div class="form-row px-4 pt-2">
                <input type="hidden" name="idTipoDoc" id="idTipoDoc" value="<?php echo $docs['id_tipo_doc'] ?>">
                <input type="hidden" name="nomTipoDoc" id="nomTipoDoc" value="<?php echo $docs['nombre_doc'] ?>">
                <div class="form-group col-md-4">
                    <label for="slcTipoDocs" class="small">Tipo</label>
                    <select id="slcTipoDocs" name="slcTipoDocs" class="form-control form-control-sm py-0 sm" aria-label="Default select example">
                        <?php
                        foreach ($tipo_docs as $td) {
                            if ($td['id_doc'] !== $docs['id_tipo_doc']) {
                                echo '<option value="' . $td['id_doc'] . '">' . $td['descripcion'] . '</option>';
                            } else {
                                echo '<option selected value="' . $td['id_doc'] . '">' . $td['descripcion'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="datFecInicio" class="small">FECHA INICIO</label>
                    <input type="date" class="form-control form-control-sm" id="datFecInicio" name="datFecInicio" value="<?php echo $docs['fec_inicio'] ?>">
                    <div id="edatFecInicio" class="invalid-tooltip">
                        Campo obligatorio
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="datFecVigencia" class="small">FECHA VIGENTE</label>
                    <input type="date" class="form-control form-control-sm" id="datFecVigencia" name="datFecVigencia" value="<?php echo $docs['fec_vig'] ?>">
                    <div id="edatFecVigencia" class="invalid-tooltip">
                        Campo obligatorio
                    </div>
                </div>
            </div>
            <div class="form-row px-4 pt-2">
                <div class="form-group col-md-12">
                    <label for="fileDoc" class="small">DOCUMENTO</label>
                    <input type="file" class="form-control-file border" name="fileDoc" id="fileDoc">
                </div>
            </div>
            <div class="text-center pb-3">
                <button class="btn btn-primary btn-sm" id="btnUpDocs">Actualizar</button>
                <a type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> Cancelar</a>
            </div>
            <br>
        </form>
    </div>
</div>