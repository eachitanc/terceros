<nav id="navMenu" class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand sombra-nav" href="<?php echo $_SESSION['urlin'] ?>/terceros/gestion/detalles_tercero.php" title="Inicio"><img class="card-img-top" src="<?php echo $_SESSION['urlin'] ?>/images/logonomina.png" alt="logo"></a>
    <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link sombra-nav" id="home" href="<?php echo $_SESSION['urlin'] ?>/terceros/gestion/detalles_tercero.php" role="button" aria-haspopup="true" aria-expanded="false" title="Inicio"> <i class="fas fa-house-user fa-lg" style="color:#5DADE2;"></i></i></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link sombra-nav" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Opciones usuario">
                <div class="form-group">
                    <i class="fas fa-user-circle fa-lg" style="color: #2ECC71;"></i>
                    <span class="dropdown-toggle"></span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown" style="background-color:#fef5e7">
                <a class="dropdown-item sombra" id="btnUpDataTercero" value="<?php echo $_SESSION['id_otro'] ?>" href="#">Editar perfil</a>
                <a class="dropdown-item sombra" id="hrefCambPass" href="#">Cambiar Contraseña</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item sombra" href="<?php echo $_SESSION['urlin'] . '/set/cerrar_sesion.php' ?>">Cerrar Sesión</a>

            </div>
        </li>
    </ul>
</nav>