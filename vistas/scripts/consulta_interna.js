/*
    Nombre: consulta_interna.js
    Objetivo/propósito: archivo de control para consultas internas. Muestra y oculta formulario de consultas externas, listado de pacientes.
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
    $("#id_consulta_interna").val("");
    $("#id_medico").val("");
    $("#id_paciente").val("");
    $("#hospitalizacion").val("");
    $("#notas").val("");
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
//Función que hace una petición AJAX para listar a paciente
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
            url: '../ajax/consulta_interna.php?op=listar', //por método get enviamos a op el valor listar
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
//función para guardar y editar un paciente
function guardaryeditar(e) {
    e.preventDefault(); //Petición jquery para que no se ejecute la acción predeterminada
    //$("#btnGuardar").prop("disabled",true); //Se va a deshabilitar el botón
    var telefono, fecha;

    fecha = document.getElementById("fecha").value;
    telefono = document.getElementById("id2").value;


    var fecha_actual = new Date();
    fecha_anio = fecha_actual.getFullYear();
    fecha_mes = fecha_actual.getMonth();
    fecha_dia = fecha_actual.getDay();

    var fecha_consulta = new Date(fecha);
    fecha_consulta_anio = fecha_consulta.getFullYear();
    fecha_consulta_mes = fecha_consulta.getMonth();
    fecha_consulta_dia = fecha_consulta.getDay();

    if (fecha_consulta_anio != fecha_anio && fecha_consulta_mes != fecha_mes && fecha_consulta_dia != fecha_dia) {
        aviso = "Verifica la fecha";
        alert(aviso);
    } else {
        if (telefono.length != 10) {
            alert("Longitud de teléfono no válida (10 dígitos).");
        } else if (isNaN(telefono)) {
            alert("Teléfono no es un número.");
        } else {

            var formData = new FormData($("#formulario")[0]); //Datos almacenados

            $.ajax({
                url: "../ajax/consulta_interna.php?op=guardaryeditar", //petición a ajax
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
//función para guardar y editar un paciente
function guardaryeditar2(e) {
    e.preventDefault();
    var cadena = '';
    var cont = 1;
    while (cont < 16) {
        cadena = cadena + '{' + $('#id' + cont).val() + '}';
        cont = cont + 1;
    }
    //alert(cadena);
    document.getElementById("notas").value = cadena;
    guardaryeditar(e);
}

function imprimir(e) {
    window.print();
}

function llenarForm(cadena) {
    cadena = new String(cadena);
    //alert("si entro");
    var datos = "";
    var cont = 1;
    var palabra = 0;
    //alert('si entra');
    while (cont < 16) {
        if (cadena.charAt(0) != "{") {
            break;
        }
        if (cadena.charAt(palabra) == "{") {} else if (cadena.charAt(palabra) == "}") {
            //alert(datos);
            document.getElementById('id' + cont).value = datos;
            datos = "";
            cont = cont + 1;
        } else {
            datos = datos + cadena.charAt(palabra);
        }
        palabra = palabra + 1;
    }
}

function vaciarForm() {
    $("#formulario")[0].reset();
}

function vaciarForm1(e) {
    e.preventDefault();
    $("#formulario")[0].reset();
}
//Función que muestre los datos del paciente a modificar
function mostrar(id_consulta_interna) {
    //alert(data);
    //llenarForm(data.historia_clinica);
    $.post("../ajax/consulta_interna.php?op=mostrar", { id_consulta_interna: id_consulta_interna }, function(data, status) {
        data = JSON.parse(data);
        mostrarFormulario(true);
        $("#id_consulta_interna").val(data.id_consulta_interna);
        $("#id_medico").val(data.id_medico);
        $('#id_medico').selectpicker('refresh');
        $("#id_paciente").val(data.id_paciente);
        $('#id_paciente').selectpicker('refresh');
        $("#hospitalizacion").val(data.hospitalizacion);
        llenarForm(data.notas);
    })

    //URL a donde enviaré los datos, POST//Valor que estoy recibiendo
}
//Función para eliminar a un paciente
function eliminar(id_consulta_interna) {
    bootbox.confirm("¿Está seguro de eliminar esta consulta?", function(result) {
        if (result) {
            $.post("../ajax/consulta_interna.php?op=eliminar", { id_consulta_interna: id_consulta_interna }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

//Función para activar hospitalizacion
function activar(id_paciente) {
    bootbox.confirm("¿Está seguro que desea marcar como hospitalizado a este paciente?", function(result) {
        if (result) {
            $.post("../ajax/consulta_interna.php?op=activar", { id_paciente: id_paciente }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

function desactivar(id_paciente) {
    bootbox.confirm("¿Está seguro que desea dar de alta a este paciente?", function(result) {
        if (result) {
            $.post("../ajax/consulta_interna.php?op=desactivar", { id_paciente: id_paciente }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Inicio la funcion al final
init();