/*
    Nombre: admin.js
    Objetivo/propósito: archivo de control para la pantalla administrador. Muestra y oculta formularios, limpieza de formularios, listado de administradores, elimina administradores.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 27/diciembre/2019
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
//Función para limpiar formulario (Jquery)
function limpiar() {
    $("#id_admin").val("");
    $("#nombre_usuario").val("");
    $("#password").val("");
    $("#imagen_muestra").attr("src", "");
    $("#imagen_actual").val("");
}
//Función para mostrar formulario
function mostrarFormulario(bandera) {
    limpiar();
    if (bandera) { //Cuando es true es para mostrar el formulario
        $("#listadoRegAdmin").hide();
        $("#formularioRegAdmin").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnAgregar").hide();
    } else {
        $("#listadoRegAdmin").show();
        $("#formularioRegAdmin").hide();
        $("#btnAgregar").show();
    }
}
//Función para cancelar registro
function cancelarFormulario(bandera) {
    limpiar();
    mostrarFormulario(false);
}
//Función que hace una petición AJAX para listar a administrador
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
            url: '../ajax/admin.php?op=listar', //por método get enviamos a op el valor listar
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
//función para guardar y editar un administrador
function guardaryeditar(e) {
    e.preventDefault(); //Petición jquery para que no se ejecute la acción predeterminada
    $("#btnGuardar").prop("disabled", true); //Se va a deshabilitar el botón
    var formData = new FormData($("#formulario")[0]); //Datos almacenados
    $.ajax({
        url: "../ajax/admin.php?op=guardaryeditar", //petición a ajax
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
//Función que muestre los datos del administrador que se va a modificar
function mostrar(id_admin) {
    $.post("../ajax/admin.php?op=mostrar", { id_admin: id_admin }, function(data, status) {
        data = JSON.parse(data);
        mostrarFormulario(true);
        $('#id_admin').val(data.id_admin);
        $('#nombre_usuario').val(data.nombre_usuario);
        $('#password').val("");
        $("#imagen_muestra").show();
        $("#imagen_muestra").attr("src", "../files/admin/" + data.imagen);
        $("#imagen_actual").val(data.imagen);
    });
    //URL: a donde enviaré los datos, POST: Valor que estoy recibiendo
}
//Función que elimina a un administrador
function eliminar(id_admin) {
    bootbox.confirm("¿Está seguro de eliminar a este administrador?", function(result) {
        if (result) {
            $.post("../ajax/admin.php?op=eliminar", { id_admin: id_admin }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Inicio la funcion al final
init();