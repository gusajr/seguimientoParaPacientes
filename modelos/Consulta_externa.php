<?php
/*Nombre: Consulta_externa.php
Objetivo/propósito: archivo de consultas a la base de datos (MySQL) para consultas externas. Insertar, editar, eliminar, mostrar consultas externas en la base datos.
Creado por: GHAMASWARE
			-Ing. Casillas Toledo Mauricio Enrique
			-Ing. Gómez Segovia Álvaro
			-Ing. Jiménez Ruiz Gustavo Alfredo
			-Ing. Ramírez Martínez Humberto
Fecha: 4/enero/2020
Versión: 1.0*/

//Se incluye la conexión a la db
require "../config/Conexion.php";

Class Consulta_externa{
	//Constructor para el objeto consulta externa
	public function __construct(){

	}
	//Método para insertar una consulta externa
	public function insertar($fecha, $hora, $nombre, $edad, $telefono, $direccion, $notas){
		$sql="INSERT INTO consulta_externa(fecha, hora, nombre, edad, telefono, direccion, notas) VALUES ('$fecha', '$hora', '$nombre', '$edad', '$telefono', '$direccion', '$notas')";
		return ejecutarConsulta($sql);
	}
	//Método para editar una consulta externa
	public function editar($id_consulta_externa, $fecha, $hora, $nombre, $edad, $telefono, $direccion, $notas){
		$sql="UPDATE consulta_externa SET fecha='$fecha', hora='$hora', nombre='$nombre', edad='$edad', telefono='$telefono', direccion='$direccion', notas='$notas' WHERE id_consulta_externa='$id_consulta_externa'";
		return ejecutarConsulta($sql);
	}
	//Método para mostrar los datos de una consulta externa a modificar
	public function mostrar($id_consulta_externa){
		$sql="SELECT * FROM consulta_externa WHERE id_consulta_externa='$id_consulta_externa'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Método para eliminar una consulta externa
	public function eliminar($id_consulta_externa){
		$sql="DELETE FROM consulta_externa WHERE id_consulta_externa='$id_consulta_externa'";
		return ejecutarConsulta($sql);
	}
	//Método para mostrar los registros
	public function listar(){
		$sql="SELECT * FROM consulta_externa";
		return ejecutarConsulta($sql);
	}
}
?>
