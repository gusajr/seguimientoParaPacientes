/*
    Nombre: consulta_externa.js
    Objetivo/propósito: archivo de control para consultas Externas. Muestra y oculta formulario de consultas externas, listado de pacientes
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 3/enero/2020
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
}
//Función para limpiar formulario (Jquery)
function limpiar() {
    $("#id_consulta_externa").val("");
    $("#fecha").val("");
    $("#hora").val("");
    $("#nombre").val("");
    $("#edad").val("");
    $("#telefono").val("");
    $("#direccion").val("");
}
//Función para mostrar formulario
function mostrarFormulario(bandera) {
    limpiar();
    if (bandera) { //Cuando es true es para mostrar el formulario
        $("#listadoRegPac").hide();
        $("#formularioRegPac").show();
        $("#btnAgregar").hide();
        vaciarForm();
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
//Función que hace una petición AJAX para listar las consultas externas
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
            url: '../ajax/consulta_externa.php?op=listar', //por método get enviamos a op el valor listar
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
//función para guardar y editar una consulta externa
function guardaryeditar(e) {
    e.preventDefault(); //Petición jquery para que no se ejecute la acción predeterminada

    var nombre, telefono, edad, fecha;

    fecha = document.getElementById("fecha").value;
    nombre = document.getElementById("nombre").value;
    telefono = document.getElementById("telefono").value;
    edad = document.getElementById("edad").value;

    var fecha_actual = new Date();
    fecha_anio = fecha_actual.getFullYear();
    fecha_mes = fecha_actual.getMonth();
    fecha_dia = fecha_actual.getDay();

    var fecha_consulta = new Date(fecha);
    fecha_consulta_anio = fecha_consulta.getFullYear();
    fecha_consulta_mes = fecha_consulta.getMonth();
    fecha_consulta_dia = fecha_consulta.getDay();

    /*alert(fecha);
    alert(fecha_actual);
    alert(fecha_consulta);

    alert(fecha_consulta_dia);
    alert(fecha_dia);

    alert(fecha_consulta_anio == fecha_anio);
    alert(fecha_consulta_mes == fecha_mes);
    alert(fecha_consulta_dia == fecha_dia);*/

    if ((fecha_consulta_anio != fecha_anio) && (fecha_consulta_mes != fecha_mes) && (fecha_consulta_dia != fecha_dia)) {
        aviso = "Verifica la fecha";
        alert(aviso);
    } else {
        if (nombre === "") {
            alert("El campo nombre no puede estar vacío.");
        } else if (nombre.length > 60) {
            alert("Nombre del paciente demasiado largo.");
        } else if (telefono.length != 10) {
            alert("Longitud de teléfono no válida (10 dígitos).");
        } else if (isNaN(telefono)) {
            alert("Teléfono no es un número.");
        } else if (isNaN(edad)) {
            alert("Campo edad no contiene una edad.");
        } else {

            var formData = new FormData($("#formulario")[0]); //Datos almacenados
            $.ajax({
                url: "../ajax/consulta_externa.php?op=guardaryeditar", //petición a ajax
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
}
//función para guardar y editar una consulta externa
function guardaryeditar2(e) {
    e.preventDefault();
    var cadena = '';
    var cont = 1;
    while (cont < 14) {
        cadena = cadena + '{' + $('#id' + cont).val() + '}';
        cont = cont + 1;
    }
    document.getElementById("notas").value = cadena;
    guardaryeditar(e);
}
//Función para imprimir
function imprimir(e) {
    window.print();
}
//Función para llenar un formulario 
function llenarForm(cadena) {
    cadena = new String(cadena);
    var datos = "";
    var cont = 1;
    var palabra = 0;
    while (cont < 14) {
        if (cadena.charAt(0) != "{") {
            break;
        }
        if (cadena.charAt(palabra) == "{") {} else if (cadena.charAt(palabra) == "}") {
            document.getElementById('id' + cont).value = datos;
            datos = "";
            cont = cont + 1;
        } else {
            datos = datos + cadena.charAt(palabra);
        }
        palabra = palabra + 1;
    }
}
//Función para vaciar un formulario
function vaciarForm() {
    $("#formulario")[0].reset();
}
//Función para vaciar un formulario desde el botón
function vaciarForm1(e) {
    e.preventDefault();
    $("#formulario")[0].reset();
}
//Función que muestre los datos del paciente a modificar
function mostrar(id_consulta_externa) {
    $.post("../ajax/consulta_externa.php?op=mostrar", { id_consulta_externa: id_consulta_externa }, function(data, status) {
        data = JSON.parse(data);
        mostrarFormulario(true);
        $("#id_consulta_externa").val(data.id_consulta_externa);
        $("#fecha").val(data.fecha);
        $("#hora").val(data.hora);
        $("#nombre").val(data.nombre);
        $("#edad").val(data.edad);
        $("#telefono").val(data.telefono);
        $("#direccion").val(data.direccion);
        llenarForm(data.notas);
    })

    //URL: a donde enviaré los datos, POST: Valor que estoy recibiendo
}
//Función para eliminar una consulta externa
function eliminar(id_consulta_externa) {
    bootbox.confirm("¿Está seguro de eliminar esta consulta?", function(result) {
        if (result) {
            $.post("../ajax/consulta_externa.php?op=eliminar", { id_consulta_externa: id_consulta_externa }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Inicio la funcion al final
init();