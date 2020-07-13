<?php  
/*Nombre: medico.php
Objetivo/propósito: archivo ajax para medico. Peticiones ajax para guardar y editar, eliminar, mostrar, listar, verificar y salir del sistema y en caso de ser un médico invitado.
Creado por: GHAMASWARE
			-Ing. Casillas Toledo Mauricio Enrique
			-Ing. Gómez Segovia Álvaro
            -Ing. Jiménez Ruiz Gustavo Alfredo
            -Ing. Ramírez Martínez Humberto
Fecha: 23/diciembre/2019
Versión: 1.0*/


session_start();
//Se inicia la sesión del objeto
require_once "../modelos/Medico.php";
//Se crea una instancia al objeto Médico
$medico=new Medico();

//Se obtienen los datos de los objetos html, si es que ya han sido enviados, las cajas de texto se vacían
$id_medico=isset($_POST["id_medico"])?limpiarCadena($_POST["id_medico"]):"";
$nombre=isset($_POST["nombre"])?limpiarCadena($_POST["nombre"]):"";
$especialidad=isset($_POST["especialidad"])?limpiarCadena($_POST["especialidad"]):"";
$telefono=isset($_POST["telefono"])?limpiarCadena($_POST["telefono"]):"";
$correo=isset($_POST["correo"])?limpiarCadena($_POST["correo"]):"";
$cedula=isset($_POST["cedula"])?limpiarCadena($_POST["cedula"]):"";
$hora_entrada=isset($_POST["hora_entrada"])?limpiarCadena($_POST["hora_entrada"]):"";
$hora_salida=isset($_POST["hora_salida"])?limpiarCadena($_POST["hora_salida"]):"";
$password=isset($_POST["password"])?limpiarCadena($_POST["password"]):"";
$imagen=isset($_POST["imagen"])?limpiarCadena($_POST["imagen"]):"";

switch($_GET["op"]){
	//Caso para guardar y editar un médico
	case 'guardaryeditar':
		//Se verifica que la imagen haya sido subida anteriormente
		if(!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])){
			$imagen=$_POST["imagen_actual"];
		}else{
		//Se establece una imagen extraída del dispositivo donde se encuentra el usuario
			$extension=explode(".",$_FILES["imagen"]["name"]);
			if(($_FILES['imagen']['type']=="image/jpg")||($_FILES['imagen']['type']=="image/jpeg")||($_FILES['imagen']['type']=="image/png")){
				$imagen=round(microtime('time')).'.'.end($extension);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/medicos/".$imagen);
			}
		}
		//Se hashea la contraseña con SHA256
		$passwordHash=hash("SHA256",$password);
		//Si el campo de id_medico está vacío se inserta un nuevo médico de lo contario solo se edita 
		if(empty($id_medico)){
			//Si no se insertó ninguna imagen se coloca una por default
			if($imagen==''){
				$imagen='000000000.png';
			}
			$respuesta=$medico->insertar($nombre, $especialidad, $telefono, $correo, $cedula, $hora_entrada, $hora_salida, $passwordHash, true, $imagen);
			echo $respuesta?"Médico registrado":"Médico no se pudo registrar";
		}else{
			$respuesta=$medico->editar($id_medico, $nombre, $especialidad, $telefono, $correo, $cedula, $hora_entrada, $hora_salida, $passwordHash, true, $imagen);
			echo $respuesta?"Médico actualizado":"Médico no se pudo actualizar";
		}
	break;
	//Caso para desactivar a un médico
	case 'desactivar':
		$respuesta=$medico->desactivar($id_medico);
		echo $respuesta?"Médico marcado como inactivo":"Médico no se pudo marcar como inactivo";
	break;
	//Caso para activar a un médico
	case 'activar':
		$respuesta=$medico->activar($id_medico);
		echo $respuesta?"Médico marcado como activo":"Médico no se pudo marcar como activo";
	break;
	//Caso para mostrar a los médicos
	case 'mostrar':
		$respuesta=$medico->mostrar($id_medico);
		//Se codifica en JSON
		echo json_encode($respuesta);
	break;
	//Caso para listar a los médicos
	case 'listar':
		$respuesta=$medico->listar();
		//Declaramos un arreglo de médicos
		$medicos= array();
		while($reg=$respuesta->fetch_object()){
			$medicos[]=array(
				"0"=>($reg->activo)?'<button class="btn btn-info" onclick="mostrar('.$reg->id_medico.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-primary" onclick="desactivar('.$reg->id_medico.')"><i class="fa fa-check"></i></button>':'<button class="btn btn-info" onclick="mostrar('.$reg->id_medico.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-warning" onclick="activar('.$reg->id_medico.')"><i class="fa fa-close"></i></button>',
				"1"=>$reg->nombre,
				"2"=>$reg->especialidad,
				"3"=>$reg->telefono,
				"4"=>$reg->correo,
				"5"=>$reg->cedula,
				"6"=>"<img src='../files/medicos/".$reg->imagen."' height='50px' width='50px'>",
				"7"=>$reg->hora_entrada,
				"8"=>$reg->hora_salida,
				"9"=>$reg->password,
				"10"=>($reg->activo)?'<span class="label bg-green">Activo</span>':'<span class="label bg-red">No activo</span>'); //NO FUNCIONA PORQUE SON MUCHOS PARAMETROS SE SUSTITUYE POR LO PRIMERO
				//SE AÑADIERON BOTONES
		}
		$resultados=array(
			"sEcho"=>1,//información para datatables
			"iTotalRecords"=>count($medicos),//# de medicos a datatable
			"iTotalDisplayRecords"=>count($medicos),//# de medicos a visualizar en datatable
			"aaData"=>$medicos); //Médicos con su información
		echo json_encode($resultados);
	break;

	case 'verificar':
		$nombre_usuario_acceso=$_POST['nombre_usuario_acceso'];
		$password_acceso=$_POST['password_acceso'];
		
		$passwordHash=hash("SHA256",$password_acceso);
		$respuesta=$medico->verificar($nombre_usuario_acceso, $passwordHash);

		$fetch=$respuesta->fetch_object(); //Sirve para guardar los datos del objeto
		if(isset($fetch)){
			//Declaramos las variables de sesión
			$_SESSION['id_medico']=$fetch->id_medico;
			$_SESSION['nombre']=$fetch->nombre;
			$_SESSION['especialidad']=$fetch->especialidad;
			$_SESSION['telefono']=$fetch->telefono;
			$_SESSION['correo']=$fetch->correo;
			$_SESSION['cedula']=$fetch->cedula;
			$_SESSION['hora_entrada']=$fetch->hora_entrada;
			$_SESSION['hora_salida']=$fetch->hora_salida;
			$_SESSION['password']=$fetch->password;
			$_SESSION['tipo_persona']=$fetch->tipo_persona;
			$_SESSION['activo']=$fetch->activo;
			$_SESSION['imagen']=$fetch->imagen;
			
			$_SESSION['repositorio']=0;
			$_SESSION['pacientes']=1;
		}
		echo json_encode($fetch);
	break;

	case 'invitado':
		$nombre_usuario_acceso1="invitado@invitado.com";
		$password_acceso1="CinvitadoO";

		$passwordHash=hash("SHA256",$password_acceso1);
		$respuesta=$medico->verificar($nombre_usuario_acceso1, $passwordHash);

		$fetch=$respuesta->fetch_object(); //Sirve para guardar los datos del objeto
		if(isset($fetch)){
			//Declaramos las variables de sesión
			$_SESSION['id_medico']=$fetch->id_medico;
			$_SESSION['nombre']=$fetch->nombre;
			$_SESSION['especialidad']=$fetch->especialidad;
			$_SESSION['telefono']=$fetch->telefono;
			$_SESSION['correo']=$fetch->correo;
			$_SESSION['cedula']=$fetch->cedula;
			$_SESSION['hora_entrada']=$fetch->hora_entrada;
			$_SESSION['hora_salida']=$fetch->hora_salida;
			$_SESSION['password']=$fetch->password;
			$_SESSION['tipo_persona']=$fetch->tipo_persona;
			$_SESSION['activo']=$fetch->activo;
			$_SESSION['imagen']=$fetch->imagen;
			
			$_SESSION['repositorio']=0;
			$_SESSION['pacientes']=1;
		}
		echo json_encode($fetch);
	break;
	
	case 'salir':
		//Limpiamos las variables de sesión
		session_unset();
		//Destruimos la sesión
		session_destroy();
		//Redireccionamos al login
		header("Location: ../index.php");
	break;
}

?>