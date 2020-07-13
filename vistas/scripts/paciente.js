/*
    Nombre: paciente.js
    Objetivo/propósito: archivo de control para pacientes. Muestra y oculta formularios, listado de los pacientes registrados, guarda y edita  pacientes.
    Creado por: GHAMASWARE
                -Ing. Casillas Toledo Mauricio Enrique
                -Ing. Gómez Segovia Álvaro
                -Ing. Jiménez Ruiz Gustavo Alfredo
                -Ing. Ramírez Martínez Humberto
    Fecha: 22/enero/2020
    Versión: 1.0
*/

//Variable global que contenga todos los datos del datatable
var tabla;
//Función que se ejecuta siempre al inicio
function init() {
    mostrarFormulario(false);
    listar();
    $("#histClinica").on("submit", function(e) {
        guardaryeditar2(e);
    });
    //Cargamos los items al método select de médico
    $.post("../ajax/paciente.php?op=selectMedico", function(r) { //Metodo resound
        $("#id_medico").html(r);
        $('#id_medico').selectpicker('refresh');
    });
    $("#imagen_muestra").hide();
}
//Función para limpiar formulario (Jquery)
function limpiar() {
    $("#id_paciente").val("");
    $("#curp").val("");
    $("#nombre").val("");
    $("#fecha_nacimiento").val("");
    $("#telefono").val("");
    $("#correo").val("");
    $("#direccion").val("");
    $("#genero").val("");
    $("#fecha_registro").val("");
    $("#activo").val("");
    $("#imagen_muestra").attr("src", "");
    $("#imagen_actual").val("");
}
//Función para mostrar formulario
function mostrarFormulario(bandera) {
    limpiar();
    if (bandera) { //Cuando es true es para mostrar el formulario
        $("#listadoRegPac").hide();
        $("#formularioRegPac").show();
        $("#histClinica").show();
        $("#btnAgregar").hide();
        window.scrollTo(0, 0);
    } else {
        $("#listadoRegPac").show();
        $("#histClinica").hide();
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
        //Para poder exportar los elementos de manera externa
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/paciente.php?op=listar', //por método get enviamos a op el valor listar
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
//Función para guardar y editar un paciente
function guardaryeditar(e) {
    e.preventDefault(); //Petición jquery para que no se ejecute la acción predeterminada
    $("#btnGuardar").prop("disabled", true); //Se va a deshabilitar el botón

    //Validaciones de los campos del formulario de registro de pacientes
    var curp, nombre, fecha_nacimiento, telefono, correo, expresionCorreo;

    curp = document.getElementById("curp").value;
    nombre = document.getElementById("nombre").value;
    fecha_nacimiento = document.getElementById("fecha_nacimiento").value;
    telefono = document.getElementById("telefono").value;
    correo = document.getElementById("correo").value;

    expresionCorreo = /\w+@+\w+\.+[a-z]/;

    if (curp.length != 18) {
        alert("Curp no válido, tamaño incorrecto");
    } else if (nombre === "" || fecha_nacimiento === "") {
        alert("Nombre y fecha de nacimiento deben ser llenados.");
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
    } else {

        var formData = new FormData($("#formulario")[0]); //Datos almacenados
        $.ajax({
            url: "../ajax/paciente.php?op=guardaryeditar", //petición a ajax
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
//función para guardar y editar un paciente
function guardaryeditar2(e) {
    e.preventDefault();
    var cadena = '';
    var nombreHist = $('#id1').val();
    var cont = 1;

    while (cont < 123) {
        cadena = cadena + '{' + $('#id' + cont).val() + '}';
        cont = cont + 1;
        if ($('#id2') === "") {
            alert("Nombre del paciente en la historia clínica debe llenarse");
        }
    }
    document.getElementById("historia_clinica").value = cadena;
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
    while (cont < 123) {
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
    $("#formHistoriaClinica")[0].reset();
}
//Función para vaciar un formulario con el botón
function vaciarForm1(e) {
    e.preventDefault();
    $("#formHistoriaClinica")[0].reset();
}
//Función que muestre los datos del paciente a modificar
function mostrar(id_paciente) {
    $.post("../ajax/paciente.php?op=mostrar", { id_paciente: id_paciente }, function(data, status) {
            data = JSON.parse(data);
            mostrarFormulario(true);
            $("#id_paciente").val(data.id_paciente);
            $("#curp").val(data.curp);
            $("#id_medico").val(data.id_medico);
            $('#id_medico').selectpicker('refresh');
            $("#nombre").val(data.nombre);
            $("#fecha_nacimiento").val(data.fecha_nacimiento);
            $("#telefono").val(data.telefono);
            $("#correo").val(data.correo);
            $("#direccion").val(data.direccion);
            $("#genero").val(data.genero);
            $("#fecha_registro").val(data.fecha_registro);
            $("#activo").val(data.activo);
            $("#imagen_muestra").show();
            $("#imagen_muestra").attr("src", "../files/pacientes/" + data.imagen);
            $("#imagen_actual").val(data.imagen);
            llenarForm(data.historia_clinica);
        })
        //URL: a donde enviaré los datos, POST: Valor que estoy recibiendo
}
//Función para desactivar a un paciente
function desactivar(id_paciente) {
    bootbox.confirm("¿Está seguro de desactivar a este paciente?", function(result) {
        if (result) {
            $.post("../ajax/paciente.php?op=desactivar", { id_paciente: id_paciente }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Función para eliminar a un paciente
function eliminar(id_paciente) {
    bootbox.confirm("¿Está seguro de eliminar a este paciente?", function(result) {
        if (result) {
            $.post("../ajax/paciente.php?op=eliminar", { id_paciente: id_paciente }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Función para activar a paciente
function activar(id_paciente) {
    bootbox.confirm("¿Está seguro de activar a este paciente?", function(result) {
        if (result) {
            $.post("../ajax/paciente.php?op=activar", { id_paciente: id_paciente }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
//Inicio la funcion al final
init();