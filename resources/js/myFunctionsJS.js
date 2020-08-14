// ###################################################################
// VALIDA SESION Y SU TIEMPO DE SESION CADA 10 SEGUNDO
// ###################################################################
var mySesionVar;

function runValidarTiempoSesion() {
    //console.log('Validando sesion...')

    $.ajax({
        url: serverURL + "controllers/ctl_sesion.php",
        type: "POST",
        data: "op=vidaSesion&tiempoSesion=" + tiempoSesion,
        success: function(opciones) {

            //console.log("TiempoSesion: "+tiempoSesion+" Rta de ctl_sesion.php => "+opciones);			
            if (opciones == 0) {
                //alert("Se termino su tiempo");
                terminaSesion('El tiempo de su sesion ha terminado.');
            }

        }
    })

    mySesionVar = setTimeout(function() { runValidarTiempoSesion() }, 1000);
}
// ###################################################################
// DETIENE TIEMPO DE SESION AL SALIR DE LA VENTANA
// ###################################################################
function stopValidarTiempoSesion() {
    clearTimeout(mySesionVar);
}



// ###################################################################
// AGREGA CONTENIDO HTML A UN DIV
// ###################################################################
function cargarPaginaEnDiv(nomDiv, pagina) {
    //("ContenedorOpciones").innerHTML
    $.ajax({
        type: "POST",
        url: pagina,
        success: function(opciones) {
            $("#" + nomDiv).html(opciones);
        }
    })
}
// ###################################################################
// Confirmación para eliminar un registro
// ###################################################################
function confirmaEliminar(mensaje) {

    var agree = confirm(mensaje);

    if (agree) {
        return true;
    } else {
        return false;
    }
}
// ###################################################################
// VALIDA QUE SOLO SE ESCRIBAN NUMERO EN CAJA DE TEXTO
// ###################################################################	
//  SOLO NUMEROS -> onkeypress="return validarNumericos(event);"
function validarNumericos(evt) {
    var code = evt.which ? evt.which : evt.keyCode;
    // code == 8  backspace
    if (code >= 48 && code <= 57) {
        //is a number
        return true;
    } else {
        return false;
    }
}

// ###################################################################
// VALIDA QUE SOLO SE ESCRIBA TEXTO EN CAJA DE TEXTO
// ###################################################################
// VALIDA SOLO LETRAS -> onkeypress="return validarTexto(event);"
function validarTexto(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ.0123456789"; //Se define todo el abecedario que se quiere que se muestre.
    especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        //alert('Tecla no aceptada');
        return false;
    }
}
// ###################################################################
// REEMPLAZA TODOS LOS CARACTERES ENVIADOS EN UNA CADENA
// ###################################################################
function replaceAll(text, busca, reemplaza) {
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca, reemplaza);
    return text;
}
// ###################################################################
// Confirmación para salir del sistema
// ###################################################################
function confirmarSalir() {
    var agree = confirm("¿Realmente desea Salir del sistema? ");
    if (agree) {
        return true;
    } else {
        return false;
    }
}
// ###################################################################
// Confirmación para eliminar un registro
// ###################################################################
function confirmaEliminar(mensaje) {
    // <a href="../controllers/controladorFinca.php?op=eliminar&id='.$entrada['id_finca'].'" onClick="return confirmaEliminar(\'¿Desea eliminar la Finca?\');"
    var agree = confirm(mensaje);

    if (agree) {
        return true;
    } else {
        return false;
    }
}
// ###################################################################
// ABRE UNA URL Y MUESTRA MENSAJE
// ###################################################################
function abrirUrl(url, mensaje) {
    msg = mensaje;
    mensajeRetardado("Sistema", msg, "1200");
    enviaraPagina(url, '1500');
}
// ###################################################################
// FORMATEA UNA FECHA ENVIADA Y LA DEVUELVE EN FORMATO yyyy-mm-dd
// ###################################################################
function formatearFecha(date) {
    var month = date.getMonth() + 1;
    if (month < 10) { month = "0" + month; }

    var day = date.getDate();
    if (day < 10) { day = "0" + day; }

    var year = date.getFullYear();
    // Retorna en formato: 2018-07-20
    return year + "-" + month + "-" + day;
}

// ###################################################################
// SUMA DIAS A UNA FECHA ENVIADA
// ###################################################################
function sumarDias(fecha, dias) {
    fecha.setDate(fecha.getDate() + dias);
    return fecha;
}
// ###################################################################
// TOMA FECHA, DISPARA SUMADOR DE DIAS Y ASIGNA A OTRO CAMPO
// ###################################################################
function sumarDiasAFecha(origen, destino) {

    var diasASumar = $(origen).val();

    var d = new Date();
    var rta = (sumarDias(d, +diasASumar));

    $(destino).val(formatearFecha(rta));
}

// ###################################################################
// Muestra mensajes en capa oculta con id divEstado
// ###################################################################
function mostrarMensaje(mensaje, tipo) {

    if (tipo == "" || tipo == "Normal") {
        $('#divEstado').removeClass('alert alert-success alert-info alert-warning alert-danger');
        $('#divEstado').addClass('alert alert-warning');
    } else if (tipo == "Peligro") {
        $('#divEstado').removeClass('alert alert-success alert-info alert-warning alert-danger');
        $('#divEstado').addClass('alert alert-danger');
    } else {
        $('#divEstado').removeClass('alert alert-success alert-info alert-warning alert-danger');
        $('#divEstado').addClass('alert alert-success');
    }
    $('#divEstado').html('<p align="center"><strong>' + mensaje + '</strong></p>');
    //$('#divEstado').fadeIn(2000);
    //$('#divEstado').fadeOut(2000);
}

function mensajeRetardado(titulo, contenido, tiempo, icono, boton) {
    // icon: "warning" "error" "success" "info" 
    // button: "Coolio" button: false
    swal({
        title: titulo,
        text: contenido,
        timer: tiempo,
        icon: icono,
        button: boton
    });
}
// ###################################################################
// Envia a una pagina con determinada demora de envio
// ###################################################################
function enviaraPagina(url = "", delay) {
    //console.log("Dirigiendose a: "+serverURL+url);
    setTimeout(function() { window.location = serverURL + url; }, delay);
}
// ###################################################################
// CUANDO DETECTA QUE EL MOUSE ENTRA EN LA VENTANA
// ###################################################################
$(document).mouseenter(function() {
    stopValidarTiempoSesion();
    //console.log('When Mouse Enter on the window');
    $.ajax({
        url: serverURL + "controllers/ctl_sesion.php",
        type: "POST",
        data: "op=reiniciarTiempo",
        success: function(opciones) {
            //console.log("Se reinicio tiempo de sesion: "+opciones);
        }
    })
});
// ###################################################################
// CUANDO DETECTA QUE EL MOUSE SALE DE LA VENTANA
// ###################################################################
$(document).mouseleave(function() {
    //console.log('out');
    if (paginaJS != "login") {
        runValidarTiempoSesion();
    }

});
// ###################################################################
// Muestra Form para registro de nuevo usuario
// ###################################################################
function RegistroNuevoUsuario() {

    jQuery.ajax({
        url: serverURL + "controllers/ctl_usuario.php",
        method: "POST",
        data: "op=registro",
        success: function(resp) {
            //console.log(resp);
            jQuery('#modalTitulo').html('Registro de Nuevo Usuario');
            jQuery('#bodyModal').html(resp);
            jQuery('#frmModal').modal({ backdrop: 'static', keyboard: false });
            jQuery('#frmModal').modal('show');
        }
    });

}
// ###################################################################
// Mensaje de alerta para crear usuarios con datos de familiar existente
// ###################################################################
function validaExisteUsuario(value) {

    jQuery.ajax({
        url: serverURL + "controllers/ctl_usuario.php",
        method: "POST",
        data: {
            op: 'validaExisteDni',
            dni: value
        },
        success: function(resp) {

            //console.log(resp);

            if (resp >= 2) {
                mensajeRetardado("EL DNI YA EXISTE", "Los datos del usuario que intenta crear ya existen y superan la cantidad de registros permitidos, intente con otros datos.", 3000, "error", false);
            } else if (resp == 1) {
                mensajeRetardado("EL DNI YA EXISTE", "Los datos del usuario que intenta crear ya existen y se cargaran en su formulario.", 2000, "success", false);
            }

            mostrarUserExisteData(value);

        }
    });

}
// ###################################################################
// Carga datos en form de familiar existente
// ###################################################################
function mostrarUserExisteData(value) {

    jQuery.ajax({
        url: serverURL + "controllers/ctl_usuario.php",
        method: "POST",
        data: {
            op: 'mostrarUserExisteData',
            dni: value
        },
        success: function(resp) {

            //console.log(resp);
            jQuery('#modalTitulo').html('Registro de Nuevo Usuario');
            jQuery('#bodyModal').html(resp);
            jQuery('#frmModal').modal({ backdrop: 'static', keyboard: false });
            jQuery('#frmModal').modal('show');

        }
    });

}
// ###################################################################
// VALIDA SI EL DNI EXISTE EN BD
// ###################################################################
function validaTieneUsuario(value) {

    jQuery.ajax({
        url: serverURL + "controllers/ctl_familiar.php",
        method: "POST",
        data: {
            op: 'validaExisteUsuario',
            dni: value
        },
        success: function(resp) {
            //console.log(resp);
            if (resp > 0) {
                mensajeRetardado("EL DNI YA EXISTE", "Los datos del usuario que intenta crear ya existen, intente con datos distintos.", 2000, "warning", false);
                $("#txt_dni").val('');
                $("#txt_dni").focus();
                return false;
            }

        }
    });

}

// ###################################################################
// VALIDA INCIO DE SESION
// ###################################################################
function validaLogin() {

    email = $("#txt_email").val();
    pass = $("#txt_password").val();
    valEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (email == "" || pass == "") {
        mensajeRetardado("Inicio de sesión fallido", "Debe digitar los datos de inicio de sesion.", 3000, "warning", false);
    } else if (!valEmail.test(email) || email.length <= 0 || email.length > 150) {
        mensajeRetardado("Datos No Validos", "Debe digitar un correo y una contraseña validos.", 3000, "warning", false);
        $("#txt_email").val('');
        $("#txt_email").focus;
    } else if (email != "" && email.length > 0 && validarContrasenas(pass, pass)) {


        $.ajax({
            url: serverURL + "controllers/ctl_usuario.php",
            type: "POST",
            data: {
                op: 'login',
                email: email,
                password: pass
            },
            success: function(resp) {

                //console.log(resp);

                if (resp == '1') {
                    mensajeRetardado("Bienvenido al Sistema", "  ", 2000, "success", false);
                    enviaraPagina('home', '3001');
                } else {
                    mensajeRetardado("Inicio de sesión fallido", "Datos erroneos o usuario inactivo, contacte al administrador.", 2000, "warning", false);
                    $("#txt_email").focus();
                    return false;
                }


            }
        });

    } else {
        mensajeRetardado("Inicio de sesión fallido", "Datos erroneos o usuario inactivo, contacte al administrador.", 3000, "warning", false);
        $("#txt_email").focus()
        return false;
    }

}
// ###################################################################
// VALIDA DATOS BASICOS DE PERSONA
// ###################################################################
function validarDatosBasicosPersona() {

    rta = false;
    valEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if ($("#txt_dni").val() === "" || $("#txt_dni").val() == 0) {
        mensajeRetardado("Datos No Validos", "Debe digitar datos validos.", 3000, "warning", false);
        $("#txt_dni").val('');
        $("#txt_dni").focus;
    } else if ($("#txt_nombres").val() === "") {
        mensajeRetardado("Datos No Validos", "Debe digitar datos validos.", 3000, "warning", false);
        $("#txt_nombres").val('');
        $("#txt_nombres").focus;
    } else if ($("#txt_apellidos").val() === "") {
        mensajeRetardado("Datos No Validos", "Debe digitar datos validos.", 3000, "warning", false);
        $("#txt_apellidos").val('');
        $("#txt_apellidos").focus;
    } else if ($("#txt_direccion").val() === "") {
        mensajeRetardado("Datos No Validos", "Debe digitar datos validos.", 3000, "warning", false);
        $("#txt_direccion").val('');
        $("#txt_direccion").focus;
    } else if ($("#txt_correo").val() === "" || !valEmail.test($("#txt_correo").val())) {
        mensajeRetardado("Datos No Validos", "Debe digitar datos validos.", 3000, "warning", false);
        $("#txt_correo").val('');
        $("#txt_correo").focus;
    } else if ($("#txt_telefono").val() === "") {
        mensajeRetardado("Datos No Validos", "Debe digitar datos validos.", 3000, "warning", false);
        $("#txt_telefono").val('');
        $("#txt_telefono").focus;
    } else {
        rta = true;
    }

    return rta;

}
// ###################################################################
// TERMINA SESION 
// ###################################################################
function terminaSesion(mensaje, titulo = "SALIENDO DEL SISTEMA") {

    var r = confirm("Desea Salir Del Sistema?");
    if (r == true) {

        $.ajax({
            url: serverURL + "controllers/ctl_usuario.php",
            type: "POST",
            data: "op=logout",
            /*beforeSend: function () {
                            $('div#divSusc2').html('<p><img src="img/reload.gif" /></p>')
            }, */
            success: function(opciones) {
                //console.log(opciones);
                if (mensaje == 1) {
                    mensajeRetardado(titulo, "Saliendo del Sistema .", 2500, "success", false);
                    enviaraPagina('', '2501');
                }

            }
        });
    } else {
        return false;
    }

}

function validarContrasenas(pass1, pass2) {


    rta = false;
    if (/[A-Z]/.test(pass1) && /[0-9]/.test(pass1) && pass1.length >= 8 && pass1 == pass2) {
        rta = true;
    }

    return rta;

}

// ###################################################################
// REGISTRO NUEVO USUARIO
// ###################################################################
function registrarUsuario() {

    if (validarDatosBasicosPersona()) {

        if (validarContrasenas($("#txt_pass").val(), $("#txt_pass_confirm").val())) {

            jQuery.ajax({
                url: serverURL + "controllers/ctl_usuario.php",
                method: "POST",
                data: {
                    op: "guardar",
                    dni: $("#txt_dni").val(),
                    nombres: $("#txt_nombres").val(),
                    apellidos: $("#txt_apellidos").val(),
                    direccion: $("#txt_direccion").val(),
                    correo: $("#txt_correo").val(),
                    telefono: $("#txt_telefono").val(),
                    contrasena: $("#txt_pass").val()
                },
                success: function(resp) {

                    //console.log(resp);
                    if (resp == '1') {
                        jQuery('#bodyModal').html("");
                        jQuery('#frmModal').modal('hide');
                        mensajeRetardado("REGISTRO EXITOSO", "Usuario Creado Correctamente.", 2000, "success", false);
                    } else if (resp == '3') {
                        mensajeRetardado("ERROR AL REGISTRAR", "El DNI o Email que intenta registrar ya tiene el nro de registros copado [Usuario y Familiar].", 2000, "error", false);
                        $("#txt_dni").focus();
                        return false;
                    } else {
                        mensajeRetardado("ERROR AL REGISTRAR", "Ocurrio un error, intente nuevamente.", 2000, "error", false);
                        $("#txt_dni").focus();
                        return false;
                    }

                }
            });

        } else {
            $("#txt_pass").val('');
            $("#txt_pass_confirm").val('');
            $("#txt_pass").focus;
            mensajeRetardado('ERROR CONTRASENA', "Las contraseñas deben tener minimo 8 caracteres, deben ser iguales y deben incluir una mayuscula y un numero.", 1000, "warning", false);
            return false;
        }

    } else {
        mensajeRetardado('DATOS IMCOMPLETOS', "Verifique la informacion e intente nuevamente.", 2500, "warning", false);
        return false;
    }

}

// ###################################################################
// Mostrar Form Registro de nuevo familiar
// ###################################################################
function agregarFamiliar() {

    jQuery.ajax({
        url: serverURL + "controllers/ctl_familiar.php",
        method: "POST",
        data: "op=registro",
        success: function(resp) {
            //console.log(resp);
            jQuery('#modalTitulo').html('Registro de Nuevo Familiar');
            jQuery('#bodyModal').html(resp);
            jQuery('#frmModal').modal({ backdrop: 'static', keyboard: false });
            jQuery('#frmModal').modal('show');
        }
    });

}

// ###################################################################
// Guardar nuevo familiar
// ###################################################################
function registrarFamiliar(action = 'guardar') {

    if (validarDatosBasicosPersona()) {


        jQuery.ajax({
            url: serverURL + "controllers/ctl_familiar.php",
            method: "POST",
            data: {
                op: action,
                dni: $("#txt_dni").val(),
                nombres: $("#txt_nombres").val(),
                apellidos: $("#txt_apellidos").val(),
                direccion: $("#txt_direccion").val(),
                correo: $("#txt_correo").val(),
                telefono: $("#txt_telefono").val(),
                parentesco: $("#cmb_parentesco").val()
            },
            success: function(resp) {

                //console.log(resp);

                if (resp == '1') {
                    jQuery('#bodyModal').html("");
                    jQuery('#frmModal').modal('hide');
                    mensajeRetardado("REGISTRO EXITOSO", "Familiar Creado Correctamente.", 2000, "success", false);
                    actualizarListaFamiliares();
                } else if (resp == '3') {
                    mensajeRetardado("ERROR AL REGISTRAR", "El DNI o Email que intenta registrar ya tiene el nro de registros copado [Usuario y Familiar].", 2000, "error", false);
                    $("#txt_dni").focus();
                    return false;
                } else {
                    mensajeRetardado("ERROR AL REGISTRAR", "Ocurrio un error, intente nuevamente.", 2000, "error", false);
                    $("#txt_dni").focus();
                    return false;
                }

            }
        });

    } else {
        mensajeRetardado('DATOS IMCOMPLETOS', "Verifique la informacion e intente nuevamente.", 2500, "warning", false);
        return false;
    }

}
// ###################################################################
// Carga datos en form para editar familiar
// ###################################################################
function editarFamiliar(id) {

    jQuery.ajax({
        url: serverURL + "controllers/ctl_familiar.php",
        method: "POST",
        data: {
            op: 'actualizarFamiliar',
            dni: id
        },
        success: function(resp) {
            //console.log(resp);
            jQuery('#modalTitulo').html('Actualizar Familiar');
            jQuery('#bodyModal').html(resp);
            jQuery('#frmModal').modal({ backdrop: 'static', keyboard: false });
            jQuery('#frmModal').modal('show');
        }
    });


}
// ###################################################################
// Refresca grid de familiares
// ###################################################################
function actualizarListaFamiliares() {


    jQuery.ajax({
        url: serverURL + "controllers/ctl_familiar.php",
        method: "POST",
        data: {
            op: "listar"
        },
        success: function(resp) {
            //console.log(resp);
            jQuery('#capaContenido').html(resp);
        }
    });

}
// ###################################################################
// Eliminacion de familiar
// ###################################################################
function eliminarFamiliar(id) {

    var r = confirm("Realmente Desea Eliminar EL Familiar?");

    if (r == true) {
        $.ajax({
            url: serverURL + "controllers/ctl_familiar.php",
            type: "POST",
            data: {
                op: 'eliminarFamiliar',
                dni: id
            },
            success: function(opciones) {

                //console.log(opciones);
                if (opciones == '1') {
                    mensajeRetardado("ELIMINACION EXITOSA", "Familiar Eliminado Correctamente.", 2000, "success", false);
                    actualizarListaFamiliares();
                } else {
                    mensajeRetardado("Inicio de sesión fallido", "Datos erroneos o usuario inactivo, contacte al administrador.", 2000, "warning", false);
                    $("#txt_email").focus();
                    return false;
                }


            }
        });
    } else {
        return false;
    }



}
// ###################################################################
// Mensaje para eliminar familiar que no se puede: Alerta desde click
// ###################################################################
function eliminarFamiliarFail() {
    mensajeRetardado('PROCESO FALLIDO', "El familiar no puede ser eliminado porque esta registrado como usuario.", 2500, "warning", false);
}
// ###################################################################
// Mensaje: Alerta desde click tarea pendiente
// ###################################################################
function recuperarContrasena() {
    mensajeRetardado("EN CONSTRUCCION", "Estamos trabajando para mejorar.", 2000, "warning", false);
    $("#txt_email").focus();
    return false;
}