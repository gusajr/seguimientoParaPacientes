<?php
/*Nombre: Medico.php
Objetivo/propósito: archivo de consultas a la base de datos (MySQL) para médico. Insertar, editar, activar, desactivar, listar, verificar médicos en la base de datos.
Creado por: GHAMASWARE
			-Ing. Casillas Toledo Mauricio Enrique
			-Ing. Gómez Segovia Álvaro
			-Ing. Jiménez Ruiz Gustavo Alfredo
			-Ing. Ramírez Martínez Humberto
Fecha: 22/diciembre/2019
Versión: 1.0*/

//Se incluye la conexión a la db
require "../config/Conexion.php";

Class Medico{
	//Constructor para el objeto Médico
	public function __construct(){

	}
	//Método para insertar médico
	public function insertar($nombre, $especialidad, $telefono, $correo, $cedula, $hora_entrada, $hora_salida, $password, $activo, $imagen){
		$sql="INSERT INTO medico(nombre, especialidad, telefono, correo, cedula, hora_entrada, hora_salida, password, tipo_persona, activo, imagen) VALUES ('$nombre', '$especialidad', '$telefono', '$correo', '$cedula', '$hora_entrada', '$hora_salida', '$password', 'medico', '$activo', '$imagen')";
		return ejecutarConsulta($sql);
	}
	//Método para editar médico
	public function editar($id_medico, $nombre, $especialidad, $telefono, $correo, $cedula, $hora_entrada, $hora_salida, $password, $activo, $imagen){
		$sql="UPDATE medico SET nombre='$nombre',especialidad='$especialidad', telefono='$telefono', correo='$correo', cedula='$cedula', hora_entrada='$hora_entrada', hora_salida='$hora_salida', password='$password', tipo_persona='medico', activo='$activo', imagen='$imagen' WHERE id_medico='$id_medico'";
		return ejecutarConsulta($sql);
	}
	//Método para mantener desactivo a medico
	public function desactivar($id_medico){
		$sql="UPDATE medico SET activo='0' WHERE id_medico='$id_medico'";
		return ejecutarConsulta($sql);
	}
	//Método para mantener desactivo a medico
	public function activar($id_medico){
		$sql="UPDATE medico SET activo='1' WHERE id_medico='$id_medico'";
		return ejecutarConsulta($sql);
	}
	//Método para mostrar los datos de un médico a modificar
	public function mostrar($id_medico){
		$sql="SELECT * FROM medico WHERE id_medico='$id_medico'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Metodo para mostrar los registros
	public function listar(){
		$sql="SELECT * FROM medico";
		return ejecutarConsulta($sql);
	}
	//Método para listar los registros y mostrar en boton select de paciente
	public function select(){
		$sql="SELECT * FROM medico WHERE activo=1";
		return ejecutarConsulta($sql);
	}
	//Método para verificar los datos de sesión de un médico
	public function verificar($correo, $password){
		$sql="SELECT id_medico, nombre, especialidad, telefono, correo, cedula, hora_entrada, hora_salida, password, tipo_persona, activo, imagen FROM medico WHERE correo='$correo' AND password='$password' AND activo=true";
		return ejecutarConsulta($sql);
	}
}
?>