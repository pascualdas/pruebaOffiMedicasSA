<?php
session_start();
extract($_POST);

//<b>Notice</b>:  Undefined index: tiempo in <b>C:\xampp\htdocs\larrcash\controllers\ctl_sesion.php</b> on line <b>8</b><br />

if($op=="vidaSesion"){
	// Retorna el tiempo de sesion
	$vida_session = time() - $_SESSION['tiempo'];
	if($vida_session==0){ $vida_session += 1; }
	//T.VidaSession: 0 = Tiempo: 1563207090 - Session: 1563207090=>600
		 
	
	if($vida_session > $tiempoSesion){
		echo 0;
	}else{
		echo $vida_session;
	}

}else if($op=="reiniciarTiempo"){
	$_SESSION['tiempo'] = time();
	//echo $_SESSION['tiempo'];	
}else{
	session_destroy();
	echo header("location:../");
	return false;
}

?>