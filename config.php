<?php
/*
	$ops:
	1 Listar
	2 Registrar
	3 Actualizar
	4 Eliminar
	
*/
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	extract($_GET);
	extract($_POST);

	define('driver','mysql');
	define('host','localhost');
	define('user','root');
	define('port','3306');
	define('pass','');
	define('database', 'pruebaoffimedicassa');
	define('charset','utf8');
	//Constante de registros por pagina -> Paginacion de resultados
	define('tamanoPagina', 10);
	//Constante de paginas por bloque -> Paginacion de resultados
	define('tamanoBloque',10);
	define('PaginaPrincipal', 'administracion.php');
	//Marca
	define('nombreEmpresa','Prueba OffiMedicas SA');
	define('webUrl', 'http://localhost/pruebaOffiMedicasSA/');
	define('telEmpresa','3012788000');
	define('imgEmpresa','resources/images/logo.png');
	define('tiempoSesion','600'); /*10 Min = 600 */
	define('base_url', 'http://localhost/pruebaOffiMedicasSA/');
	date_default_timezone_set('America/Bogota');

?>