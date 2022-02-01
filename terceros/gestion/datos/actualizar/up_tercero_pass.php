<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../../../index.php");</script>';
    exit();
}
include('../../../../set/conexion.php');
$idTercero = $_SESSION['id_otro'];
?>
<div class="px-0">
    <div class="shadow">
        <div class="card-header" style="background-color: #16a085 !important;">
            <h6 style="color: white;">CAMBIAR CONTRASEÑA</h6>
        </div>
        <form id="formActuPass">
            <input type="text" id="idTercero" name="idTercero" value="<?php echo $idTercero ?>" hidden>
            <div class="form-row px-4 pt-2">
                <div class="form-group col-md-12">
                    <label for="passContAct" class="small">CONTRASEÑA ACTUAL</label>
                    <input type="password" class="form-control form-control-sm" id="passContAct" name="passContAct" placeholder="Actual">
                    <div id="epassContAct" class="invalid-tooltip">
                        Ingresar contraseña actual
                    </div>
                </div>

            </div>
            <div class="form-row px-4 pt-2">
                <div class="form-group col-md-12">
                    <label for="passNewCont" class="small">NUEVA CONTRASEÑA</label>
                    <input type="password" class="form-control form-control-sm" id="passNewCont" name="passNewCont" placeholder="Nueva">
                    <div id="epassNewCont" class="invalid-tooltip">
                        Ingresar contraseña nueva
                    </div>
                </div>

            </div>
            <div class="form-row px-4 pt-2">
                <div class="form-group col-md-12">
                    <label for="passNewContRep" class="small">REPETIR NUEVA CONTRASEÑA</label>
                    <input type="password" class="form-control form-control-sm" id="passNewContRep" name="passNewContRep" placeholder="Repetir">
                    <div id="epassNewContRep" class="invalid-tooltip">
                        Repetir contraseña nueva
                    </div>
                </div>

            </div>
            <div class="text-center pb-3">
                <button class="btn btn-primary btn-sm" id="btnUpPassT">Actualizar</button>
                <a type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> Cancelar</a>
            </div>
        </form>
    </div>
</div>