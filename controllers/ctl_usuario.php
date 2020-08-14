<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

extract($_GET);
extract($_POST);


require_once("limpiaCadenas.php"); // - limpiarCadena(
require_once("../models/mdl_usuario.php");
$objUsuario = new mdl_usuario('../config.php');

if($op=="registro"){

    $html = '
            <form class="card shadow p-4">

                <div class="form-group text-left row">

                    <div class="col-md-6">
                        <label for= "txt_dni">DNI (*): Número Nacional de Identidad</label>
                        <input type="number" id="txt_dni" name= "txt_dni" class="form-control" onchange="validaExisteUsuario(this.value);" onkeypress="return validarNumericos(event);" placeholder="DNI" maxlength="150" required >
                    </div>
                    <div class="col-md-6">
                        <label for= "txt_dni">Telefono (*): </label>
                        <input type="number" id="txt_telefono" name= "txt_telefono" class="form-control" placeholder="Telefono" onkeypress="return validarNumericos(event);" maxlength="15" required >
                    </div>

                </div>

                <div class="form-group text-left row">

                    <div class="col-md-6">
                        <label for= "txt_dni">Nombres (*): </label>
                        <input type="text" id="txt_nombres" name= "txt_nombres" class="form-control" placeholder="Nombres" maxlength="150" required >
                    </div>
                    <div class="col-md-6">
                        <label for= "txt_dni">Apellidos (*): </label>
                        <input type="text" id="txt_apellidos" name= "txt_apellidos" class="form-control" placeholder="Apellidos" maxlength="150" required >
                    </div>

                </div>

                <div class="form-group text-left row">

                    <div class="col-md-6">
                        <label for= "txt_dni">Direccion (*): </label>
                        <input type="text" id="txt_direccion" name= "txt_direccion" class="form-control" placeholder="Direccion" maxlength="300" required >
                    </div>
                    <div class="col-md-6">
                        <label for= "txt_dni">Correo Electronico (*): </label>
                        <input type="text" id="txt_correo" name= "txt_correo" class="form-control" placeholder="Correo Electronico" maxlength="100" required >
                    </div>

                </div>

                <div class="form-group text-left row">

                    <div class="col-md-6">
                        <label for="inputPassword" class="">Contraseña (*): </label>
                        <input type="password" id="txt_pass" name="txt_pass" class="form-control" placeholder="" minlength="8" maxlength="100" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPasswordConfirm" class="">Confirmar Contraseña (*):</label>
                        <input type="password" id="txt_pass_confirm" name="txt_pass_confirm" class="form-control" placeholder="" minlength="8" maxlength="100" required>
                    </div>

                </div>
                
                <hr/>
                <a id="btn_ingresar" class="btn btn-lg btn-primary btn-block" href="#" onClick=\'registrarUsuario();\'>Registrar</a>
            </form>';
        echo  $html;

}else if($op== "validaExisteDni"){

    $nroRegistros = $objUsuario->contarUsuarios($dni);
    
    if(isset($nroRegistros)){
        echo $nroRegistros;
    }


} else if ($op == "mostrarUserExisteData") {

    $nroRegistros = $objUsuario->contarUsuarios($dni);

    //echo 'DNI: '. $dni. ' / nroRegistros: '.$nroRegistros;
    if ($nroRegistros <= 0 || $nroRegistros >= 2) {

        $arrayPersona = [
            'id' => '',
            'dni' => $dni,
            'nombres' => '',
            'apellidos' => '',
            'direccion' => '',
            'telefono' => '',
            'correo' => '',
            'creado_en' => ''
        ];
    } else {

        $arrayPersona = $objUsuario->getDDatosUserDNI($dni);
    }

    $html = '
        <form class="card shadow p-4">

            <div class="form-group text-left row">

                <div class="col-md-6">
                    <label for= "txt_dni">DNI (*): Número Nacional de Identidad</label>
                    <input type="number" id="txt_dni" name="txt_dni" class="form-control" value="' . $arrayPersona['dni'] . '" onchange="validaExisteUsuario(this.value);" onkeypress="return validarNumericos(event);" placeholder="DNI" maxlength="150" required>
                </div>
                <div class="col-md-6">
                    <label for= "txt_dni">Telefono (*): </label>
                    <input type="text" id="txt_telefono" name= "txt_telefono" class="form-control" value="' . $arrayPersona['telefono'] . '" onkeypress="return validarNumericos(event);" placeholder="Telefono" maxlength="15" required >
                </div>

            </div>

            <div class="form-group text-left row">

                <div class="col-md-6">
                    <label for= "txt_dni">Nombres (*): </label>
                    <input type="text" id="txt_nombres" name= "txt_nombres" class="form-control" value="' . $arrayPersona['nombres'] . '" placeholder="Nombres" maxlength="150" required >
                </div>
                <div class="col-md-6">
                    <label for= "txt_dni">Apellidos (*): </label>
                    <input type="text" id="txt_apellidos" name= "txt_apellidos" class="form-control" value="' . $arrayPersona['apellidos'] . '" placeholder="Apellidos" maxlength="150" required >
                </div>

            </div>

            <div class="form-group text-left row">

                <div class="col-md-6">
                    <label for= "txt_dni">Direccion (*): </label>
                    <input type="text" id="txt_direccion" name= "txt_direccion" class="form-control" value="' . $arrayPersona['direccion'] . '" placeholder="Direccion" maxlength="300" required >
                </div>
                <div class="col-md-6">
                    <label for= "txt_dni">Correo Electronico (*): </label>
                    <input type="text" id="txt_correo" name= "txt_correo" class="form-control" value="' . $arrayPersona['correo'] . '" placeholder="Correo Electronico" maxlength="100" required >
                </div>

            </div>

            <div class="form-group text-left row">

                <div class="col-md-6">
                    <label for="inputPassword" class="">Contraseña (*): </label>
                    <input type="password" id="txt_pass" name="txt_pass" class="form-control" placeholder="" minlength="8" maxlength="100" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPasswordConfirm" class="">Confirmar Contraseña (*):</label>
                    <input type="password" id="txt_pass_confirm" name="txt_pass_confirm" class="form-control" placeholder="" maxlength="100" required>
                </div>

            </div>
            
            <hr/>
            <a id="btn_ingresar" class="btn btn-lg btn-primary btn-block" href="#" onClick=\'registrarUsuario();\'>Registrar</a>
        </form>';

    echo  $html;

} else if ($op == "guardar") {

    echo $objUsuario->guardarUsuario(
        $contrasena,
        limpiarCadena($dni),
        limpiarCadena($nombres),
        limpiarCadena($apellidos),
        limpiarCadena($direccion),
        limpiarCadena($telefono),
        limpiarCadena($correo)
    );


}else if($op=="login"){

    $array = $objUsuario->validaLogin($email, $password);
    //var_dump($array);

    if ($array[0] == 0) {
        echo 2;
    } else {

        foreach ($array as $valor) {
            $_SESSION['id'] = $valor["id"];
            $_SESSION['nombres'] = $valor["nombres"];
            $_SESSION['email'] = $valor["email"];
            $_SESSION['is_active'] = $valor["is_active"];
            $_SESSION['tiempo'] = time();
        }

        echo 1;
    }
} else if ($op == "logout") {

    if (isset($_SESSION['email'])) {
        session_destroy();
        session_unset();
        session_destroy();
    }
    
    return 1;

}else{

    if(isset($_SESSION['email'])){
        session_destroy();
    }
	echo header("location:../");
	return false;
}
