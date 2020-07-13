/*
    Nombre: cita.js
    Objetivo/propósito: archivo de control para la creacion de citas. Activa y desactiva citas, listado de citas, formulario de citas, eliminar citas, guardado de citas.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 2/enero/2020
    Versión: 1.0
*/

//Variable global que contenga todos los datos del datatable
var tabla;
//Función que se ejecuta siempre al inicio
function init() {
    mostrarFormulario(false);
    listar();
    $("#formularioCita").on("submit", function(e) {
        guardaryeditar(e);
    });
    //Cargamos los items al método select de paciente
    $.post("../ajax/cita.php?op=selectPaciente", function(r) { //Metodo resound
        $("#id_paciente").html(r);
        $('#id_paciente').selectpicker('refresh');
    });
}
//Función para limpiar formulario (Jquery)
function limpiar() {
    $("#id_paciente").val("");
    $("#nombre_paciente").val("");
    $("#fecha").val("");
    $("#hora_inicio").val("");
    $("#hora_incio_redondeada").val("");
    $("#hora_fin").val("");

}
//Función para mostrar formulario
function mostrarFormulario(bandera) {
    limpiar();
    if (bandera) { //Cuando es true es para mostrar el formulario
        $("#listadoRegCita").hide();
        $("#formularioRegCita").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnAgregar").hide();
    } else {
        $("#listadoRegCita").show();
        $("#formularioRegCita").hide();
        $("#btnAgregar").show();
    }
}
//Función para cancelar registro
function cancelarFormulario(bandera) {
    limpiar();
    mostrarFormulario(false);
}
//Función que hace una petición AJAX para listar las citas
function listar() {
    tabla = $('#tablalistadoCita').dataTable({
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
            url: '../ajax/cita.php?op=listar', //por método get enviamos a op el valor listar
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
//función para guardar y editar una cita
function guardaryeditar(e) {
    e.preventDefault(); //Petición jquery para que no se ejecute la acción predeterminada

    var hora_inicio = $('#hora_inicio').val();
    var id_paciente = $('#id_paciente').val();

    var id_medico = $('#id_medico').val();
    var fecha = $('#fecha').val();

    var minutosR = hora_inicio.substring(3, 5);
    var horasR = hora_inicio.substring(0, 2);
    horasR = parseInt(horasR);

    if (minutosR <= 15) {
        minutosR = 0;
    } else if (minutosR > 15 && minutosR < 45) {
        minutosR = 30;
    } else if (minutosR >= 45) {
        minutosR = 0;
        horasR = horasR + 1;
        if (horasR == 24) {
            horasR = 0;
        }
    }
    if (minutosR < 10) {
        minutosR = '0' + minutosR.toString();
    }
    if (horasR < 10) {
        horasR = '0' + horasR.toString();
    }

    var minutosF;
    var horasF;

    if (minutosR == 0) {
        minutosF = "30";
        horasF = horasR;
    } else {
        minutosF = "00";
        horasF = (parseInt(horasR) + 1);
        if (horasF < 10) {
            horasF = '0' + horasF.toString();
        }
        if (horasF == 24) {
            horasF = "00";
        }
    }
    horas_inicio_con = horasR + ':' + minutosR + ':00';
    horas_fin_con = horasF + ':' + minutosF + ':00';

    document.getElementById("hora_inicio_redondeada").value = horas_inicio_con;
    document.getElementById("hora_fin").value = horas_fin_con;

    var fecha_actual = new Date();
    fecha_anio = fecha_actual.getFullYear();
    fecha_mes = fecha_actual.getMonth();
    fecha_dia = fecha_actual.getDay();
    var fecha_cita = new Date(fecha);
    fecha_cita_anio = fecha_cita.getFullYear();
    fecha_cita_mes = fecha_cita.getMonth();
    fecha_cita_dia = fecha_cita.getDay();

    var aviso = "";
    if (fecha_cita_anio < fecha_anio) {
        aviso = "Verifica la fecha";
        alert(aviso);
    } else if (fecha_cita_mes < fecha_mes) {
        if (fecha_cita_dia < fecha_dia) {
            aviso = "Verifica la fecha";
            alert(aviso);
        }
    } else {
        var formData = new FormData($("#formularioCita")[0]); //Datos almacenados
        $.ajax({
            url: "../ajax/cita.php?op=guardaryeditar", //petición a ajax
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
//Función para desactivar a una cita 
function desactivar(id_cita) {
    bootbox.confirm("¿Está seguro de desactivar esta cita?", function(result) {
        if (result) {
            $.post("../ajax/cita.php?op=desactivar", { id_cita: id_cita }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Función para eliminar una cita
function eliminar(id_cita) {
    bootbox.confirm("¿Está seguro de eliminar esta cita?", function(result) {
        if (result) {
            $.post("../ajax/cita.php?op=eliminar", { id_cita: id_cita }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Función para activar una cita
function activar(id_cita) {
    bootbox.confirm("¿Está seguro de reactivar esta cita?", function(result) {
        if (result) {
            $.post("../ajax/cita.php?op=activar", { id_cita: id_cita }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Inicio la función al final
init();