/*
    Nombre: notas.js
    Objetivo/propósito: archivo de control para notas. Muestra y oculta las notas clínicas, listado de notas clínicas registradas, edita y elimina notas.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 02/enero/2020
    Versión: 1.0
*/

//Variable global que contenga todos los datos del datatable
var tabla;
//Función que se ejecuta siempre al inicio
function init() {
    mostrarFormulario(false);
    listar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar2(e);
    });
    $.post("../ajax/paciente.php?op=selectMedico", function(r) { //Metodo resound
        $("#id_medico").html(r);
        $('#id_medico').selectpicker('refresh');
    });
    $.post("../ajax/cita.php?op=selectPaciente", function(r) { //Metodo resound
        $("#id_paciente").html(r);
        $('#id_paciente').selectpicker('refresh');
    });
}
//Función para limpiar formulario (Jquery)
function limpiar() {
    $("#id_medico").val("");
    $("#id_paciente").val("");
    $("#notas_clinicas").val("");
}
//Función actualiza el tamaño de un textarea automáticamente
function auto_grow(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight + 50) + "px";
}
//Función para mostrar formulario
function mostrarFormulario(bandera) {
    if (bandera) { //Cuando es true es para mostrar el formulario
        $("#listadoRegPac").hide();
        $("#formularioRegPac").show();
        $("#btnAgregar").hide();
        window.scrollTo(0, 0);
    } else {
        $("#listadoRegPac").show();
        $("#formularioRegPac").hide();
        $("#btnAgregar").show();
    }
}
//Función para cancelar registro
function cancelarFormulario(bandera) {
    limpiar();
    mostrarFormulario(false);
}
//Función que hace una petición AJAX para listar notas
function listar() {
    tabla = $('#tablalistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento de datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos de control de la tabla
        //Para poder exportar los elementos de manera interna
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/paciente.php?op=listarNotas', //por método get enviamos a op el valor listar
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
//función para guardar y editar notas clínicas
function guardaryeditar(e) {
    e.preventDefault(); //Petición jquery para que no se ejecute la acción predeterminada
    $("#btnGuardar").prop("disabled", true); //Se va a deshabilitar el botón
    var formData = new FormData($("#formulario")[0]); //Datos almacenados
    $.ajax({
        url: "../ajax/paciente.php?op=notas_clinicas", //petición a ajax
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
//Función para imprimir una nota clínica
function imprimir(e) {
    window.print();
}
//Función para vaciar una nota clínica
function vaciarForm1(e) {
    e.preventDefault;
    document.getElementById('notas_clinicas').value = "";
}
//Función que muestre los datos del paciente a modificar
function mostrar(id_paciente) {
    $.post("../ajax/paciente.php?op=mostrar", { id_paciente: id_paciente }, function(data, status) {
            data = JSON.parse(data);
            mostrarFormulario(true);
            $("#id_paciente").val(data.id_paciente);
            $('#id_paciente').selectpicker('refresh');
            $("#notas_clinicas").val(data.notas_clinicas);
        })
        //URL: a donde enviaré los datos, POST: Valor que estoy recibiendo
}
//Función para eliminar las notas clínicas de un paciente
function eliminarNotas(id_paciente) {
    bootbox.confirm("¿Está seguro de eliminar las notas de este paciente?", function(result) {
        if (result) {
            $.post("../ajax/paciente.php?op=eliminarNotas", { id_paciente: id_paciente }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Inicio la funcion al final
init();