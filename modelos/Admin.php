<?php
/*Nombre: Admin.php
Objetivo/propósito: archivo de consultas a la base de datos (MySQL) para el usuario administrador. Insertar, editar, eliminar, mostrar, verificar administradores en la base de datos.
Creado por: GHAMASWARE
			-Ing. Casillas Toledo Mauricio Enrique
			-Ing. Gómez Segovia Álvaro
			-Ing. Jiménez Ruiz Gustavo Alfredo
			-Ing. Ramírez Martínez Humberto
Fecha: 27/diciembre/2019
Versión: 1.0*/

//Se incluye la conexión a la db
require "../config/Conexion.php";

Class Admin{
	//Constructor para el objeto administrador
	public function __construct(){

	}
	//Método para insertar administrador
	public function insertar($nombre_usuario, $password, $tipo_persona, $imagen){
		$sql="INSERT INTO admin(nombre_usuario, password, tipo_persona, imagen) VALUES ('$nombre_usuario', '$password', '$tipo_persona', '$imagen')";
		return ejecutarConsulta($sql);
	}
	//Método para editar administrador
	public function editar($id_admin, $nombre_usuario, $password, $tipo_persona, $imagen){
		$sql="UPDATE admin SET nombre_usuario='$nombre_usuario', password='$password', tipo_persona='$tipo_persona', imagen='$imagen' WHERE id_admin='$id_admin'";
		return ejecutarConsulta($sql);
	}
	//Método para eliminar administrador
	public function eliminar($id_admin){
		$sql="DELETE FROM admin WHERE id_admin='$id_admin'";
		return ejecutarConsulta($sql);
	}
	//Método para mostrar los datos de un administrador a modificar
	public function mostrar($id_admin){
		$sql="SELECT * FROM admin WHERE id_admin='$id_admin'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Método para mostrar los registros de un administrador
	public function listar(){
		$sql="SELECT * FROM admin";
		return ejecutarConsulta($sql);
	}
	//Método para verificar la sesión de un administrador
	public function verificar($nombre_usuario, $password){
		$sql="SELECT nombre_usuario, password, tipo_persona, imagen FROM admin WHERE nombre_usuario='$nombre_usuario' AND password='$password'";
		return ejecutarConsulta($sql);
	}
}
?>