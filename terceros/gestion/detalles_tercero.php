<?php
session_start();
if (!isset($_SESSION['otro'])) {
    echo '<script>window.location.replace("../../index.php");</script>';
    exit();
}
include '../../set/conexion.php';
$cc_nit = $_SESSION['cc_nit'];
//API URL
$url = $api . 'terceros/datos/res/lista/' . $cc_nit;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$tercero = json_decode($result, true);
//API URL
$url = $api . 'terceros/datos/res/lista/docs/' . $cc_nit;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$docs = json_decode($result, true);
if ($docs === '0') {
    $docs = [
        ['fec_vig' => '']
    ];
}
//API URL
$url = $api . 'terceros/datos/res/listar/tipo/docs';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$tipo = json_decode($result, true);
//API URL
$url = $api . 'terceros/datos/res/listar/empresas';
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$empresas = json_decode($result, true);

//API URL
$id_terc = $_SESSION['id_otro'];
$url = $api . 'terceros/datos/res/listar/emprxter/' . $id_terc;
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$empxtercero = json_decode($result, true);

?>
<!DOCTYPE html>
<html lang="es">
<?php include '../../set/head.php' ?>

<body class="sb-nav-fixed">
    <?php include '../../set/navsuperior.php' ?>
    <script type="text/javascript" src="/terceros/js/jquery.min.js"></script>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid p-0">
                    <div class="card mb-4">
                        <div class="card-header" id="divTituloPag">
                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fas fa-address-book fa-lg" style="color: #07CF74;"></i>
                                    DETALLES TERCERO
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="divCuerpoPag" style="min-height: 77vh;">
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header card-header-detalles py-0 headings" id="headingOne">
                                        <h5 class="mb-0">
                                            <a class="btn btn-link-acordeon collapsed" data-toggle="collapse" data-target="#datosperson" aria-expanded="true" aria-controls="collapseOne">
                                                <div class="form-row">
                                                    <div class="div-icono">
                                                        <span class="far fa-address-book fa-lg" style="color: #3498DB;"></span>
                                                    </div>
                                                    <div>
                                                        DATOS PERSONALES
                                                    </div>
                                                </div>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="datosperson" class="collapse show" aria-labelledby="headingOne">
                                        <div class="card-body">
                                            <div class="shadow detalles-empleado">
                                                <div class="row">
                                                    <input type="hidden" id="id_tercero" value="<?php echo $tercero[0]['id_tercero'] ?>">
                                                    <div class="div-mostrar bor-top-left col-md-2">
                                                        <label class="lbl-mostrar">C.C. y/o NIT</label>
                                                        <div class="div-cont"><?php echo $tercero[0]['cc_nit'] ?></div>
                                                    </div>
                                                    <div class="div-mostrar col-md-5">
                                                        <label class="lbl-mostrar">NOMBRE COMPLETO</label>
                                                        <div class="div-cont"><?php echo mb_strtoupper($tercero[0]['nombre1'] . ' ' . $tercero[0]['nombre2'] . ' ' . $tercero[0]['apellido1'] . ' ' . $tercero[0]['apellido2']) ?></div>
                                                    </div>
                                                    <div class="div-mostrar bor-top-right col-md-5">
                                                        <label class="lbl-mostrar">RAZÓN SOCIAL</label>
                                                        <div class="div-cont"><?php echo mb_strtoupper($tercero[0]['razon_social'] ? $tercero[0]['razon_social'] : 'no se registró razón social') ?></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="div-mostrar  col-md-2">
                                                        <label class="lbl-mostrar">GENERO</label>
                                                        <div class="div-cont"><?php echo $tercero[0]['genero'] ?></div>
                                                    </div>
                                                    <div class="div-mostrar  col-md-3">
                                                        <label class="lbl-mostrar">TIPO</label>
                                                        <div class="div-cont"></div>
                                                    </div>
                                                    <div class="div-mostrar  col-md-3">
                                                        <label class="lbl-mostrar">ESTADO</label>
                                                        <div class="div-cont"></div>
                                                    </div>
                                                    <div class="div-mostrar  col-md-2">
                                                        <label class="lbl-mostrar">FECHA DE NACIMIENTO</label>
                                                        <div class="div-cont"><?php echo $tercero[0]['fec_nacimiento'] ?></div>
                                                    </div>
                                                    <div class="div-mostrar  col-md-2">
                                                        <label class="lbl-mostrar">FECHA INICIO</label>
                                                        <div class="div-cont"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="div-mostrar bor-bottom-left col-md-4">
                                                        <label class="lbl-mostrar">CORREO</label>
                                                        <div class="div-cont"><?php echo $tercero[0]['correo'] ?></div>
                                                    </div>
                                                    <div class="div-mostrar col-md-2">
                                                        <label class="lbl-mostrar">DEPARTAMENTO</label>
                                                        <div class="div-cont"><?php echo mb_strtoupper($tercero[0]['nombre_dpto']) ?>
                                                        </div>
                                                    </div>
                                                    <div class="div-mostrar col-md-2">
                                                        <label class="lbl-mostrar">MUNICIPIO</label>
                                                        <div class="div-cont"><?php echo mb_strtoupper($tercero[0]['nom_municipio']) ?>
                                                        </div>
                                                    </div>
                                                    <div class="div-mostrar col-md-2">
                                                        <label class="lbl-mostrar">DIRECCIÓN</label>
                                                        <div class="div-cont"><?php echo mb_strtoupper($tercero[0]['direccion']) ?></div>
                                                    </div>
                                                    <div class="div-mostrar bor-bottom-right col-md-2">
                                                        <label class="lbl-mostrar">CONTACTO</label>
                                                        <div class="div-cont"><?php echo $tercero[0]['telefono'] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- parte-->
                                <div class="card">
                                    <div class="card-header card-header-detalles py-0 headings" id="empresas">
                                        <h5 class="mb-0">
                                            <a class="btn btn-link-acordeon collapsed" data-toggle="collapse" data-target="#collapseEmpresa" aria-expanded="true" aria-controls="collapseEmpresa">
                                                <div class="form-row">
                                                    <div class="div-icono">
                                                        <span class="fas fa-city fa-lg" style="color: #2ECC71;"></span>
                                                    </div>
                                                    <div>
                                                        EMPRESAS
                                                    </div>
                                                    <div class="ml-auto mr-0 mr-md-3 my-2 my-md-0 con-icon" id="notif_gral">

                                                    </div>

                                                </div>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseEmpresa" class="collapse" aria-labelledby="empresas">
                                        <div class="card-body">
                                            <div id="accordion">
                                                <?php
                                                foreach ($empxtercero as $ext) {
                                                    $key = array_search($ext['nit'], array_column($empresas, 'nit'));
                                                    if (false !== $key) {
                                                        $id_empresa = $empresas[$key]['id_empresa'];
                                                ?>
                                                        <!-- parte-->
                                                        <div class="card">
                                                            <div class="card-header card-header-detalles py-0 headings" id="<?php echo 'empresa' . $id_empresa ?>">
                                                                <h5 class="mb-0">
                                                                    <a class="btn btn-link-acordeon collapsed" data-toggle="collapse" data-target="#collapseEmpresa<?php echo $id_empresa ?>" aria-expanded="true" aria-controls="collapseEmpresa<?php echo $id_empresa ?>">
                                                                        <div class="form-row">
                                                                            <div class="div-icono">
                                                                                <span class="fas fa-building fa-lg" style="color: #EC7063;"></span>
                                                                            </div>
                                                                            <div>
                                                                                <?php echo $empresas[$key]['nombre'] . ' ' . $empresas[$key]['nit'] . '-' . $empresas[$key]['dig_ver'] ?>
                                                                            </div>
                                                                            <div class="ml-auto mr-0 mr-md-3 my-2 my-md-0 con-icon" id="notif_cot">

                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </h5>
                                                            </div>
                                                            <div id="collapseEmpresa<?php echo $id_empresa ?>" class="collapse" aria-labelledby="empresa<?php echo $id_empresa ?>">
                                                                <div class="card-body">
                                                                    <div id="accordion">
                                                                        <!-- parte-->
                                                                        <div class="card">
                                                                            <div class="card-header card-header-detalles py-0 headings" id="<?php echo 'cotEmp' . $id_empresa ?>">
                                                                                <h5 class="mb-0">
                                                                                    <a class="btn btn-link-acordeon collapsed" data-toggle="collapse" data-target="#collapseCotEmp<?php echo $id_empresa ?>" aria-expanded="true" aria-controls="collapseCotEmp<?php echo $id_empresa ?>">
                                                                                        <div class="form-row">
                                                                                            <div class="div-icono">
                                                                                                <span class="fas fa-list-ul fa-lg" style="color: #F1C40F;"></span>
                                                                                            </div>
                                                                                            <div>
                                                                                                COTIZACIONES
                                                                                            </div>
                                                                                            <?php
                                                                                            //API URL
                                                                                            $cotiz = $_SESSION['id_otro'] . '|' . $empresas[$key]['nit'];
                                                                                            $url = $api . 'terceros/datos/res/listar/cotizaciones/' . $cotiz;
                                                                                            $ch = curl_init($url);
                                                                                            //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                                                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                                                                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                                            $result = curl_exec($ch);
                                                                                            curl_close($ch);
                                                                                            $cotizaciones = json_decode($result, true);
                                                                                            $num_cot = 0;
                                                                                            if ($cotizaciones != 0) {
                                                                                                foreach ($cotizaciones as $cot) {
                                                                                                    if ($cot['estado'] == 1) {
                                                                                                        $num_cot++;
                                                                                                    }
                                                                                                }
                                                                                            } ?>
                                                                                            <div class="ml-auto mr-0 mr-md-3 my-2 my-md-0 con-icon">
                                                                                                <span class="fas fa-bell<?php echo $num_cot == 0 ? '-slash' : '' ?> fa-lg" style="color:<?php echo $num_cot == 0 ? '#D5D8DC' : '#5DADE2' ?> ;"></span>
                                                                                                <?php if ($num_cot > 0) { ?>
                                                                                                    <script type="text/javascript">
                                                                                                        var newSpan = document.createElement("span");
                                                                                                        newSpan.classList.add('fas', 'fa-circle', 'fa-xs');
                                                                                                        newSpan.style.color = 'red';
                                                                                                        newSpan.setAttribute('title', 'Nuevas cotizaciones');
                                                                                                        var contenedor = document.getElementById("notif_gral");
                                                                                                        contenedor.appendChild(newSpan);
                                                                                                    </script>
                                                                                                    <script type="text/javascript">
                                                                                                        var newSpan = document.createElement("span");
                                                                                                        newSpan.classList.add('fas', 'fa-circle', 'fa-xs');
                                                                                                        newSpan.style.color = 'red';
                                                                                                        newSpan.setAttribute('title', 'Nuevas cotizaciones');
                                                                                                        var contenedor = document.getElementById("notif_cot");
                                                                                                        contenedor.appendChild(newSpan);
                                                                                                    </script>
                                                                                                    <div class="txt-over">
                                                                                                        <?php echo $num_cot > 99 ? '99+' : $num_cot ?>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </h5>
                                                                            </div>
                                                                            <div id="collapseCotEmp<?php echo $id_empresa ?>" class="collapse" aria-labelledby="cotEmp<?php echo $id_empresa ?>">
                                                                                <div class="card-body">
                                                                                    <?php
                                                                                    if ($cotizaciones != 0) {
                                                                                    ?>
                                                                                        <table class="table table-striped table-bordered table-sm nowrap table-hover shadow tableCotizaciones" style="width:100%">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th># Cotización</th>
                                                                                                    <th>Descripción</th>
                                                                                                    <th>Estado</th>
                                                                                                    <th>Acciones</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody class="modificarCotizaciones">
                                                                                                <?php
                                                                                                foreach ($cotizaciones as $cot) {
                                                                                                ?>
                                                                                                    <tr>
                                                                                                        <td>COT-<?php echo $cot['id_cot'] ?></td>
                                                                                                        <td><?php echo $cot['objeto'] ?></td>
                                                                                                        <?php
                                                                                                        $btnDetalle = null;
                                                                                                        $estad = 0;
                                                                                                        $color_est = '';
                                                                                                        switch ($cot['estado']) {
                                                                                                            case 1:
                                                                                                                $estad = 'PENDIENTE';
                                                                                                                $btnDetalle = '<div class="center-block"><a value="' . $cotiz . '|' . $cot['id_cot'] . '|' . $cot['id_cot_ter'] . '" class="btn btn-outline-warning btn-sm btn-circle shadow-gb detalle" title="Detalles"><span class="fas fa-eye fa-lg"></span></a></div>';
                                                                                                                $color_est = 'cell-orange';
                                                                                                                break;
                                                                                                            case 2:
                                                                                                                $estad = 'ENVIADA';
                                                                                                                $btnDetalle = '<div class="center-block"><a value="' . $cotiz . '|' . $cot['id_cot'] . '" class="btn btn-outline-info btn-sm btn-circle shadow-gb informacion" title="Información"><span class="fas fa-info fa-lg"></span></a></div>';
                                                                                                                $color_est = 'cell-green';
                                                                                                                break;
                                                                                                        }
                                                                                                        ?>
                                                                                                        <td class="<?php echo $color_est ?>">
                                                                                                            <?php echo $estad ?>
                                                                                                        </td>
                                                                                                        <td><?php echo $btnDetalle ?></td>
                                                                                                    </tr>
                                                                                                <?php
                                                                                                }
                                                                                                ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <div class="p-3 mb-2 bg-warning text-white">NO HAY COTIZACIONES DISPONIBLES</div>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!--parte-->
                                                                        <div class="card">
                                                                            <div class="card-header card-header-detalles py-0 headings" id="headingContrato">
                                                                                <h5 class="mb-0">
                                                                                    <a class="btn btn-link-acordeon collapsed" data-toggle="collapse" data-target="#collapseContrato" aria-expanded="true" aria-controls="collapseContrato">
                                                                                        <div class="form-row">
                                                                                            <div class="div-icono">
                                                                                                <span class="fas fa-file-signature fa-lg" style="color: #29B6F6;"></span>
                                                                                            </div>
                                                                                            <div>
                                                                                                2. CONTRATOS.
                                                                                            </div>
                                                                                            <?php
                                                                                            //API URL
                                                                                            $contra = $_SESSION['id_otro'] . '|' . $empresas[$key]['nit'];
                                                                                            $url = $api . 'terceros/datos/res/listar/contratos/' . $contra;
                                                                                            $ch = curl_init($url);
                                                                                            //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                                                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                                                                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                                            $result = curl_exec($ch);
                                                                                            curl_close($ch);
                                                                                            $contratos = json_decode($result, true);
                                                                                            $num_contr = 0;
                                                                                            if ($contratos != 0) {
                                                                                                foreach ($contratos as $ct) {
                                                                                                    if ($ct['estado'] == 1) {
                                                                                                        $num_contr++;
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                            <div class="ml-auto mr-0 mr-md-3 my-2 my-md-0 con-icon">
                                                                                                <span class="fas fa-bell<?php echo $num_contr == 0 ? '-slash' : '' ?> fa-lg" style="color:<?php echo $num_contr == 0 ? '#D5D8DC' : '#5DADE2' ?> ;"></span>
                                                                                                <?php if ($num_contr > 0) { ?>
                                                                                                    <script type="text/javascript">
                                                                                                        var newSpan = document.createElement("span");
                                                                                                        newSpan.classList.add('fas', 'fa-circle', 'fa-xs');
                                                                                                        newSpan.style.color = 'orange';
                                                                                                        newSpan.setAttribute('title', 'Nuevos contratos');
                                                                                                        var contenedor = document.getElementById("notif_gral");
                                                                                                        contenedor.appendChild(newSpan);
                                                                                                    </script>
                                                                                                    <script type="text/javascript">
                                                                                                        var newSpan = document.createElement("span");
                                                                                                        newSpan.classList.add('fas', 'fa-circle', 'fa-xs');
                                                                                                        newSpan.style.color = 'orange';
                                                                                                        newSpan.setAttribute('title', 'Nuevos contratos');
                                                                                                        var contenedor = document.getElementById("notif_cot");
                                                                                                        contenedor.appendChild(newSpan);
                                                                                                    </script>
                                                                                                    <div class="txt-over">
                                                                                                        <?php echo $num_contr > 99 ? '99+' : $num_contr ?>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </h5>
                                                                            </div>
                                                                            <div id="collapseContrato" class="collapse" aria-labelledby="headingContrato">
                                                                                <div class="card-body">
                                                                                    <?php
                                                                                    if ($contratos != 0) {
                                                                                    ?>
                                                                                        <table class="table table-striped table-bordered table-sm nowrap table-hover shadow tableContratos" style="width:100%">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th># Contrato</th>
                                                                                                    <th># Cotización</th>
                                                                                                    <th>Descripción</th>
                                                                                                    <th>Estado</th>
                                                                                                    <th>Contrato</th>
                                                                                                    <th>Acciones</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody class="modificarContratos">
                                                                                                <?php
                                                                                                foreach ($contratos as $ct) {
                                                                                                ?>
                                                                                                    <tr>
                                                                                                        <td>CC-<?php echo $ct['id_contrato'] ?></td>
                                                                                                        <td>COT-<?php echo $ct['id_compra'] ?></td>
                                                                                                        <td><?php echo $ct['objeto'] ?></td>
                                                                                                        <?php
                                                                                                        $btnDetalle = null;
                                                                                                        $estad = 0;
                                                                                                        $color_est = '';
                                                                                                        switch ($ct['estado']) {
                                                                                                            case 1:
                                                                                                                $estad = 'RECIBIDO';
                                                                                                                $btnDetalle = '<div class="center-block"><a value="' . $ct['id_c'] . '" class="btn btn-outline-success btn-sm btn-circle shadow-gb enviar" title="Enviar Contrato"><span class="fas fa-share-square fa-lg"></span></a></div>';
                                                                                                                $color_est = 'cell-orange';
                                                                                                                break;
                                                                                                            case 2:
                                                                                                                $estad = 'ENVIADO';
                                                                                                                $btnDetalle = '<div class="center-block"><a value="' .  $ct['id_c'] . '" class="btn btn-outline-info btn-sm btn-circle shadow-gb informacion" title="Información"><span class="fas fa-info fa-lg"></span></a></div>';
                                                                                                                $color_est = 'cell-green';
                                                                                                                break;
                                                                                                        }
                                                                                                        ?>
                                                                                                        <td class="<?php echo $color_est ?>">
                                                                                                            <?php echo $estad ?>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <div class="center-block">
                                                                                                                <a value="<?php echo  $ct['id_c'] . '|' . $ct['id_contrato'] ?>" class="btn btn-outline-danger btn-sm btn-circle shadow-gb descargar" title="Descargar contrato">
                                                                                                                    <span class="fas fa-file-pdf fa-lg"></span>
                                                                                                                </a>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                        <td><?php echo $btnDetalle ?></td>
                                                                                                    </tr>
                                                                                                <?php
                                                                                                }
                                                                                                ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <div class="p-3 mb-2 bg-warning text-white">NO HAY CONTRATOS DISPONIBLES</div>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    } else { ?>
                                                        <div class="p-3 mb-2 bg-warning text-white">AUN NO POSEÉ VÍNCULO CON NINGUNA EMPRESA</div>
                                                    <?php
                                                    }
                                                    ?>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- parte-->
                                <div class="card">
                                    <div class="card-header card-header-detalles py-0 headings" id="documentos">
                                        <h5 class="mb-0">
                                            <a class="btn btn-link-acordeon collapsed" data-toggle="collapse" data-target="#collapseDocs" aria-expanded="true" aria-controls="collapseDocs">
                                                <div class="form-row">
                                                    <div class="div-icono">
                                                        <span class="fas fa-copy fa-lg" style="color: #3498DB;"></span>
                                                    </div>
                                                    <div>
                                                        DOCUMENTOS
                                                    </div>
                                                </div>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseDocs" class="collapse" aria-labelledby="documentos">
                                        <div class="card-body">
                                            <div class="row pb-3 px-3">
                                                <?php
                                                foreach ($tipo as $t) {
                                                    $key = array_search($t['id_doc'], array_column($docs, 'id_tipo_doc'));
                                                    $color = false !== $key ? 'success' : 'danger';
                                                    if ($color === 'success' && $docs[$key]['fec_vig'] <= date('Y-m-d')) {
                                                        $color = 'secondary';
                                                    }
                                                ?>
                                                    <div class="bg-<?php echo $color ?> text-white col-2 border border-light shadow-gb"><?php echo $t['descripcion'] ?></div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <table id="tableDocumento" class="table table-striped table-bordered table-sm nowrap table-hover shadow" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo Documento</th>
                                                        <th>Fecha Inicio</th>
                                                        <th>Fecha Vigencia</th>
                                                        <th>Vigente</th>
                                                        <th>Documento</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="modificarDocs">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- parte-->
                                <div class="card">
                                    <div class="card-header card-header-detalles py-0 headings" id="resposabilidad">
                                        <h5 class="mb-0">
                                            <a class="btn btn-link-acordeon collapsed" data-toggle="collapse" data-target="#collapseRespEcon" aria-expanded="true" aria-controls="collapseRespEcon">
                                                <div class="form-row">
                                                    <div class="div-icono">
                                                        <span class="fas fa-hand-holding-usd fa-lg" style="color: #7D3C98;"></span>
                                                    </div>
                                                    <div>
                                                        RESPOSABILIDADES ECONÓMICAS
                                                    </div>
                                                </div>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseRespEcon" class="collapse" aria-labelledby="resposabilidad">
                                        <div class="card-body">
                                            <div>
                                                <table id="tableRespEcon" class="table table-striped table-bordered table-sm nowrap table-hover shadow" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Código</th>
                                                            <th>Descripción</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="modificarRespEcons">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- parte-->
                                <div class="card">
                                    <div class="card-header card-header-detalles py-0 headings" id="actvidades">
                                        <h5 class="mb-0">
                                            <a class="btn btn-link-acordeon collapsed" data-toggle="collapse" data-target="#collapseActvEcon" aria-expanded="true" aria-controls="collapseAtcvEcon">
                                                <div class="form-row">
                                                    <div class="div-icono">
                                                        <span class="fas fa-donate fa-lg" style="color: #F39C12;"></span>
                                                    </div>
                                                    <div>
                                                        ACTIVIDADES ECONÓMICAS
                                                    </div>
                                                </div>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseActvEcon" class="collapse" aria-labelledby="actividad">
                                        <div class="card-body">
                                            <table id="tableActvEcon" class="table table-striped table-bordered table-sm nowrap table-hover shadow" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Código CIIU</th>
                                                        <th>Descripción</th>
                                                        <th>Fecha Inicio</th>
                                                        <th>Estado</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="modificarActvEcons">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php include '../../set/alerts.php'; ?>
    </div>
    <?php include '../../set/scripts.php'; ?>
    <?php include '../../set/footer.php' ?>
</body>

</html>