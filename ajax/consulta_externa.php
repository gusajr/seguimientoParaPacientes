<?php  
/*Nombre: consulta_externa.php
Objetivo/propósito: archivo ajax para consultas externas. Peticiones ajax para guardar y editar, eliminar, mostrar, listar.
Creado por: GHAMASWARE
            -Ing. Casillas Toledo Mauricio Enrique
            -Ing. Gómez Segovia Álvaro
            -Ing. Jiménez Ruiz Gustavo Alfredo
            -Ing. Ramírez Martínez Humberto
Fecha: 4/enero/2020
Versión: 1.0*/

session_start();
//Se inicia la sesión del objeto
require_once "../modelos/Consulta_externa.php";
//Se crea una instancia al objeto consulta externa
$consulta_externa=new Consulta_externa();

//Se obtienen los datos de los objetos html, si es que ya han sido enviados, las cajas de texto se vacían
$id_consulta_externa=isset($_POST["id_consulta_externa"])?limpiarCadena($_POST["id_consulta_externa"]):"";
$fecha=isset($_POST["fecha"])?limpiarCadena($_POST["fecha"]):"";
$hora=isset($_POST["hora"])?limpiarCadena($_POST["hora"]):"";
$nombre=isset($_POST["nombre"])?limpiarCadena($_POST["nombre"]):"";
$edad=isset($_POST["edad"])?limpiarCadena($_POST["edad"]):"";
$telefono=isset($_POST["telefono"])?limpiarCadena($_POST["telefono"]):"";
$direccion=isset($_POST["direccion"])?limpiarCadena($_POST["direccion"]):"";
$notas=isset($_POST["notas"])?limpiarCadena($_POST["notas"]):"";

switch($_GET["op"]){
	//Caso para guardar y editar una consulta externa
	case 'guardaryeditar':
		if(empty($id_consulta_externa)){
			//Si el id de consulta externa está vacío se inserta
			$respuesta=$consulta_externa->insertar($fecha, $hora, $nombre, $edad, $telefono, $direccion, $notas);
			echo $respuesta?"Consulta guardada":"Consulta no se pudo guardar";
		}else{
			$respuesta=$consulta_externa->editar($id_consulta_externa, $fecha, $hora, $nombre, $edad, $telefono, $direccion, $notas);
			echo $respuesta?"Consulta actualizada":"Consulta no se pudo actualizar";
		}
	break;
	case 'eliminar':
		$respuesta=$consulta_externa->eliminar($id_consulta_externa);
		echo $respuesta?"Consulta eliminada":"Consulta no se pudo eliminar";
	break;
	//Caso para mostrar las consultas externas
	case 'mostrar':
		$respuesta=$consulta_externa->mostrar($id_consulta_externa);
		//Se codifica en JSON
		echo json_encode($respuesta);
	break;
	//Caso para listar las consultas externas 
	case 'listar':
		$respuesta=$consulta_externa->listar();
		//Declaramos un arreglo de consultas externas 
		$consultas_externas= array();
		while($reg=$respuesta->fetch_object()){
			$consultas_externas[]=array(
				"0"=>'<button class="btn btn-info" onclick="mostrar('.$reg->id_consulta_externa.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="eliminar('.$reg->id_consulta_externa.')"><i class="fa fa-trash"></i></button>',
				"1"=>$reg->fecha,
				"2"=>$reg->hora,
				"3"=>$reg->nombre,
				"4"=>$reg->edad,
				"5"=>$reg->telefono,
				"6"=>$reg->direccion);
		}
		$resultados=array(
			"sEcho"=>1,//información para datatables
			"iTotalRecords"=>count($consultas_externas),//# de consultas externas a datatable
			"iTotalDisplayRecords"=>count($consultas_externas),//# de consultas externas a visualizar en datatable
			"aaData"=>$consultas_externas); //consultas externas con su información
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
}
?>