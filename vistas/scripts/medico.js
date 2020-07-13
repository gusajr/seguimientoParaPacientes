/*
    Nombre: medico.js
    Objetivo/propósito: archivo de control para médicos. Muestra y oculta formularios de médico, listado de médicos registrados, activa y desactiva, guarda y edita médicos.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 22/diciembre/2019
    Versión: 1.0
*/

//Variable global que contenga todos los datos del datatable
var tabla;
//Función que se ejecuta siempre al inicio
function init() {
    mostrarFormulario(false);
    listar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });
    $("#imagen_muestra").hide();
}
//Función para limpiar formulario
function limpiar() {
    $("#id_medico").val("");
    $("#nombre").val("");
    $("#especialidad").val("");
    $("#telefono").val("");
    $("#correo").val("");
    $("#cedula").val("");
    $("#hora_entrada").val("");
    $("#hora_salida").val("");
    $("#password").val("");
    $("#activo").val("");
    $("#imagen_muestra").attr("src", "");
    $("#imagen_actual").val("");
}
//Función para mostrar formulario
function mostrarFormulario(bandera) {
    limpiar();
    if (bandera) { //Cuando es true es para mostrar el formulario
        $("#listadoRegMed").hide();
        $("#formularioRegMed").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnAgregar").hide();
    } else {
        $("#listadoRegMed").show();
        $("#formularioRegMed").hide();
        $("#btnAgregar").show();
    }
}
//Función para cancelar registro
function cancelarFormulario(bandera) {
    limpiar();
    mostrarFormulario(false);
}
//Función que hace una petición AJAX para listar a médico
function listar() {
    tabla = $('#tablalistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento de datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos de control de la tabla
        //Para poder exportar los elementos de manera externa
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/medico.php?op=listar', //por método get enviamos a op el valor listar
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLenght": 5, //Paginación
        "order": [
                [0, "desc"]
            ] //Ordenamos de manera descendente (columna, orden)
    }).DataTable();
}
//función para guardar y editar un médico
function guardaryeditar(e) {
    e.preventDefault(); //Petición jquery para que no se ejecute la acción predeterminada
    //Validaciones de los campos de registro
    var nombre, telefono, correo, cedula, password, especialidad, expresionCorreo;

    nombre = document.getElementById("nombre").value;
    telefono = document.getElementById("telefono").value;
    correo = document.getElementById("correo").value;
    cedula = document.getElementById("cedula").value;
    password = document.getElementById("password").value;
    especialidad = document.getElementById("especialidad").value;

    expresionCorreo = /\w+@+\w+\.+[a-z]/;

    if (nombre === "" || telefono === "" || correo === "" || cedula === "" || password === "" || especialidad === "") {
        alert("El campo nombre, especialidad, telefono, correo, cedula, y password debe ingresarse");
    } else if (nombre.length > 60) {
        alert("El nombre del paciente debe ser menor a 60 caracteres.");
    } else if (telefono.length != 10) {
        alert("Longitud de teléfono no válida (10 dígitos).");
    } else if (isNaN(telefono)) {
        alert("Teléfono no es un número.");
    } else if (correo.length > 60) {
        alert("Correo no válido, demasiado largo.");
    } else if (!expresionCorreo.test(correo)) {
        alert("Correo no válido, no se cumple el formato 'nombre_de_usuario@dominio.dominio'");
    } else if (cedula.length != 11) {
        alert("Cedula errónea, longitud diferente de 11 caracteres.");
    } else if (isNaN(cedula)) {
        alert("Cedula errónea, no es un número.");
    } else {
        var formData = new FormData($("#formulario")[0]); //Datos almacenados
        $.ajax({
            url: "../ajax/medico.php?op=guardaryeditar", //petición a ajax
            type: "POST", //Método de envío
            data: formData, //Lugar de extracción de datos
            contentType: false,
            processData: false,

            success: function(datos) {
                bootbox.alert(datos);
                mostrarFormulario(false);
                tabla.ajax.reload(); //Recarga el datatable
            }
        });
        limpiar();
    }
}
//Función que muestre los datos del médico que quiero modificar
function mostrar(id_medico) {
    $.post("../ajax/medico.php?op=mostrar", { id_medico: id_medico }, function(data, status) {
            data = JSON.parse(data);
            mostrarFormulario(true);

            $('#id_medico').val(data.id_medico);
            $('#nombre').val(data.nombre);
            $('#especialidad').val(data.especialidad);
            $('#telefono').val(data.telefono);
            $('#correo').val(data.correo);
            $('#cedula').val(data.cedula);
            $('#hora_entrada').val(data.hora_entrada);
            $('#hora_salida').val(data.hora_salida);
            $('#password').val("");
            $('#activo').val(data.activo);
            $("#imagen_muestra").show();
            $("#imagen_muestra").attr("src", "../files/medicos/" + data.imagen);
            $("#imagen_actual").val(data.imagen);
        })
        //URL: a donde enviaré los datos, POST: Valor que estoy recibiendo
}
//Función para desactivar a médico
function desactivar(id_medico) {
    bootbox.confirm("¿Está seguro de desactivar a este médico?", function(result) {
        if (result) {
            $.post("../ajax/medico.php?op=desactivar", { id_medico: id_medico }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Función para activar a médico
function activar(id_medico) {
    bootbox.confirm("¿Está seguro de activar a este médico?", function(result) {
        if (result) {
            $.post("../ajax/medico.php?op=activar", { id_medico: id_medico }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Inicio la funcion al final
init();