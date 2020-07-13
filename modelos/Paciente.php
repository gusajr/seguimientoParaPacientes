<?php
/*Nombre: Paciente.php
Objetivo/propósito: archivo de consultas a la base de datos (MySQL) para paciente. Insertar, editar, activar, desactivar, listar pacientes de la base de datos.
Creado por: GHAMASWARE
			-Ing. Casillas Toledo Mauricio Enrique
			-Ing. Gómez Segovia Álvaro
			-Ing. Jiménez Ruiz Gustavo Alfredo
			-Ing. Ramírez Martínez Humberto
Fecha: 22/diciembre/2019
Versión: 1.0*/

//Se incluye la conexión a la db
require "../config/Conexion.php";

Class Paciente{
	//Constructor para el objeto Paciente
	public function __construct(){

	}
	//Método para insertar paciente
	public function insertar($curp, $id_medico, $nombre, $fecha_nacimiento, $telefono, $correo, $direccion, $genero, $fecha_registro, $activo, $imagen, $historia_clinica){
		$sql="INSERT INTO paciente(curp, id_medico, nombre, fecha_nacimiento, telefono, correo, direccion, genero, fecha_registro, activo, imagen, historia_clinica) VALUES ('$curp', '$id_medico', '$nombre', '$fecha_nacimiento', '$telefono', '$correo', '$direccion', '$genero', '$fecha_registro', '$activo', '$imagen', '$historia_clinica')";
		return ejecutarConsulta($sql);
	}
	//Método para editar paciente
	public function editar($id_paciente, $curp, $id_medico, $nombre, $fecha_nacimiento, $telefono, $correo, $direccion, $genero, $fecha_registro, $activo, $imagen, $historia_clinica){
		$sql="UPDATE paciente SET id_paciente='$id_paciente', curp='$curp', id_medico='$id_medico', nombre='$nombre', fecha_nacimiento='$fecha_nacimiento', telefono='$telefono', correo='$correo', direccion='$direccion', genero='$genero', fecha_registro='$fecha_registro', activo='$activo', imagen='$imagen', historia_clinica='$historia_clinica' WHERE id_paciente='$id_paciente'";
		return ejecutarConsulta($sql);
	}
	//Método para mantener desactivo a paciente
	public function desactivar($id_paciente){
		$sql="UPDATE paciente SET activo='0' WHERE id_paciente='$id_paciente'";
		return ejecutarConsulta($sql); 
	}
	//Método para mantener activo a paciente
	public function activar($id_paciente){
		$sql="UPDATE paciente SET activo='1' WHERE id_paciente='$id_paciente'";
		return ejecutarConsulta($sql);
	}
	//Método para actualizar notas clínicas de un paciente
	public function notas($id_paciente, $notas_clinicas){
		$sql="UPDATE paciente SET notas_clinicas='$notas_clinicas' WHERE id_paciente='$id_paciente'";
		return ejecutarConsulta($sql);
	}
	//Método para mostrar los datos de un paciente a modificar
	public function mostrar($id_paciente){
		$sql="SELECT * FROM paciente WHERE id_paciente='$id_paciente'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Método para eliminar a un paciente
	public function eliminar($id_paciente){
		$sql="DELETE FROM paciente WHERE id_paciente='$id_paciente'";
		return ejecutarConsulta($sql);
	}
	//Método para eliminar notas de un paciente
	public function eliminarNotas($id_paciente){
		$sql="UPDATE paciente SET notas_clinicas=NULL WHERE id_paciente='$id_paciente'";
		return ejecutarConsulta($sql);
	}
	//Método para mostrar los registros
	public function listar(){
		$sql="SELECT p.id_paciente, p.curp, p.id_medico, m.nombre as nombre_medico, p.nombre, p.fecha_nacimiento, p.telefono, p.correo, p.direccion, p.genero, p.fecha_registro, p.activo, p.imagen, p.historia_clinica FROM paciente p INNER JOIN medico m ON p.id_medico=m.id_medico";
		return ejecutarConsulta($sql);
	}
	//Método para mostrar los registros de un paciente con notas clínicas
	public function listarN(){
		$sql="SELECT p.id_paciente, p.curp, p.id_medico, m.nombre as nombre_medico, p.nombre, p.fecha_nacimiento, p.telefono, p.correo, p.direccion, p.genero, p.fecha_registro, p.activo, p.imagen, p.historia_clinica, p.notas_clinicas FROM paciente p INNER JOIN medico m ON p.id_medico=m.id_medico WHERE p.notas_clinicas IS NOT NULL";
		return ejecutarConsulta($sql);
	}
	//Método para poder hacer un select de los pacientes
	public function select(){
		$sql="SELECT * FROM paciente WHERE activo=1";
		return ejecutarConsulta($sql);
	}
}
?>