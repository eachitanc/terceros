var timeout;
var actual = "EAC" + window.location + 'II';
var esta = actual.indexOf('index')
if (esta === -1) {
    document.onmousemove = function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            $.ajax({
                type: 'POST',
                url: window.urlin + '/set/cerrar_sesion.php',
                success: function(r) {
                    $('#divModalXSesion').modal('show');

                }
            });
        }, 600000);
    }
}
(function($) {
    $("#btnLogin").click(function() {
        let user = $("#txtUser").val();
        let pass = $("#passuser").val();
        if (user === "") {
            $('#divModalError').modal('show');
            $('#divMsgError').html("Debe ingresar Usuario");
        } else if (pass === "") {
            $('#divModalError').modal('show');
            $('#divMsgError').html("Debe ingresar Contraseña");
        } else {
            pass = hex_sha512(pass);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'set/validar_login.php',
                data: { user: user, pass: pass }
            }).done(function(res) {
                switch (res.mensaje) {
                    case 0:
                        $('#divModalError').modal('show');
                        $('#divMsgError').html("Usuario y/o Contraseña incorrecto(s)");
                        break;
                    case 1:
                        window.location = "terceros/gestion/detalles_tercero.php";
                        break;
                    case 2:
                        $('#divModalError').modal('show');
                        $('#divMsgError').html("Usuario suspendido temporalmente");
                        break;
                    default:
                        $('#divModalError').modal('show');
                        $('#divMsgError').html(res.mensaje);
                        break;
                }
            });
        }
        return false;
    });
    $('.table-hover tbody').on('dblclick', 'tr', function() {
        let table = $('.table-hover').DataTable();
        if ($(this).hasClass('selecionada')) {
            $(this).removeClass('selecionada');
        } else {
            table.$('tr.selecionada').removeClass('selecionada');
            $(this).addClass('selecionada');
        }
    });
})(jQuery);