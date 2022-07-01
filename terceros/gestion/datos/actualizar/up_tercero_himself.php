<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include '../../../../set/conexion.php';
$idTercero = $_SESSION['id_otro'];
//API URL
$url = $api . 'terceros/datos/res/datos/id/' . $idTercero;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$tercero = json_decode($result, true);
if ($tercero !== '0') {
    //API URL
    $id_dpto = $tercero[0]['departamento'];
    $url = $api . 'terceros/datos/res/municipios/' . $id_dpto;
    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $municipios = json_decode($result, true);
    //API URL
    $url = $api . 'terceros/datos/res/tipo/identificacion';
    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $tipodoc = json_decode($result, true);
    //API URL
    $url = $api . 'terceros/datos/res/dptos';
    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $dpto = json_decode($result, true);
} else {
    echo 'No hay datos';
    exit();
}
$error = "Debe diligenciar este campo";
?>
<div class="px-0">
    <div class="shadow">
        <div class="card-header" style="background-color: #16a085 !important;">
            <h5 style="color: white;">ACTUALIZAR DATOS DE TERCERO</h5>
        </div>
        <form id="formActualizaTercero">
            <input type="number" id="idTercero" name="idTercero" value="<?php echo $idTercero ?>" hidden>
            <div class="form-row px-4 pt-2">
                <div class="form-group col-md-2">
                    <label for="slcTipoDocEmp" class="small">Tipo de documento</label>
                    <select id="slcTipoDocEmp" name="slcTipoDocEmp" class="form-control form-control-sm py-0 sm" aria-label="Default select example">
                        <?php
                        foreach ($tipodoc as $td) {
                            if ($td['id_tipodoc'] !== $tercero[0]['tipo_doc']) {
                                echo '<option value="' . $td['id_tipodoc'] . '">' . mb_strtoupper($td['descripcion']) . '</option>';
                            } else {
                                echo '<option selected value="' . $td['id_tipodoc'] . '">' . mb_strtoupper($td['descripcion']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="txtCCempleado" class="small">Identificación</label>
                    <input type="number" class="form-control form-control-sm" id="txtCCempleado" name="txtCCempleado" min="1" placeholder="C.C., NIT, etc." value="<?php echo $tercero[0]['cc_nit'] ?>" readonly>
                    <div id="etxtCCempleado" class="invalid-tooltip">
                        <?php echo $error ?>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="slcGenero" class="small">Género</label>
                    <select id="slcGenero" name="slcGenero" class="form-control form-control-sm py-0 sm" aria-label="Default select example">
                        <?php $g = $tercero[0]['genero'] ?>
                        <option <?php echo $g == 'M' ? 'selected' : '' ?> value="M">MASCULINO</option>
                        <option <?php echo $g == 'F' ? 'selected' : '' ?> value="F">FEMENINO</option>
                        <option <?php echo $g == 'NA' ? 'selected' : '' ?> value="NA">NO APLICA</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="datFecNacimiento" class="small">Fecha de Nacimiento</label>
                    <input type="date" class="form-control form-control-sm" id="datFecNacimiento" name="datFecNacimiento" value="<?php echo $tercero[0]['fec_nacimiento'] ?>">
                    <div id="edatFecNacimiento" class="invalid-tooltip">
                        <?php echo $error ?>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="txtRazonSocial" class="small">Razón Social</label>
                    <input type="text" class="form-control form-control-sm" id="txtRazonSocial" name="txtRazonSocial" placeholder="Nombre empresa" value="<?php echo $tercero[0]['razon_social'] ?>">
                </div>
            </div>
            <div class="form-row px-4">
                <div class="form-group col-md-2">
                    <label for="txtNomb1Emp" class="small">Primer nombre</label>
                    <input type="text" class="form-control form-control-sm" id="txtNomb1Emp" name="txtNomb1Emp" placeholder="Nombre" value="<?php echo $tercero[0]['nombre1'] ?>">
                </div>
                <div class="form-group col-md-2">
                    <label for="txtNomb2Emp" class="small">Segundo nombre</label>
                    <input type="text" class="form-control form-control-sm" id="txtNomb2Emp" name="txtNomb2Emp" placeholder="Nombre" value="<?php echo $tercero[0]['nombre2'] ?>">
                </div>
                <div class="form-group col-md-2">
                    <label for="txtApe1Emp" class="small">Primer apellido</label>
                    <input type="text" class="form-control form-control-sm" id="txtApe1Emp" name="txtApe1Emp" placeholder="Apellido" value="<?php echo $tercero[0]['apellido1'] ?>">
                </div>
                <div class="form-group col-md-2">
                    <label for="txtApe2Emp" class="small">Segundo apellido</label>
                    <input type="text" class="form-control form-control-sm" id="txtApe2Emp" name="txtApe2Emp" placeholder="Apellido" value="<?php echo $tercero[0]['apellido2'] ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="slcPaisEmp" class="small">País</label>
                    <select id="slcPaisEmp" name="slcPaisEmp" class="form-control form-control-sm py-0 sm" aria-label="Default select example">
                        <option selected value="1">COLOMBIA</option>;
                    </select>
                </div>
            </div>
            <div class="form-row px-4">
                <div class="form-group col-md-3">
                    <label for="slcDptoEmp" class="small">Departamento</label>
                    <select id="slcDptoEmp" name="slcDptoEmp" class="form-control form-control-sm py-0 sm" aria-label="Default select example">
                        <?php
                        foreach ($dpto as $d) {
                            if ($d['id_dpto'] !== $tercero[0]['departamento']) {
                                echo '<option value="' . $d['id_dpto'] . '">' . $d['nombre_dpto'] . '</option>';
                            } else {
                                echo '<option selected value="' . $d['id_dpto'] . '">' . $d['nombre_dpto'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <div id="eslcDptoEmp" class="invalid-tooltip">
                        <?php echo $error ?>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="slcMunicipioEmp" class="small">Municipio</label>
                    <select id="slcMunicipioEmp" name="slcMunicipioEmp" class="form-control form-control-sm py-0 sm" aria-label="Default select example" placeholder="elegir mes">
                        <?php
                        foreach ($municipios as $m) {
                            if ($tercero[0]['municipio'] !== $m['id_municipio']) {
                                echo '<option value="' . $m['id_municipio'] . '">' . $m['nom_municipio'] . '</option>';
                            } else {
                                echo '<option selected value="' . $m['id_municipio'] . '">' . $m['nom_municipio'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <div id="eslcMunicipioEmp" class="invalid-tooltip">
                        <?php echo $error ?>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="txtDireccion" class="small">Dirección</label>
                    <input type="text" class="form-control form-control-sm" id="txtDireccion" name="txtDireccion" placeholder="Residencial" value="<?php echo $tercero[0]['direccion'] ?>">
                    <div id="etxtDireccion" class="invalid-tooltip">
                        <?php echo $error ?>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="mailEmp" class="small">Correo</label>
                    <input type="email" class="form-control form-control-sm" id="mailEmp" name="mailEmp" placeholder="Correo electrónico" value="<?php echo $tercero[0]['correo'] ?>">
                    <div id="emailEmp" class="invalid-tooltip">
                        <?php echo $error ?>
                    </div>
                </div>
            </div>
            <div class="form-row px-4">
                <div class="form-group col-md-2">
                    <label for="txtTelEmp" class="small">Contacto</label>
                    <input type="text" class="form-control form-control-sm" id="txtTelEmp" name="txtTelEmp" placeholder="Teléfono/celular" value="<?php echo $tercero[0]['telefono'] ?>">
                    <div id="etxtTelEmp" class="invalid-tooltip">
                        <?php echo $error ?>
                    </div>
                </div>
            </div>
            <div class="text-center pb-3">
                <button class="btn btn-primary btn-sm" id="btnUpTercero">Actualizar</button>
                <a type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> Cancelar</a>
            </div>
        </form>
    </div>
</div>