(function($) {
    //Superponer modales
    $(document).on('show.bs.modal', '.modal', function() {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
    var showError = function(id) {
        $('#' + id).focus();
        $('#e' + id).show();
        setTimeout(function() {
            $('#e' + id).fadeOut(600);
        }, 800);
    };
    var bordeError = function(p) {
        $('#' + p).css("border", "2px solid #F5B7B1");
        $('#' + p).css('box-shadow', '0 0 4px 3px pink');
    };
    var reloadtable = function(nom) {
        $(document).ready(function() {
            var table = $('#' + nom).DataTable();
            table.ajax.reload();
        });
    };
    var confdel = function(i, t) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: window.urlin + '/terceros/gestion/eliminar/conf_del.php',
            data: { id: i, tip: t }
        }).done(function(res) {
            $('#divModalConfDel').modal('show');
            $('#divMsgConfdel').html(res.msg);
            $('#divBtnsModalDel').html(res.btns);
        });
        return false;
    };
    //Cambiar Municipios por departamento
    $('#divForms').on('change', '#slcDptoEmp', function() {
        let dpto = $(this).val();
        $.ajax({
            type: 'POST',
            url: window.urlin + '/terceros/gestion/datos/listar/slc_municipio.php',
            data: { dpto: dpto },
            success: function(r) {
                $('#slcMunicipioEmp').html(r);
            }
        });
        return false;
    });
    var setIdioma = {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ - _END_ registros de _TOTAL_ ",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ entradas en total )",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Ver _MENU_ Filas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": '<i class="fas fa-search fa-flip-horizontal" style="font-size:1.5rem; color:#2ECC71;"></i>',
        "zeroRecords": "No se encontraron registros",
        "paginate": {
            "first": "&#10096&#10096",
            "last": "&#10097&#10097",
            "next": "&#10097",
            "previous": "&#10096"
        }
    };
    setdom = "<'row'<'col-md-5'l><'bttn-plus-dt col-md-2'B><'col-md-5'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
    $(document).ready(function() {
        let id_t = $('#id_tercero').val();
        //dataTable Resposabilidad Economica
        $('#tableRespEcon').DataTable({
            dom: setdom,
            buttons: [{
                action: function(e, dt, node, config) {
                    $.post("datos/registrar/formadd_resp_economica.php", function(he) {
                        $('#divTamModalForms').removeClass('modal-xl');
                        $('#divTamModalForms').removeClass('modal-sm');
                        $('#divTamModalForms').addClass('modal-lg');
                        $('#divModalForms').modal('show');
                        $("#divForms").html(he);
                        $('#slcRespEcon').focus();
                    });
                }
            }],
            language: setIdioma,
            "ajax": {
                url: 'datos/listar/datos_resp_econ.php',
                type: 'POST',
                data: { id_t: id_t },
                dataType: 'json',
            },
            "columns": [
                { 'data': 'codigo' },
                { 'data': 'descripcion' },
                { 'data': 'estado' },
                { 'data': 'botones' },
            ],
            "order": [
                [0, "asc"]
            ]
        });
        $('#tableRespEcon').wrap('<div class="overflow" />');
        //tabla documento soporte contrato
        let id_contr = $('#id_ct').val();
        $('#tableDocSopContrato').DataTable({
            dom: setdom,
            buttons: [{
                action: function(e, dt, node, config) {
                    $.post("../datos/registrar/formadd_doc_soporte_c.php", { id_contr: id_contr }, function(he) {
                        $('#divTamModalForms').removeClass('modal-xl');
                        $('#divTamModalForms').removeClass('modal-sm');
                        $('#divTamModalForms').addClass('modal-lg');
                        $('#divModalForms').modal('show');
                        $("#divForms").html(he);
                        $('#slcRespEcon').focus();
                    });
                }
            }],
            language: setIdioma,
            "ajax": {
                url: '../datos/listar/datos_docs_soporte_c.php',
                type: 'POST',
                data: { id_contr: id_contr },
                dataType: 'json',
            },
            "columns": [
                { 'data': 'num' },
                { 'data': 'doc' },
                { 'data': 'archivo' },
                { 'data': 'estado' },
                { 'data': 'botones' },
            ],
            "order": [
                [0, "asc"]
            ]
        });
        $('#tableDocSopContrato').wrap('<div class="overflow" />');
        //dataTable Actividad Economica
        $('#tableActvEcon').DataTable({
            dom: setdom,
            buttons: [{
                action: function(e, dt, node, config) {
                    $.post("datos/registrar/formadd_actv_economica.php", function(he) {
                        $('#divTamModalForms').removeClass('modal-lg');
                        $('#divTamModalForms').removeClass('modal-sm');
                        $('#divTamModalForms').addClass('modal-xl');
                        $('#divModalForms').modal('show');
                        $("#divForms").html(he);
                        $('#slcActvEcon').focus();
                    });
                }
            }],
            language: setIdioma,
            "ajax": {
                url: 'datos/listar/datos_actv_econ.php',
                type: 'POST',
                data: { id_t: id_t },
                dataType: 'json',
            },
            "columns": [
                { 'data': 'codigo' },
                { 'data': 'descripcion' },
                { 'data': 'fec_inicio' },
                { 'data': 'estado' },
                { 'data': 'botones' },
            ],
            "order": [
                [0, "asc"]
            ],

        });
        $('#tableActvEcon').wrap('<div class="overflow" />');
        //dataTable Documentos tercero
        $('#tableDocumento').DataTable({
            dom: setdom,
            buttons: [{
                action: function(e, dt, node, config) {
                    $.post("datos/registrar/formadd_docs_tercero.php", function(he) {
                        $('#divTamModalForms').removeClass('modal-xl');
                        $('#divTamModalForms').removeClass('modal-sm');
                        $('#divTamModalForms').addClass('modal-lg')
                        $('#divModalForms').modal('show');
                        $("#divForms").html(he);
                        $('#slcTipoDocs').focus();
                    });
                }
            }],
            language: setIdioma,
            "ajax": {
                url: 'datos/listar/datos_docs.php',
                type: 'POST',
                data: { id_t: id_t },
                dataType: 'json',
            },
            "columns": [
                { 'data': 'tipo' },
                { 'data': 'fec_inicio' },
                { 'data': 'fec_vigencia' },
                { 'data': 'vigente' },
                { 'data': 'doc' },
                { 'data': 'botones' },
            ],
            "order": [
                [0, "asc"]
            ],

        });
        $('.bttn-plus-dt span').html('<span class="icon-dt fas fa-plus-circle fa-lg"></span>');
        $('#tableDocumento').wrap('<div class="overflow" />');
        //dataTable Documentos tercero
        let id_con_super = $('#id_cont_super').val();
        $('#tableDocsContratoSupervisar').DataTable({
            language: setIdioma,
            "ajax": {
                url: '../datos/listar/datos_docs_contrato_supervisar.php',
                type: 'POST',
                data: { id_con_super: id_con_super },
                dataType: 'json',
            },
            "columns": [
                { 'data': 'num' },
                { 'data': 'doc' },
                { 'data': 'archivo' },
                { 'data': 'estado' },
            ],
            "order": [
                [0, "asc"]
            ],

        });
        $('#tableDocsContratoSupervisar').wrap('<div class="overflow" />');
        //dataTable Cotizaciones
        $('.tableCotizaciones').DataTable({
            language: setIdioma,
            "order": [
                [0, "asc"]
            ],

        });
        $('.tableCotizaciones').wrap('<div class="overflow" />');
        //dataTable Cotizaciones
        $('.tableContratos').DataTable({
            language: setIdioma,
            "order": [
                [0, "asc"]
            ],

        });
        $('.tableContratos').wrap('<div class="overflow" />');
        //dataTable detalles Cotizaciones
        $('#tableDetalleCotiza').DataTable({
            language: setIdioma,
            "order": [
                [0, "asc"]
            ],

        });
        $('#tableDetalleCotiza').wrap('<div class="overflow" />');
        //dataTable detalles Cotizaciones
        $('#tableSupervision').DataTable({
            language: setIdioma,
            "order": [
                [0, "asc"]
            ],

        });
        $('#tableSupervision').wrap('<div class="overflow" />');
    });
    $('.cambiar').on('click', function() {
        if ($(this).hasClass('fa-eye')) {
            $('.campo input').attr('type', 'text');
            $(this).removeClass('fa-eye');
            $(this).addClass('fa-eye-slash');
            $(this).css('color', 'red');
        } else {
            $('.campo input').attr('type', 'password');
            $(this).removeClass('fa-eye-slash');
            $(this).addClass('fa-eye');
            $(this).css('color', '#2ECC71');
        }
    });
    //Cambiar contraseña tercero
    $('#hrefCambPass').on('click', function() {
        let idt = $('#id_tercero').val();
        $.post(window.urlin + "/terceros/gestion/datos/actualizar/up_tercero_pass.php", { idt: idt }, function(he) {
            $('#divTamModalForms').removeClass('modal-lg')
            $('#divTamModalForms').removeClass('modal-xl')
            $('#divTamModalForms').addClass('modal-sm')
            $('#divModalForms').modal('show');
            $("#divForms").html(he);
            $('#slcTipoTercero').focus();
        });
    });
    $('#divForms').on('click', '#btnUpPassT', function() {
        let id;
        if ($('#passContAct').val() === '') {
            id = 'passContAct';
            bordeError(id);
            showError(id);
        } else if ($('#passNewCont').val() === '') {
            id = 'passNewCont';
            bordeError(id);
            showError(id);
        } else if ($('#passNewContRep').val() === '') {
            id = 'passNewContRep';
            bordeError(id);
            showError(id);
        } else if ($('#passNewCont').val() !== $('#passNewContRep').val()) {
            $('#divModalError').modal('show');
            $('#divMsgError').html('Las contraseñas no coinciden');
        } else if ($('#passNewCont').val() === $('#passContAct').val()) {
            $('#divModalError').modal('show');
            $('#divMsgError').html('La contraseña nueva es igual a la actual');
        } else {
            let idt = $('#idTercero').val();
            let actpass = $('#passContAct').val();
            let pass = $('#passNewContRep').val();
            actpass = hex_sha512(actpass)
            pass = hex_sha512(pass)
            $.ajax({
                type: 'POST',
                url: window.urlin + '/terceros/gestion/actualizar/up_pass_tercero.php',
                data: { idt: idt, actpass: actpass, pass: pass },
                success: function(r) {
                    if (r === '1') {
                        $('#divModalForms').modal('hide');
                        $('#divModalDone').modal('show');
                        $('#divMsgDone').html('Contraseña Actualizada Correctamente');
                    } else {
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(r);
                    }
                }
            });
        }
        return false;
    });
    //Up Data Himself
    $('#btnUpDataTercero').on('click', function() {
        let idt = $(this).attr('value');
        $.post(window.urlin + "/terceros/gestion/datos/actualizar/up_tercero_himself.php", { idt: idt }, function(he) {
            $('#divTamModalForms').addClass('modal-sm');
            $('#divTamModalForms').addClass('modal-lg');
            $('#divTamModalForms').addClass('modal-xl')
            $('#divModalForms').modal('show');
            $("#divForms").html(he);
            $('#slcTipoTercero').focus();
        });
    });
    $('#divForms').on('click', '#btnUpTercero', function() {
        let id;
        if ($('#datFecInicio').val() === '') {
            id = 'datFecInicio';
            bordeError(id);
            showError(id);
        } else if ($('#datFecNacimiento').val() === '') {
            id = 'datFecNacimiento';
            bordeError(id);
            showError(id);
        } else if ($('#txtCCempleado').val() === '' || parseInt($('#txtCCempleado').val()) < 1) {
            id = 'txtCCempleado';
            bordeError(id);
            showError(id);
        } else if ($('#slcMunicipioEmp').val() === '0') {
            id = 'slcMunicipioEmp';
            bordeError(id);
            showError(id);
        } else if ($('#mailEmp').val() === '') {
            id = 'mailEmp';
            bordeError(id);
            showError(id);
        } else if ($('#txtTelEmp').val() === '') {
            id = 'txtTelEmp';
            bordeError(id);
            showError(id);
        } else {
            let datos = $('#formActualizaTercero').serialize();
            $.ajax({
                type: 'POST',
                url: window.urlin + '/terceros/gestion/actualizar/up_datos_tercero.php',
                data: datos,
                success: function(r) {
                    if (r === '1') {
                        id = 'tableTerceros';
                        reloadtable(id);
                        $('#divModalForms').modal('hide');
                        $('#divModalDone').modal('show');
                        $('#divMsgDone').html('Datos Actualizados Correctamente');
                    } else {
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(r);
                    }
                }
            });
        }
        return false;
    });
    //Agregar Responsabilidad Economica
    $('#divForms').on('click', '#btnAddRespEcon', function() {
        if ($('#slcRespEcon').val() === '0') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('¡Debe seleccionar una Resposabilidad Económica!');
        } else {
            datos = $('#formAddRespEcon').serialize();
            $.ajax({
                type: 'POST',
                url: 'registrar/new_resp_econ.php',
                data: datos,
                success: function(r) {
                    if (r === '1') {
                        let id = 'tableRespEcon';
                        reloadtable(id);
                        $('#divModalForms').modal('hide');
                        $('#divModalDone').modal('show');
                        $('#divMsgDone').html('Resposabilidad Económica Agregada Correctamente');
                    } else {
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(r);
                    }
                }
            });
        }
        return false;
    });
    var cambiarEstado = function(e, idt, u, btn) {
        $.ajax({
            type: 'POST',
            url: u,
            data: { e: e, idt: idt },
            success: function(r) {
                switch (r) {
                    case '0':
                        $(btn).attr('title', 'Inactivo');
                        $(btn).removeClass('fa-toggle-on');
                        $(btn).addClass('fa-toggle-off');
                        $(btn).removeClass('activo');
                        $(btn).addClass('inactivo');
                        break;
                    case '1':
                        $(btn).attr('title', 'Activo');
                        $(btn).removeClass('fa-toggle-off');
                        $(btn).addClass('fa-toggle-on');
                        $(btn).removeClass('inactivo');
                        $(btn).addClass('activo');
                        break;
                    default:
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(r);
                        break;
                }
            }
        });
    };
    //cambiar estado resposabilidad economica
    $('#modificarRespEcons').on('click', '.estado', function() {
        let e = !($(this).hasClass('activo')) ? '1' : '0';
        let idt = $(this).attr('value');
        let url = 'actualizar/up_estado_resp_econ.php';
        let btn = $(this);
        cambiarEstado(e, idt, url, btn);
        return false;
    });
    //Borrar Resposabilidad confirmar
    $('#modificarRespEcons').on('click', '.borrar', function() {
        let id = $(this).attr('value');
        let tip = 'RespEcon';
        confdel(id, tip);
    });
    //Eliminar Resposabilidad
    $("#divBtnsModalDel").on('click', '#btnConfirDelRespEcon', function() {
        $('#divModalConfDel').modal('hide');
        $.ajax({
            type: 'POST',
            url: 'eliminar/del_resp_econ.php',
            data: {},
            success: function(r) {
                if (r === '1') {
                    let id = 'tableRespEcon';
                    reloadtable(id);
                    $('#divModalDone').modal('show');
                    $('#divMsgDone').html("Responsabilidad Económica eliminada correctamente");
                } else {
                    $('#divModalError').modal('show');
                    $('#divMsgError').html(r);
                }
            }
        });
        return false;
    });
    //Agregar Actividad Economica
    $('#divForms').on('click', '#btnAddActvEcon', function() {
        if ($('#slcActvEcon').val() === '0') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('¡Debe seleccionar una Actividad Económica!');
        } else if ($('#datFecInicio').val() === '') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('¡Fecha Inicio no puede ser vacia!');
        } else {
            datos = $('#formAddActvEcon').serialize();
            $.ajax({
                type: 'POST',
                url: 'registrar/new_actv_econ.php',
                data: datos,
                success: function(r) {
                    if (r === '1') {
                        let id = 'tableActvEcon';
                        reloadtable(id);
                        $('#divModalForms').modal('hide');
                        $('#divModalDone').modal('show');
                        $('#divMsgDone').html('Actvidad Económica Agregada Correctamente');
                    } else {
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(r);
                    }
                }
            });
        }
        return false;
    });
    //cambiar estado actividad economica
    $('#modificarActvEcons').on('click', '.estado', function() {
        let e = !($(this).hasClass('activo')) ? '1' : '0';
        let idt = $(this).attr('value');
        let url = 'actualizar/up_estado_actv_econ.php';
        let btn = $(this);
        cambiarEstado(e, idt, url, btn);
        return false;
    });
    //Borrar actividad confirmar
    $('#modificarActvEcons').on('click', '.borrar', function() {
        let id = $(this).attr('value');
        let tip = 'ActvEcon';
        confdel(id, tip);
    });
    //Eliminar Actividad
    $("#divBtnsModalDel").on('click', '#btnConfirDelActvEcon', function() {
        $('#divModalConfDel').modal('hide');
        $.ajax({
            type: 'POST',
            url: 'eliminar/del_actv_econ.php',
            data: {},
            success: function(r) {
                if (r === '1') {
                    let id = 'tableActvEcon';
                    reloadtable(id);
                    $('#divModalDone').modal('show');
                    $('#divMsgDone').html("Actividad Económica eliminada correctamente");
                } else {
                    $('#divModalError').modal('show');
                    $('#divMsgError').html(r);
                }
            }
        });
        return false;
    });
    //cargar documentos
    $('#divForms').on('click', '#btnAddDocsTercero', function() {
        if ($('#slcTipoDocs').val() === '0') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('¡Debe seleccionar un tipo de documento!');
        } else if ($('#datFecInicio').val() === '') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('¡Debe ingresar Fecha Inicio!');
        } else if ($('#datFecVigencia').val() === '') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('¡Debe ingresar Fecha de Vigencia!');
        } else if ($('#fileDoc').val() === '') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('¡Debe elegir un archivo!');
        } else {
            let archivo = $('#fileDoc').val();
            let ext = archivo.substring(archivo.lastIndexOf(".")).toLowerCase();
            if (ext !== '.pdf') {
                $('#divModalError').modal('show');
                $('#divMsgError').html('¡Solo se permite documentos .pdf!');
                return false;
            } else if ($('#fileDoc')[0].files[0].size > 2097152) {
                $('#divModalError').modal('show');
                $('#divMsgError').html('¡Documento debe tener un tamaño menor a 2Mb!');
                return false;
            }
            let datos = new FormData();
            datos.append('idTercero', $('#idTercero').prop('value'));
            datos.append('slcTipoDocs', $('#slcTipoDocs').prop('value'));
            datos.append('datFecInicio', $('#datFecInicio').prop('value'));
            datos.append('datFecVigencia', $('#datFecVigencia').prop('value'));
            datos.append('fileDoc', $('#fileDoc')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: 'registrar/new_doc_tercero.php',
                contentType: false,
                data: datos,
                processData: false,
                cache: false,
                success: function(r) {
                    if (r === '1') {
                        let id = 'tableDocumento';
                        reloadtable(id);
                        $('#divModalForms').modal('hide');
                        $('#divModalDone').modal('show');
                        $('#divMsgDone').html('Documento cargado Correctamente');
                    } else {
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(r);
                    }
                }
            });
        }
        return false;
    });
    //Actualizar Documentos terceros
    $('#modificarDocs').on('click', '.editar', function() {
        let idD = $(this).attr('value');
        $.post("datos/actualizar/up_docs_tercero.php", { idD: idD }, function(he) {
            $('#divTamModalForms').removeClass('modal-xl');
            $('#divTamModalForms').removeClass('modal-sm');
            $('#divTamModalForms').addClass('modal-lg')
            $('#divModalForms').modal('show');
            $("#divForms").html(he);
            $('#slcTipoDocs').focus();
        });
    });
    $('#divForms').on('click', '#btnUpDocs', function() {
        let id;
        if ($('#datFecInicio').val() === '') {
            id = 'datFecInicio';
            bordeError(id);
            showError(id);
        } else if ($('#datFecVigencia').val() === '') {
            id = 'datFecVigencia';
            bordeError(id);
            showError(id);
        } else {
            let datos = new FormData();
            if ($('#fileDoc').val() !== '') {
                let archivo = $('#fileDoc').val();
                let ext = archivo.substring(archivo.lastIndexOf(".")).toLowerCase();
                if (ext !== '.pdf') {
                    $('#divModalError').modal('show');
                    $('#divMsgError').html('¡Solo se permite documentos .pdf!');
                    return false;
                } else if ($('#fileDoc')[0].files[0].size > 2097152) {
                    $('#divModalError').modal('show');
                    $('#divMsgError').html('¡Documento debe tener un tamaño menor a 2Mb!');
                    return false;
                }
                datos.append('fileDoc', $('#fileDoc')[0].files[0]);
            }
            datos.append('id_ter', $('#id_ter').prop('value'));
            datos.append('id_doscter', $('#id_doscter').prop('value'));
            datos.append('idTipoDoc', $('#idTipoDoc').prop('value'));
            datos.append('nomTipoDoc', $('#nomTipoDoc').prop('value'));
            datos.append('slcTipoDocs', $('#slcTipoDocs').prop('value'));
            datos.append('nom_archivo', $('#nom_archivo').prop('value'));
            datos.append('datFecInicio', $('#datFecInicio').prop('value'));
            datos.append('datFecVigencia', $('#datFecVigencia').prop('value'));
            $.ajax({
                type: 'POST',
                url: 'actualizar/up_docs_tercero.php',
                contentType: false,
                data: datos,
                processData: false,
                cache: false,
                success: function(r) {
                    if (r === '1') {
                        let id = 'tableDocumento';
                        reloadtable(id);
                        $('#divModalForms').modal('hide');
                        $('#divModalDone').modal('show');
                        $('#divMsgDone').html('Actualización Correcta');
                    } else {
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(r);
                    }
                }
            });
        }
        return false;
    });
    //Borrar Documentos confirmar
    $('#modificarDocs').on('click', '.borrar', function() {
        let id = $(this).attr('value');
        let tip = 'Docs';
        confdel(id, tip);
    });
    //Eliminar documento
    $("#divBtnsModalDel").on('click', '#btnConfirDelDocs', function() {
        $('#divModalConfDel').modal('hide');
        $.ajax({
            type: 'POST',
            url: 'eliminar/del_docs_tercero.php',
            data: {},
            success: function(r) {
                if (r === '1') {
                    let id = 'tableDocumento';
                    reloadtable(id);
                    $('#divModalDone').modal('show');
                    $('#divMsgDone').html("Documento eliminado correctamente");
                } else {
                    $('#divModalError').modal('show');
                    $('#divMsgError').html(r);
                }
            }
        });
        return false;
    });
    $('#modificarDocs').on('click', '.descargar', function() {
        let id_doc = $(this).attr('value');
        $.ajax({
            type: 'POST',
            url: 'datos/descargas/descarga_docs.php',
            dataType: 'json',
            data: { id_doc: id_doc },
            success: function(r) {
                if (r == '0') {
                    alert('Archivo no disponible');
                } else {
                    let a = document.createElement("a");
                    a.href = "data:application/pdf;base64," + r['file'];
                    a.download = r['tipo'] + ".pdf";
                    a.click();
                }

            }
        });
        return false;
    });
    $('#modificarDocSopContrato').on('click', '.descargar', function() {
        let data = $(this).attr('value').split('|');
        let ruta = data[0];
        let tipo = data[1];
        $.ajax({
            type: 'POST',
            url: '../datos/descargas/descarga_docs_soporte_contrato.php',
            dataType: 'json',
            data: { ruta: ruta },
            success: function(r) {
                if (r == 0) {
                    alert('Archivo no disponible');
                } else {
                    let a = document.createElement("a");
                    a.href = "data:application/pdf;base64," + r['file'];
                    a.download = tipo + ".pdf";
                    a.click();
                }

            }
        });
        return false;
    });
    $('#tableDocsContratoSupervisar').on('click', '.descargar', function() {
        let data = $(this).attr('value').split('|');
        let ruta = data[0];
        let tipo = data[1];
        $.ajax({
            type: 'POST',
            url: '../datos/descargas/descarga_docs_soporte_contrato.php',
            dataType: 'json',
            data: { ruta: ruta },
            success: function(r) {
                if (r == 0) {
                    alert('Archivo no disponible');
                } else {
                    let a = document.createElement("a");
                    a.href = "data:application/pdf;base64," + r['file'];
                    a.download = tipo + ".pdf";
                    a.click();
                }

            }
        });
        return false;
    });
    $('.modificarCotizaciones').on('click', '.detalle', function() {
        let datos = $(this).attr('value');
        $('<form action="cotizaciones/detalles_cotizacion.php" method="post"><input type="hidden" name="detalles" value="' + datos + '" /></form>').appendTo('body').submit();
    });
    //enviar cotizacion con valor
    $('#btnEnvCotiz').on('click', function() {
        let form = 'formDetalleCotizacion';
        let tipo = 'number';
        let res = camposVacios(form, tipo);
        if (res) {
            let datos = $('#formDetalleCotizacion').serialize();
            $.ajax({
                type: 'POST',
                url: '../registrar/new_val_cotizacion.php',
                data: datos,
                success: function(r) {
                    if (r == '1') {
                        $('.btn-modal').attr('data-dismiss', '');
                        $('.btn-modal').attr('href', 'javascript: history.go(-1)');
                        $('#divModalDone').modal('show');
                        $('#divMsgDone').html("Cotización enviada correctamente");
                    } else {
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(r);
                    }
                }
            });
        }
        return false;
    });

    $('.modificarCotizaciones').on('click', '.informacion', function() {
        let id = $(this).attr('value');
        $.post("datos/listar/datos_cotizacion_enviada.php", { id: id }, function(he) {
            $('#divTamModalForms').removeClass('modal-lg');
            $('#divTamModalForms').removeClass('modal-sm');
            $('#divTamModalForms').addClass('modal-xl')
            $('#divModalForms').modal('show');
            $("#divForms").html(he);
        });
    });
    $('.modificarContratos ').on('click', '.descargar', function() {
        let data = $(this).attr('value').split('|');
        let id_c = data[0];
        let name = data[1];
        $.ajax({
            type: 'POST',
            url: 'datos/descargas/descarga_contrato.php',
            dataType: 'json',
            data: { id_c: id_c },
            success: function(r) {
                if (r == 0) {
                    alert('Archivo no disponible');
                } else {
                    let a = document.createElement("a");
                    a.href = "data:application/pdf;base64," + r;
                    a.download = "CC-" + name + ".pdf";
                    a.click();
                }

            }
        });
        return false;
    });
    //enviar contrato
    $('.modificarContratos ').on('click', '.enviar', function() {
        let id = $(this).attr('value');
        $.post("datos/registrar/formenviar_contrato.php", { id: id }, function(he) {
            $('#divTamModalForms').removeClass('modal-xl');
            $('#divTamModalForms').removeClass('modal-sm');
            $('#divTamModalForms').removeClass('modal-lg');
            $('#divModalForms').modal('show');
            $("#divForms").html(he);
        });
        return false;
    });
    //subir contrato
    $('#divModalForms').on('click', '#btnSubirContrato', function() {
        if ($('#fileContrato').val() === '') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('¡Debe elegir un archivo!');
        } else {
            let archivo = $('#fileContrato').val();
            let ext = archivo.substring(archivo.lastIndexOf(".")).toLowerCase();
            if (ext !== '.pdf') {
                $('#divModalError').modal('show');
                $('#divMsgError').html('¡Solo se permite documentos .pdf!');
            } else if ($('#fileContrato')[0].files[0].size > 10485760) {
                $('#divModalError').modal('show');
                $('#divMsgError').html('¡Documento debe tener un tamaño menor a 10Mb!');
            } else {
                let datos = new FormData();
                datos.append('id_contrato_rec', $('#id_contrato_rec').prop('value'));
                datos.append('fileContrato', $('#fileContrato')[0].files[0]);
                $.ajax({
                    type: 'POST',
                    url: 'datos/actualizar/enviar_contrato.php',
                    contentType: false,
                    data: datos,
                    processData: false,
                    cache: false,
                    success: function(r) {
                        if (r == 1) {
                            $('#divModalDone a').attr('data-dismiss', '');
                            $('#divModalDone a').attr('href', 'javascript:location.reload()');
                            $('#divModalForms').modal('hide');
                            $('#divModalDone').modal('show');
                            $('#divMsgDone').html('Contrato enviado Correctamente');
                        } else {
                            $('#divModalError').modal('show');
                            $('#divMsgError').html(r);
                        }
                    }
                });
            }
        }
        return false;
    });
    $('.modificarContratos').on('click', '.informacion', function() {
        let datos = $(this).attr('value');
        $('<form action="contratos/detalles_contratos.php" method="post"><input type="hidden" name="det_contrato" value="' + datos + '" /></form>').appendTo('body').submit();
    });
    //mostrar otro cual?
    $('#divModalForms').on('change', '#slcTipoDoc', function() {
        if ($(this).val() == 99) {
            $('#divCual').show();
        } else {
            $('#divCual').hide();
        }
        return false;
    });
    //adjuntar documentos soporte de contrato
    $('#divModalForms').on('click', '#btnDocsSoporteC', function() {
        if ($('#slcTipoDoc').val() == 0) {
            $('#divModalError').modal('show');
            $('#divMsgError').html('¡Debe selecionar un tipo de documento!');
        } else if ($('#fileDocCt').val() == '') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('¡Debe elegir un archivo!');
        } else {
            let archivo = $('#fileDocCt').val();
            let ext = archivo.substring(archivo.lastIndexOf(".")).toLowerCase();
            if (ext != '.pdf') {
                $('#divModalError').modal('show');
                $('#divMsgError').html('¡Solo se permite documentos .pdf!');
            } else if ($('#fileDocCt')[0].files[0].size > 2097152) {
                $('#divModalError').modal('show');
                $('#divMsgError').html('¡Documento debe tener un tamaño menor a 2Mb!');
            } else if ($('#slcTipoDoc').val() == 99 && $('#txtCual').val() == '') {
                $('#divModalError').modal('show');
                $('#divMsgError').html('Debe escribir el tipo de documento');
            } else {
                let datos = new FormData();
                datos.append('id_contrato_d', $('#id_devuelto').prop('value'));
                datos.append('slcTipoDoc', $('#slcTipoDoc').prop('value'));
                datos.append('txtCual', $('#txtCual').prop('value'));
                datos.append('fileDocCt', $('#fileDocCt')[0].files[0]);
                $.ajax({
                    type: 'POST',
                    url: '../registrar/new_doc_soporte.php',
                    contentType: false,
                    data: datos,
                    processData: false,
                    cache: false,
                    success: function(r) {
                        if (r == 1) {
                            if ($('#tableDocSopContrato').length) {
                                let id = 'tableDocSopContrato';
                                reloadtable(id);
                            }
                            if ($('#tableDocsContratoSupervisar').length) {
                                let id = 'tableDocsContratoSupervisar';
                                reloadtable(id);
                            }
                            $('#divModalForms').modal('hide');
                            $('#divModalDone').modal('show');
                            $('#divMsgDone').html('Documento de soporte adjuntado Correctamente');
                        } else {
                            $('#divModalError').modal('show');
                            $('#divMsgError').html(r);
                        }
                    }
                });
            }
        }
        return false;
    });
    //actualizar documento soporte de contrato
    $('#tableDocSopContrato').on('click', '.editar', function() {
        let id = $(this).attr('value');
        $.post("../datos/actualizar/up_docs_soporte_c.php", { id: id }, function(he) {
            $('#divTamModalForms').removeClass('modal-xl');
            $('#divTamModalForms').removeClass('modal-sm');
            $('#divTamModalForms').addClass('modal-lg');
            $('#divModalForms').modal('show');
            $("#divForms").html(he);
        });
    });
    //Actualizar documentos soporte de contrato
    $('#divModalForms').on('click', '#btnUpDocsSoporteC', function() {
        if ($('#slcTipoDoc').val() == 99 && $('#txtCual').val() == '') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('Debe escribir el tipo de documento');
        } else {
            let datos = new FormData();
            if ($('#fileDocCt').val() != '') {
                let archivo = $('#fileDocCt').val();
                let ext = archivo.substring(archivo.lastIndexOf(".")).toLowerCase();
                if (ext != '.pdf') {
                    $('#divModalError').modal('show');
                    $('#divMsgError').html('¡Solo se permite documentos .pdf!');
                    return false;
                } else if ($('#fileDocCt')[0].files[0].size > 2097152) {
                    $('#divModalError').modal('show');
                    $('#divMsgError').html('¡Documento debe tener un tamaño menor a 2Mb!');
                    return false;
                }
                datos.append('fileDocCt', $('#fileDocCt')[0].files[0]);
            }
            datos.append('id_doc', $('#id_documento').prop('value'));
            datos.append('slcTipoDoc', $('#slcTipoDoc').prop('value'));
            datos.append('txtCual', $('#txtCual').prop('value'));
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../actualizar/up_doc_soporte_c.php',
                contentType: false,
                data: datos,
                processData: false,
                cache: false,
            }).done(function(r) {
                if (r.estado == 1) {
                    let id = 'tableDocSopContrato';
                    reloadtable(id);
                    $('#divModalForms').modal('hide');
                    $('#divModalDone').modal('show');
                    $('#divMsgDone').html(r.response);
                } else {
                    $('#divModalError').modal('show');
                    $('#divMsgError').html(r.response);
                }
            });

        }
        return false;
    });
    //eliminar documento soporte de contrato
    $('#tableDocSopContrato').on('click', '.borrar', function() {
        let id = $(this).attr('value');
        let tip = 'DocSoporteC';
        confdel(id, tip);
    });
    $("#divBtnsModalDel").on('click', '#btnConfirDelDocSoporteC', function() {
        $('#divModalConfDel').modal('hide');
        $.ajax({
            type: 'POST',
            url: '../eliminar/del_docs_soporte_c.php',
            data: {},
            success: function(r) {
                if (r == '1') {
                    let id = 'tableDocSopContrato';
                    reloadtable(id);
                    $('#divModalDone').modal('show');
                    $('#divMsgDone').html("Documento de soporte eliminado correctamente");
                } else {
                    $('#divModalError').modal('show');
                    $('#divMsgError').html(r);
                }
            }
        });
        return false;
    });
    //Verificar campos vacios;
    var camposVacios = function(f, t) {
        let r = true;
        let $inputs = $('#' + f).find('table').children().find(':input[type="' + t + '"]');
        $inputs.each(function(index, element) {
            if ($(element).val().length <= 0) {
                $(element).focus();
                $(element).css("border", "solid 2px #F5B7B1");
                r = false;
                return false;
            }
        });
        return r;
    };
    $('#modificarSupervisiones').on('click', '.detalle', function() {
        let datos = $(this).attr('value');
        $('<form action="supervision/detalles_contratos_supervisar.php" method="post"><input type="hidden" name="det_super" value="' + datos + '" /></form>').appendTo('body').submit();
    });
    var cambiaEstado = function(id, estado) {
        $.ajax({
            type: 'POST',
            url: '../datos/actualizar/up_estado_doc_soporte.php',
            data: { id: id, estado: estado },
            success: function(r) {
                if (r == 1) {
                    let id_t = 'tableDocsContratoSupervisar';
                    reloadtable(id_t);
                } else {
                    $('#divModalError').modal('show');
                    $('#divMsgError').html(r);
                }

            }
        });
    };
    $('#modificarDocsContratoSupervisar').on('click', '.aprobar', function() {
        let id = $(this).attr('value');
        let estado = '2';
        cambiaEstado(id, estado);
        return false;
    });
    $('#modificarDocsContratoSupervisar').on('click', '.rechazar', function() {
        let id = $(this).attr('value');
        let estado = '3';
        cambiaEstado(id, estado);
        return false;
    });
    $('#tableDocsContratoSupervisar').on('click', '#btnDevActaDesigSuperv', function() {
        let id_contr = $(this).attr('value');
        $.post("../datos/registrar/formadd_doc_soporte_c.php", { id_contr: id_contr }, function(he) {
            $('#divTamModalForms').removeClass('modal-xl');
            $('#divTamModalForms').removeClass('modal-sm');
            $('#divTamModalForms').addClass('modal-lg');
            $('#divModalForms').modal('show');
            $("#divForms").html(he);
            $('#slcRespEcon').focus();
        });
    });
    $('.modificarContratos ').on('click', '.entregar', function() {
        let id = $(this).attr('value');
        $.post("datos/registrar/form_entregar_compra.php", { id: id }, function(he) {
            $('#divTamModalForms').removeClass('modal-sm');
            $('#divTamModalForms').removeClass('modal-lg');
            $('#divTamModalForms').addClass('modal-xl');
            $('#divModalForms').modal('show');
            $("#divForms").html(he);
        });
        return false;
    });
    //Hacer entrega de productos
    $('#divForms').on('click', '#btnEntregarCompra', function() {
        var aprobar = 1;
        $('input[type=number]').each(function() {
            var min = parseInt($(this).attr('min'));
            var max = parseInt($(this).attr('max'));
            var val = $(this).val().length ? parseInt($(this).val()) : 'NO';
            $(this).removeClass('border-danger');
            if (val == 'NO') {
                aprobar = 0;
                $(this).focus();
                $(this).addClass('border-danger');
                $('#divModalError').modal('show');
                $('#divMsgError').html('El valor debe estar entre ' + min + ' y ' + max + ' válido');
            } else if (val < min || val > max) {
                aprobar = 0;
                $(this).focus();
                $(this).addClass('border-danger');
                $('#divModalError').modal('show');
                $('#divMsgError').html('El valor debe estar entre ' + min + ' y ' + max);
            }
            if (aprobar == 0) {
                return false;
            }
        });
        if (aprobar == 1) {
            $cantidades = $('#formCantEntrega').serialize();
            $.ajax({
                type: 'POST',
                url: 'datos/actualizar/up_entregar_compra.php',
                data: $cantidades,
                success: function(r) {
                    if (r == 1) {
                        $('#divModalDone a').attr('data-dismiss', '');
                        $('#divModalDone a').attr('href', 'javascript:location.reload()');
                        $('#divModalForms').modal('hide');
                        $('#divModalDone').modal('show');
                        $('#divMsgDone').html("Entrega realizada correctamente");
                    } else {
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(r);
                    }

                }
            });
        }
    });
    //Generar certificado formulario 220
    $('#btnCertificadoForm220').on('click', function() {
        $.post("datos/listar/opciones_form220.php", function(he) {
            $('#divTamModalForms').removeClass('modal-sm');
            $('#divTamModalForms').removeClass('modal-xl');
            $('#divTamModalForms').removeClass('modal-lg');
            $('#divModalForms').modal('show');
            $("#divForms").html(he);
        });
        return false;
    });
    //descargar certificado formulario 220
    $('#divForms').on('click', '#btnDownCertifForm220', function() {
        if ($('#slcEmpresa').val() == '0') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('Seleccione una empresa');
        } else if ($('#numAnioCertifica').val() == '' || parseInt($('#numAnioCertifica').val()) == 0) {
            $('#divModalError').modal('show');
            $('#divMsgError').html('Ingrese un año correcto');
        } else if ($('#slcTipoCertificado').val() == '0') {
            $('#divModalError').modal('show');
            $('#divMsgError').html('Seleccione un tipo de certificado');
        } else {
            let datos = $('#formGenForm220').serialize();
            $.ajax({
                type: 'POST',
                url: 'datos/listar/generar_ruta.php',
                dataType: 'json',
                data: datos,
                success: function(r) {
                    if (r.status == 1) {
                        $('#divModalForms').modal('hide');
                        $('#divModalConfDel').modal('show');
                        $('#divMsgConfdel').html('Espere un momento, se está generando el certificado...');
                        $('#divBtnsModalDel').html('<a type="button" class="btn btn-primary btn-sm btn-modal" data-dismiss="modal"> Aceptar</a>');
                        let ruta = r.response;
                        $('<form action="datos/descargas/descarga_certificado.php" method="post"><input type="hidden" name="ruta" value="' + ruta + '" /></form>').appendTo('body').submit();
                    } else {
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(r.response);
                    }
                }
            });
        }
        return false;
    });
})(jQuery);