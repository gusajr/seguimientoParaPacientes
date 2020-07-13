<?php
/*Nombre: admin.php
Objetivo/propósito: archivo ajax para administrador. Peticiones ajax para guardar y editar, eliminar, mostrar, listar, verificar y salir del sistema
Creado por: GHAMASWARE
			-Ing. Casillas Toledo Mauricio Enrique
			-Ing. Gómez Segovia Álvaro
			-Ing. Jiménez Ruiz Gustavo Alfredo
			-Ing. Ramírez Martínez Humberto
Fecha: 27/diciembre/2019
Versión: 1.0*/

session_start();
//Se inicia la sesión del objeto
require_once "../modelos/Admin.php";
//Se crea una instancia al objeto Admin
$admin=new Admin();

//Se obtienen los datos de los objetos html, si es que ya han sido enviados, las cajas de texto se vacían
$id_admin=isset($_POST["id_admin"])?limpiarCadena($_POST["id_admin"]):"";
$nombre_usuario=isset($_POST["nombre_usuario"])?limpiarCadena($_POST["nombre_usuario"]):"";
$password=isset($_POST["password"])?limpiarCadena($_POST["password"]):"";
$imagen=isset($_POST["imagen"])?limpiarCadena($_POST["imagen"]):"";

//Realizaremos peticiones mediante el metodo AJAX
switch($_GET["op"]){
	//Caso para guardar y editar al administrador
	case 'guardaryeditar':
		//Se verifica que la imagen haya sido subida anteriormente
		if(!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])){
			$imagen=$_POST["imagen_actual"];
		}else{
		//Se establece una imagen extraída del dispositivo donde se encuentra el usuario
			$extension=explode(".",$_FILES["imagen"]["name"]);
			if(($_FILES['imagen']['type']=="image/jpg")||($_FILES['imagen']['type']=="image/jpeg")||($_FILES['imagen']['type']=="image/png")){
				$imagen=round(microtime('time')).'.'.end($extension);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/admin/".$imagen);
			}
		}
		//Se hashea la contraseña con SHA256
		$passwordHash=hash("SHA256",$password);
		//Si el campo de id_admin está vacío se inserta un nuevo administrador de lo contario solo se edita 
		if(empty($id_admin)){
			//Si no se insertó ninguna imagen se coloca una por default
			if($imagen==''){
				$imagen='000000000.png';
			}
			$respuesta=$admin->insertar($nombre_usuario, $passwordHash, 'admin', $imagen);
			echo $respuesta?"Administrador registrado":"Administrador no se pudo registrar";
		}else{
			$respuesta=$admin->editar($id_admin, $nombre_usuario, $passwordHash, 'admin', $imagen);
			echo $respuesta?"Administrador actualizado":"Administrador no se pudo actualizar";
		}
	break;
	//Caso para eliminar a un admin
	case 'eliminar':
		$respuesta=$admin->eliminar($id_admin);
		echo $respuesta?"Administrador eliminado":"Administrador no se pudo eliminar";
	break;
	//Caso para mostrar a un admin
	case 'mostrar':
		$respuesta=$admin->mostrar($id_admin);
		//Se codifica en JSON
		echo json_encode($respuesta);
	break;
	//Caso para listar a un admin
	case 'listar':
		$respuesta=$admin->listar();
		//Declaramos un arreglo de administradores
		$administradores= array();
		while($reg=$respuesta->fetch_object()){
			$administradores[]=array(
				"0"=>'<button class="btn btn-info" onclick="mostrar('.$reg->id_admin.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="eliminar('.$reg->id_admin.')"><i class="fa fa-trash"></i></button>',
				"1"=>$reg->nombre_usuario,
				"2"=>$reg->password,
				"3"=>"<img src='../files/admin/".$reg->imagen."' height='50px' width='50px'>");
		}
		$resultados=array(
			"sEcho"=>1,//información para datatables
			"iTotalRecords"=>count($administradores),//# de administradores a datatable
			"iTotalDisplayRecords"=>count($administradores),//# de administradores a visualizar en datatable
			"aaData"=>$administradores); //Administradores con su información
		echo json_encode($resultados);
	break;
	//Caso para verificar el inicio de sesión
	case 'verificar':

		require_once "../modelos/Medico.php";
		$medico = new Medico();
		
		$nombre_usuario_acceso=$_POST['nombre_usuario_acceso'];
		$password_acceso=$_POST['password_acceso'];
		$correo="admin@admin.com";
		$passwordHash1=hash("SHA256","admin");

		$passwordHash=hash("SHA256",$password_acceso);
		$respuesta=$admin->verificar($nombre_usuario_acceso, $passwordHash);
		$respuesta2=$medico->verificar($correo,$passwordHash1);
		
		$fetch=$respuesta->fetch_object(); //Sirve para guardar los datos del objeto
		$fetch1=$respuesta2->fetch_object(); //Sirve para guardar los datos del objeto

		if(isset($fetch)){
			//Declaramos las variables de sesión
			$_SESSION['id_admin']=$fetch->id_admin;
			$_SESSION['nombre_usuario']=$fetch->nombre_usuario;
			$_SESSION['password']=$fetch->password;
			$_SESSION['tipo_persona']=$fetch->tipo_persona;
			$_SESSION['imagen']=$fetch->imagen;		
			$_SESSION['repositorio']=1; //Se establecen variables de sesión
			$_SESSION['pacientes']=1;
		}

		if(isset($fetch1)){
			$_SESSION['id_medico']=$fetch1->id_medico;
			$_SESSION['nombre']=$fetch1->nombre;
			$_SESSION['cedula']=$fetch1->cedula;
		}

		echo json_encode($fetch);
	break;
	//Caso para salir del inicio de sesión
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