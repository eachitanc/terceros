<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
//API URL
$url = $api . 'terceros/datos/res/listar/empresas';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$empresas = json_decode($result, true);
?>
<div class="px-0">
    <div class="shadow">
        <div class="card-header" style="background-color: #16a085 !important;">
            <h5 style="color: white;">GENERAR CERTIFICADOS FORMULARIO 220</h5>
        </div>
        <form id="formGenForm220">
            <div class="pt-2 px-4">
                <div class=" form-row">
                    <div class="form-group col-md-12">
                        <label for="nom_prod" class="small">EMPRESA</label>
                        <select id="slcEmpresa" name="slcEmpresa" class="form-control form-control-sm" required>
                            <option value="0">--Seleccione--</option>
                            <?php
                            foreach ($empresas as $e) {
                                echo '<option value="' . $e['nit'] . '">' . $e['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class=" form-row">
                    <div class="form-group col-md-6">
                        <label for="numAnioCertifica" class="small">AÑO</label>
                        <input type="number" id="numAnioCertifica" name="numAnioCertifica" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="slcTipoCertificado" class="small">TIPO</label>
                        <select id="slcTipoCertificado" name="slcTipoCertificado" class="form-control form-control-sm" required>
                            <option value="0">--Seleccione--</option>
                            <option value="1">Certificado de Ingresos y Retenciones</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row px-4">
                <div class="text-center pb-3">
                    <button class="btn btn-primary btn-sm" id="btnDownCertifForm220">Certificado <span class="fas fa-download"></span></button>
                    <a type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"> Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>