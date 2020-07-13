<?php
/*Nombre: cita.php
Objetivo/propósito: archivo ajax para citas. Peticiones ajax para guardar y editar, eliminar, mostrar, listar.
Creado por: GHAMASWARE
			-Ing. Casillas Toledo Mauricio Enrique
			-Ing. Gómez Segovia Álvaro
			-Ing. Jiménez Ruiz Gustavo Alfredo
			-Ing. Ramírez Martínez Humberto
Fecha: 2/enero/2020
Versión: 1.0*/

//Se extrae la información de clase Cita
require_once "../modelos/Cita.php";
//Se crea una instancia al objeto Cita
$cita=new Cita();

//Se obtienen los datos de los objetos html, si es que ya han sido enviados, las cajas de texto se vacían
$id_cita=isset($_POST["id_cita"])?limpiarCadena($_POST["id_cita"]):"";
$id_paciente=isset($_POST["id_paciente"])?limpiarCadena($_POST["id_paciente"]):"";
$id_medico=isset($_POST["id_medico"])?limpiarCadena($_POST["id_medico"]):"";
$nombre_paciente=isset($_POST["nombre_paciente"])?limpiarCadena($_POST["nombre_paciente"]):"";
$nombre_medico=isset($_POST["nombre_medico"])?limpiarCadena($_POST["nombre_medico"]):"";
$fecha=isset($_POST["fecha"])?limpiarCadena($_POST["fecha"]):"";
$hora_inicio=isset($_POST["hora_inicio"])?limpiarCadena($_POST["hora_inicio"]):"";
$hora_inicio_redondeada=isset($_POST["hora_inicio_redondeada"])?limpiarCadena($_POST["hora_inicio_redondeada"]):"";
$hora_fin=isset($_POST["hora_fin"])?limpiarCadena($_POST["hora_fin"]):"";
$comentarios=isset($_POST["comentarios"])?limpiarCadena($_POST["comentarios"]):"";

//Realizaremos peticiones mediante el metodo AJAX
switch($_GET["op"]){
	//Caso para guardar y editar una cita
	case 'guardaryeditar':
		$respuesta=$cita->checarCita($id_paciente, $id_medico, $fecha, $hora_inicio_redondeada); 
		//Se utiliza para checar si la cita ya fue registrada
		if($respuesta==null){
			//Si no fue registrada se inserta una nueva
			$respuesta=$cita->insertar($id_paciente, $id_medico, $fecha, $hora_inicio_redondeada, $hora_fin, $comentarios, true);
			echo "Cita registrada";
		}else{
			echo "Horario/Medico/Paciente no disponible"; 
		}
	break;
	//Caso para desactivar una cita
	case 'desactivar':
		$respuesta=$cita->desactivar($id_cita);
		echo $respuesta?"Cita desactivada":"Cita no se pudo marcar como inactiva";
	break;
	//Caso para eliminar una cita
	case 'eliminar':
		$respuesta=$cita->eliminar($id_cita);
		echo $respuesta?"Cita eliminada":"Cita no se pudo eliminar";
	break;
	//Caso para activar una cita
	case 'activar':
		$respuesta=$cita->activar($id_cita);
		echo $respuesta?"Cita marcada como activa":"Cita no se pudo marcar como activa";
	break;
	//Caso para mostrar las citas
	case 'mostrar':
		$respuesta=$cita->mostrar($id_paciente, $id_medico);
		//Se codifica en JSON
		echo json_encode($respuesta);
	break;
	//Caso para listar las citas
	case 'listar':
		$respuesta=$cita->listar();
		//Declaramos un arreglo de citas
		$citas= array();
		while($reg=$respuesta->fetch_object()){
			$citas[]=array(
				"0"=>($reg->activo)?'<button class="btn btn-primary" onclick="desactivar('.$reg->id_cita.')"><i class="fa fa-check"></i></button>'.' <button class="btn btn-danger" onclick="eliminar('.$reg->id_cita.')"><i class="fa fa-trash"></i></button>':' <button class="btn btn-warning" onclick="activar('.$reg->id_cita.')"><i class="fa fa-close"></i></button>'.' <button class="btn btn-danger" onclick="eliminar('.$reg->id_cita.')"><i class="fa fa-trash"></i></button>',
				"1"=>$reg->nombre_paciente,
				"2"=>$reg->fecha,
				"3"=>$reg->nombre_medico,
				"4"=>$reg->especialidad_medico,
				"5"=>$reg->hora_inicio,
				"6"=>$reg->hora_fin,
				"7"=>$reg->comentarios,
				"8"=>($reg->activo)?'<span class="label bg-green">Activa</span>':'<span class="label bg-red">No activa</span>');
		}
		$resultados=array(
			"sEcho"=>1,//información para datatables
			"iTotalRecords"=>count($citas),//# de citas a datatable
			"iTotalDisplayRecords"=>count($citas),//# de citas a visualizar en datatable
			"aaData"=>$citas); //Médicos con su información
		echo json_encode($resultados);
	break;

	case "selectPaciente":
		require_once "../modelos/Paciente.php";
		$paciente = new Paciente();
		
		$respuesta=$paciente->select(); //Se guardan todos los registros de la funcion select de paciente

		while($reg=$respuesta->fetch_object()){
			echo '<option value='.$reg->id_paciente.'>'.$reg->nombre.'</option>';
		}
	break;

}
?>