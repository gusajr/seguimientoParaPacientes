/*
    Nombre: login.js
	Objetivo/propósito: archivo de control del login del sistema. Valida el tipo de usuario que ingresa al sistema y carga la página correspondiente.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 28/diciembre/2019
    Versión: 1.0
*/

//Se sobreescribe el método y se evaluan las dos posibilidades para tener un inicio de sesión
$("#frmAcceso").on('submit', function(e) {
    e.preventDefault();
    nombre_usuario_acceso = $("#nombre_usuario_acceso").val();
    password_acceso = $("#password_acceso").val();
    //Se envían los datos por metodo post
    $.post("../ajax/admin.php?op=verificar", { "nombre_usuario_acceso": nombre_usuario_acceso, "password_acceso": password_acceso },
        function(data) {
            if (data != "null") {
                $(location).attr("href", "admin.php");
            } else {
                //Si el inicio no es de un administrador entonces será de un médico
                $.post("../ajax/medico.php?op=verificar", { "nombre_usuario_acceso": nombre_usuario_acceso, "password_acceso": password_acceso },
                    function(data) {
                        if (data != "null") {
                            $(location).attr("href", "paciente.php");
                        } else {
                            alert("Usuario y/o password incorrecto");
                        }
                    });
            }
        });
});
//Se manda la petición ajax para iniciar sesión como invitado
$("#frmAcceso1").on('submit', function(e) {
    e.preventDefault();
    nombre_usuario_acceso1 = $("#nombre_usuario_acceso1").val();
    password_acceso1 = $("#password_acceso1").val();
    $.post("../ajax/medico.php?op=invitado", { "nombre_usuario_acceso1": nombre_usuario_acceso1, "password_acceso1": password_acceso1 },
        function(data) {
            if (data != "null") {
                $(location).attr("href", "paciente.php");
            }
        });

});