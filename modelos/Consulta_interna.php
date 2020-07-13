<?php
/*Nombre: Consulta_interna.php
Objetivo/propósito: archivo de consultas a la base de datos (MySQL) para consultas internas. Insertar, editar, activar, desactivar, eliminar, mostrar consultas internas en la base de datos.
Creado por: GHAMASWARE
			-Ing. Casillas Toledo Mauricio Enrique
			-Ing. Gómez Segovia Álvaro
			-Ing. Jiménez Ruiz Gustavo Alfredo
			-Ing. Ramírez Martínez Humberto
Fecha: 4/enero/2020
Versión: 1.0*/

//Se incluye la conexión a la db
require "../config/Conexion.php";

Class Consulta_interna{
	//Constructor para el objeto consulta interna
	public function __construct(){

	}
	//Método para insertar una consulta interna
	public function insertar($id_medico, $id_paciente, $fecha, $hospitalizacion, $notas){
		$sql="INSERT INTO consulta_interna(id_medico, id_paciente, fecha, hospitalizacion, notas) VALUES ('$id_medico', '$id_paciente', '$fecha', '$hospitalizacion', '$notas')";
		echo $sql;
		return ejecutarConsulta($sql);
	}	
	//Método para editar consulta interna
	public function editar($id_consulta_interna, $id_medico, $id_paciente, $fecha, $notas){
		$sql="UPDATE consulta_interna SET id_consulta_interna='$id_consulta_interna', id_medico='$id_medico', id_paciente='$id_paciente', fecha='$fecha', notas='$notas'";
		return ejecutarConsulta($sql);
	}
	//Método para desactivar una consulta interna
	public function desactivar($id_paciente){
		$sql="UPDATE consulta_interna SET hospitalizacion='0' WHERE id_paciente='$id_paciente'";
		return ejecutarConsulta($sql); 
	}
	//Método para activar una consulta interna 
	public function activar($id_paciente){
		$sql="UPDATE consulta_interna SET hospitalizacion='1' WHERE id_paciente='$id_paciente'";
		return ejecutarConsulta($sql);
	}
	//Método para mostrar los datos de una consulta interna a modificar
	public function mostrar($id_consulta_interna){
		$sql="SELECT * FROM consulta_interna WHERE id_consulta_interna='$id_consulta_interna'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Método para eliminar una consulta interna
	public function eliminar($id_consulta_interna){
		$sql="DELETE FROM consulta_interna WHERE id_consulta_interna='$id_consulta_interna'";
		return ejecutarConsulta($sql);
	}
	//Método para mostrar los registros
	public function listar(){
		$sql="SELECT c.id_consulta_interna, c.id_medico, c.id_paciente, p.nombre as nombre_paciente, m.nombre as nombre_medico, c.fecha, c.hospitalizacion, c.notas FROM consulta_interna c INNER JOIN paciente p ON c.id_paciente=p.id_paciente INNER JOIN medico m ON c.id_medico=m.id_medico";
		return ejecutarConsulta($sql);
	}
	//Método para poder hacer un select de los pacientes
	public function select(){
		$sql="SELECT * FROM paciente WHERE activo=1";
		return ejecutarConsulta($sql);
	}
}
?>