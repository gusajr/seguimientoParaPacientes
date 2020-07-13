<?php
/*Nombre: consulta_interna.php
Objetivo/propósito: archivo ajax para consultas internas. Peticiones ajax para guardar y editar, eliminar, mostrar, listar.
Creado por: GHAMASWARE
            -Ing. Casillas Toledo Mauricio Enrique
            -Ing. Gómez Segovia Álvaro
            -Ing. Jiménez Ruiz Gustavo Alfredo
            -Ing. Ramírez Martínez Humberto
Fecha: 4/enero/2020
Versión: 1.0*/
	
session_start();
//Se inicia la sesión del objeto
require_once "../modelos/Consulta_interna.php";
//Se crea una instancia al objeto consulta interna
$consulta_interna=new Consulta_interna();

//Se obtienen los datos de los objetos html, si es que ya han sido enviados, las cajas de texto se vacían
$id_consulta_interna=isset($_POST["id_consulta_interna"])?limpiarCadena($_POST["id_consulta_interna"]):"";
$id_medico=isset($_POST["id_medico"])?limpiarCadena($_POST["id_medico"]):"";
$id_paciente=isset($_POST["id_paciente"])?limpiarCadena($_POST["id_paciente"]):"";
$fecha=isset($_POST["fecha"])?limpiarCadena($_POST["fecha"]):"";
$notas=isset($_POST["notas"])?limpiarCadena($_POST["notas"]):"";


switch($_GET["op"]){
	//Caso para guardar y editar un médico
	case 'guardaryeditar':
		if(empty($id_consulta_interna)){
			//Si el id de consulta interna está vacío se inserta
			$respuesta=$consulta_interna->insertar($id_medico, $id_paciente, $fecha, true, $notas);
			echo $respuesta?"Consulta guardada":"Consulta no se pudo guardar";
		}else{
			$respuesta=$consulta_interna->editar($id_consulta_interna, $id_medico, $id_paciente, $fecha, $notas);
			echo $respuesta?"Consulta actualizada":"Consulta no se pudo actualizar";
		}
	break;
	case 'eliminar':
		$respuesta=$consulta_interna->eliminar($id_consulta_interna);
		echo $respuesta?"Consulta eliminada":"Consulta no se pudo eliminar";
	break;
	//Caso para mostrar las consultas internas
	case 'mostrar':
		$respuesta=$consulta_interna->mostrar($id_consulta_interna);
		//Se codifica en JSON
		echo json_encode($respuesta);
	break;
	//Caso para listar las consultas internas
	case 'listar':
		$respuesta=$consulta_interna->listar();
		//Declaramos un arreglo de consultas internas 
		$consultas_internas= array();
		while($reg=$respuesta->fetch_object()){
			$consultas_internas[]=array(
				"0"=>($reg->hospitalizacion)?'<button class="btn btn-info" onclick="mostrar('.$reg->id_consulta_interna.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="eliminar('.$reg->id_consulta_interna.')"><i class="fa fa-trash"></i></button>'.' <button class="btn btn-default" onclick="desactivar('.$reg->id_paciente.')"><i class="fa fa-check"></i></button>':'<button class="btn btn-info" onclick="mostrar('.$reg->id_consulta_interna.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="eliminar('.$reg->id_consulta_interna.')"><i class="fa fa-trash"></i></button>'.' <button class="btn btn-default" onclick="activar('.$reg->id_paciente.')"><i class="fa fa-close"></i></button>',
				"1"=>$reg->fecha,
				"2"=>$reg->nombre_paciente,
				"3"=>$reg->nombre_medico,
				"4"=>($reg->hospitalizacion)?'<span class="label bg-red">Hospitalizado</span>':'<span class="label bg-green">No hospitalizado</span>'); //NO );
		}
		$resultados=array(
			"sEcho"=>1,//información para datatables
			"iTotalRecords"=>count($consultas_internas),//# de consultas internas a datatable
			"iTotalDisplayRecords"=>count($consultas_internas),//# de consultas internas a visualizar en datatable
			"aaData"=>$consultas_internas); //consultas internas con su información
		echo json_encode($resultados);
	break;
	case "selectMedico":
		require_once "../modelos/Medico.php";
		$medico = new Medico();
		
		$respuesta=$medico->select(); //Se guardan todos los registros de la funcion select de médico

		while($reg=$respuesta->fetch_object()){
			echo '<option value='.$reg->id_medico.'>'.$reg->nombre.'</option>';
		}
	break;
	case 'activar':
		$respuesta=$consulta_interna->activar($id_paciente);
		echo $respuesta?"Paciente hospitalizado":"Paciente no pudo marcarse como hospitalizado";
	break;
	case 'desactivar':
		$respuesta=$consulta_interna->desactivar($id_paciente);
		echo $respuesta?"Paciente dado de alta":"Paciente no pudo darse de alta";
	break;
}
?>