<?php 
/*Es once y no normal para indicar a php que si ya está inlcuido no lo incluya por
segunda vez*/
require_once "global.php";
//Conexion con db
$conexion=new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
//Consulta a db
mysqli_query($conexion,'SET NAMES "'.DB_ENCODE.'"');
//Validamos conexión
if(mysqli_connect_errno()){
	printf("Falló la conexión a la base de datos: %s\n",mysqli_connect_error());
	exit();

}
/*Funciones para hacer peticiones a la base de datos
  $sql: codigo sql que sea ejecutado
  Esta función es para ejecutar código sql*/
if(!function_exists('ejecutarConsulta')){
	function ejecutarConsulta($sql){
		global $conexion;
		$query=$conexion->query($sql);
		return $query;
	}
	function ejecutarConsultaSimpleFila($sql){
		global $conexion;
		$query=$conexion->query($sql);
		$row=$query->fetch_assoc();
		//Devuelve una fila como resultado en un array
		return $row;
	}
	function ejecutarConsulta_retornarID($sql){
		global $conexion;
		$query=$conexion->query($sql);
		return $conexion->insert_id;
		//Devuelve la llave primaria del registro indicado
	}
	function limpiarCadena($str){
		global $conexion;
		$str = mysqli_real_escape_string($conexion,trim($str));
		return htmlspecialchars($str);
	}
}

?>