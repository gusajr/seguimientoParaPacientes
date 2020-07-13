<?php
/*Nombre: Cita.php
Objetivo/propósito: archivo de consultas a la base de datos (MySQL) para citas. Insertar, activar, desactivar, eliminar, listar citas de la base de datos.
Creado por: GHAMASWARE
            -Ing. Casillas Toledo Mauricio Enrique
            -Ing. Gómez Segovia Álvaro
            -Ing. Jiménez Ruiz Gustavo Alfredo
            -Ing. Ramírez Martínez Humberto
Fecha: 2/enero/2020
Versión: 1.0*/

//Se incluye la conexión a la db
require "../config/Conexion.php";

Class Cita{
	//Constructor para el objeto Cita
	public function __construct(){

	}
	//Método para insertar una cita
	public function insertar($id_paciente, $id_medico, $fecha, $hora_inicio, $hora_fin, $comentarios, $activo){
		$sql="INSERT INTO cita(id_paciente, id_medico, fecha, hora_inicio, hora_fin, comentarios, activo) VALUES ('$id_paciente', '$id_medico', '$fecha', '$hora_inicio', '$hora_fin', '$comentarios', '$activo')";
		return ejecutarConsulta($sql);
	}
	//Método para desactivar ùna cita
	public function desactivar($id_cita){
		$sql="UPDATE cita SET activo='0' WHERE id_cita='$id_cita'";
		return ejecutarConsulta($sql); 
	}
	//Método para activar una cita
	public function activar($id_cita){
		$sql="UPDATE cita SET activo='1' WHERE id_cita='$id_cita'";
		return ejecutarConsulta($sql); 
	}

	//Método para mostrar los datos de una cita a modificar
	public function mostrar($id_paciente, $id_medico){
		$sql="SELECT * FROM cita WHERE id_paciente='$id_paciente' AND id_medico='$id_medico";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Método para checar la disponibilidad de una cita
	public function checarCita($id_paciente, $id_medico, $fecha, $hora_inicio){
		$sql="SELECT * FROM cita WHERE (id_paciente='$id_paciente' OR id_medico='$id_medico') AND fecha='$fecha' AND hora_inicio='$hora_inicio' AND activo=true";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Método para eliminar una cita
	public function eliminar($id_cita){
		$sql="DELETE FROM cita WHERE id_cita='$id_cita'";
		return ejecutarConsulta($sql);
	}
	//Método para mostrar los registros de una cita
	public function listar(){
		$sql="SELECT c.id_cita, c.id_paciente, p.nombre as nombre_paciente, m.nombre as nombre_medico, m.especialidad as especialidad_medico, c.id_medico, c.fecha, c.hora_inicio, c.hora_fin, c.comentarios, c.activo FROM cita c INNER JOIN paciente p ON c.id_paciente=p.id_paciente INNER JOIN medico m ON c.id_medico=m.id_medico";
		return ejecutarConsulta($sql);
	}
}
?>

