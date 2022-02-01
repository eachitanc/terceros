<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<?php
include 'set/conexion.php';
include 'set/head.php';
?>

<body class="sb-nav-fixed">
    <div id="divFondo" class="container-fluid">
        <div class="row justify-content-center align-items-center minh-100">
            <div class="center-block">
                <div class="card shadow-lg border-0 rounded-lg mt-5" style="width: 23rem;">
                    <div class="card div-gris">
                        <img src="<?php echo $_SESSION['urlin'] ?>/images/logonomina.png" class="card-img-top" alt="Logo">
                    </div>
                    <div class="card-body">
                        <form id="formLogin">
                            <label class="lbl-mostrar mb-1 px-1" for="txtUser">USUARIO</label>
                            <div class="input-group">
                                <input class="form-control py-2" id="txtUser" name="txtUser" type="text" placeholder="Ingresar usuario" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user fa-lg" style="color: #16A085;"></span>
                                    </div>
                                </div>
                            </div>
                            <label class="lbl-mostrar mb-1 pt-4 px-1" for="passuser">CONTRASEÑA</label>
                            <div class="input-group campo">
                                <input class="form-control py-2" id="passuser" name="passuser" type="password" placeholder="Ingresar Contraseña" />
                                <span class="cambiar fas fa-eye" style="color:#2ECC71"></span>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fab fa-expeditedssl fa-lg" style="color: #D35400;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-between mt-4 mb-0">
                                <center><button class="btn btn-primary" id="btnLogin">Iniciar</button></center>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center div-gris">
                        <div class="small">Bienvenid@</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include 'set/alerts.php';
    include 'set/scripts.php';
    ?>
</body>

</html>