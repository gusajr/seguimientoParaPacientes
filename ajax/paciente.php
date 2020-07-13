<?php 
/*Nombre: paciente.php
Objetivo/propósito: archivo ajax para paciente. Peticiones ajax para guardar y editar, eliminar, mostrar, listar.
Creado por: GHAMASWARE
            -Ing. Casillas Toledo Mauricio Enrique
            -Ing. Gómez Segovia Álvaro
            -Ing. Jiménez Ruiz Gustavo Alfredo
            -Ing. Ramírez Martínez Humberto
Fecha: 23/diciembre/2019
Versión: 1.0*/

//Se extrae la información de clase Paciente
require_once "../modelos/Paciente.php";
//Se crea una instancia al objeto Paciente
$paciente=new Paciente();

//Se obtienen los datos de los objetos html, si es que ya han sido enviados, las cajas de texto se vacían
$id_paciente=isset($_POST["id_paciente"])?limpiarCadena($_POST["id_paciente"]):"";
$curp=isset($_POST["curp"])?limpiarCadena($_POST["curp"]):"";
$id_medico=isset($_POST["id_medico"])?limpiarCadena($_POST["id_medico"]):"";
$nombre=isset($_POST["nombre"])?limpiarCadena($_POST["nombre"]):"";
$fecha_nacimiento=isset($_POST["fecha_nacimiento"])?limpiarCadena($_POST["fecha_nacimiento"]):"";
$telefono=isset($_POST["telefono"])?limpiarCadena($_POST["telefono"]):"";
$correo=isset($_POST["correo"])?limpiarCadena($_POST["correo"]):"";
$direccion=isset($_POST["direccion"])?limpiarCadena($_POST["direccion"]):"";
$genero=isset($_POST["genero"])?limpiarCadena($_POST["genero"]):"";
$fecha_registro=isset($_POST["fecha_registro"])?limpiarCadena($_POST["fecha_registro"]):"";
$activo=isset($_POST["activo"])?limpiarCadena($_POST["activo"]):"";
$imagen=isset($_POST["imagen"])?limpiarCadena($_POST["imagen"]):"";
$historia_clinica=isset($_POST["historia_clinica"])?limpiarCadena($_POST["historia_clinica"]):"";
$notas_clinicas=isset($_POST["notas_clinicas"])?limpiarCadena($_POST["notas_clinicas"]):"";

//Realizaremos peticiones mediante el metodo AJAX
switch($_GET["op"]){
	//Caso para guardar y editar a un paciente
	case 'guardaryeditar':
		//Se verifica que la imagen haya sido subida anteriormente
		if(!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])){
			$imagen=$_POST["imagen_actual"];
		}else{
		//Se establece una imagen extraída del dispositivo donde se encuentra el usuario
			$extension=explode(".",$_FILES["imagen"]["name"]);
			if(($_FILES['imagen']['type']=="image/jpg")||($_FILES['imagen']['type']=="image/jpeg")||($_FILES['imagen']['type']=="image/png")){
				$imagen=round(microtime('time')).'.'.end($extension);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/pacientes/".$imagen);
			}
		}
		//Si el campo de id_paciente está vacío se inserta un nuevo paciente de lo contario sólo se edita 
		if(empty($id_paciente)){
			//Si no se insertó ninguna imagen se coloca una por default
			if($imagen==''){
				$imagen='000000000.png';
			}
			$respuesta=$paciente->insertar($curp, $id_medico, $nombre, $fecha_nacimiento, $telefono, $correo, $direccion, $genero, $fecha_registro, true, $imagen, $historia_clinica);
			echo $respuesta?"Paciente registrado":"Paciente no se pudo registrar";
		}else{
			$respuesta=$paciente->editar($id_paciente, $curp, $id_medico, $nombre, $fecha_nacimiento, $telefono, $correo, $direccion, $genero, $fecha_registro, $activo, $imagen, $historia_clinica);
			echo $respuesta?"Paciente actualizado":"Paciente no se pudo actualizar";
		}
	break;
	//Caso para agregar una nota clínica a un paciente 
	case 'notas_clinicas':
		$respuesta=$paciente->notas($id_paciente, $notas_clinicas);
		echo $respuesta?"Notas agregadas correctamente":"Notas no se pudieron agregar";
	break;
	//Caso para desactivar a un paciente
	case 'desactivar':
		$respuesta=$paciente->desactivar($id_paciente);
		echo $respuesta?"Paciente marcado como inactivo":"Paciente no se pudo marcar como inactivo";
	break;
	//Caso para eliminar a un paciente
	case 'eliminar':
		$respuesta=$paciente->eliminar($id_paciente);
		echo $respuesta?"Paciente eliminado":"Paciente no se pudo eliminar";
	break;
	//Caso para activar a un paciente
	case 'activar':
		$respuesta=$paciente->activar($id_paciente);
		echo $respuesta?"Paciente marcado como activo":"Paciente no se pudo marcar como activo";
	break;
	//Caso para mostrar pacientes
	case 'mostrar':
		$respuesta=$paciente->mostrar($id_paciente);
		//Se codifica en JSON
		echo json_encode($respuesta);
	break;
	//Caso para listar pacientes
	case 'listar':
		$respuesta=$paciente->listar();
		//Declaramos un arreglo de pacientes
		$pacientes= array();
		while($reg=$respuesta->fetch_object()){
			$pacientes[]=array(
				"0"=>($reg->activo)?'<button class="btn btn-info" onclick="mostrar('.$reg->id_paciente.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-success" onclick="desactivar('.$reg->id_paciente.')"><i class="fa fa-check"></i></button>':'<button class="btn btn-info" onclick="mostrar('.$reg->id_paciente.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-warning" onclick="activar('.$reg->id_paciente.')"><i class="fa fa-close"></i></button>',
				"1"=>$reg->curp,				
				"2"=>$reg->nombre,
				"3"=>$reg->nombre_medico,
				"4"=>"<img src='../files/pacientes/".$reg->imagen."' height='50px' width='50px'>",
				"5"=>$reg->fecha_nacimiento,
				"6"=>$reg->telefono,
				"7"=>$reg->correo,
				"8"=>$reg->direccion,
				"9"=>$reg->genero,
				"10"=>$reg->fecha_registro);
		}
		$resultados=array(
			"sEcho"=>1,//información para datatables
			"iTotalRecords"=>count($pacientes),//# de pacientes a datatable
			"iTotalDisplayRecords"=>count($pacientes),//# de pacientes a visualizar en datatable
			"aaData"=>$pacientes); //Pacientes con su información
		echo json_encode($resultados);
	break;
	//Caso para listar notas clínicas
	case 'listarNotas':
		$respuesta=$paciente->listarN();
		//Declaramos un arreglo de pacientes
		$pacientes= array();
		while($reg=$respuesta->fetch_object()){
			$pacientes[]=array(
				"0"=>'<button class="btn btn-info" onclick="mostrar('.$reg->id_paciente.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="eliminarNotas('.$reg->id_paciente.')"><i class="fa fa-trash"></i></button>',
				"1"=>$reg->nombre,
				"2"=>$reg->nombre_medico,
				"3"=>$reg->fecha_registro);
		}
		$resultados=array(
			"sEcho"=>1,//información para datatables
			"iTotalRecords"=>count($pacientes),//# de pacientes a datatable
			"iTotalDisplayRecords"=>count($pacientes),//# de pacientes a visualizar en datatable
			"aaData"=>$pacientes); //Pacientes con su información
		echo json_encode($resultados);
	break;
	//Caso para eliminar nota clínica de un paciente
	case 'eliminarNotas':
		$respuesta=$paciente->eliminarNotas($id_paciente);
		echo $respuesta?"Notas eliminadas":"Notas no se pudieron eliminar";
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