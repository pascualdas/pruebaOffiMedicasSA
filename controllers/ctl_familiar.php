<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

extract($_GET);
extract($_POST);

//echo getcwd() . "\n";

require_once("limpiaCadenas.php"); // - limpiarCadena(
require_once("../models/mdl_familiar.php");
$objFamiliar = new mdl_familiar('../config.php');

if ($op == "listar") {

    $familiaresArray[] = array();
    $familiaresArray =  $objFamiliar->buscarFamiliar($_SESSION['id']);
?>

    <table class="table table-stripted">
        <thead>
            <tr>
                <th colspan="7">
                    <h2 class="float-left">LISTADO DE FAMILIARES</h2>
                    <a href="#" onclick="agregarFamiliar()" title="Agregar Familiar" class="btn btn-outline-success float-right">
                        Agregar Familiar
                    </a>
                </th>
            </tr>
            <tr>
                <th scope="col">#DNI</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Direccion</th>
                <th scope="col">Telefono</th>
                <th scope="col">Parentezco</th>
                <th scope="col">Acciones</th>
            </tr>
        <tbody>
            <?php
            $html = "";


            foreach ($familiaresArray as $familiar) {

                $isUser = 0;
                $isUser = $objFamiliar->validaSiEsUsuario($familiar['dni']);


                $html .= '<tr>
                            <td>' . $familiar['dni'] . '</td>
                            <td>' . $familiar['nombres']  . '</td>
                            <td>' . $familiar['apellidos']  . '</td>
                            <td>' . $familiar['direccion']  . '</td>
                            <td>' . $familiar['telefono']  . '</td>
                            <td>' . $familiar['parentesco']  . '</td>';

                if ($isUser == 0) {

                    $html .= '   <td>
                                    <a href="#" class="btn btn-outline-success" onclick="editarFamiliar('. $familiar['dni'].');" disabled> Editar </a>
                                    <a href="#" onclick="eliminarFamiliar(' . $familiar['dni'] . ');" class="btn btn-outline-primary"> Eliminar</a>
                                </td>
                            </tr>';
                } else {

                    $html .= '   <td>
                                    <a href="#" class="btn btn-outline-success" onclick="editarFamiliar(' . $familiar['dni'] . ');" disabled> Editar </a>
                                    <a href="#" class="btn btn-outline-secondary" onclick="eliminarFamiliarFail();" disabled> Eliminar </a>
                                </td>
                            </tr>';
                }
            }

            echo $html;

            ?>
        </tbody>
        </thead>


    </table>

<?php
} else if ($op == "registro") {

    $html = '
            <form class="card shadow p-4">

                <div class="form-group text-left row">

                    <div class="col-md-6">
                        <label for= "txt_dni">DNI (*): Número Nacional de Identidad</label>
                        <input type="number" id="txt_dni" name= "txt_dni" class="form-control" onchange="validaTieneUsuario(this.value);" placeholder="DNI" min="13000000" maxlength="150" onkeypress="return validarNumericos(event);" required autofocus>
                    </div>
                    <div class="col-md-6">
                        <label for= "txt_dni">Telefono (*): </label>
                        <input type="text" id="txt_telefono" name= "txt_telefono" class="form-control" placeholder="Telefono" maxlength="15" onkeypress="return validarNumericos(event);" required autofocus>
                    </div>

                </div>

                <div class="form-group text-left row">

                    <div class="col-md-6">
                        <label for= "txt_dni">Nombres (*): </label>
                        <input type="text" id="txt_nombres" name= "txt_nombres" class="form-control" placeholder="Nombres" maxlength="150" onkeypress="return validarTexto(event);" required autofocus>
                    </div>
                    <div class="col-md-6">
                        <label for= "txt_dni">Apellidos (*): </label>
                        <input type="text" id="txt_apellidos" name= "txt_apellidos" class="form-control" placeholder="Apellidos" maxlength="150" onkeypress="return validarTexto(event);" required autofocus>
                    </div>

                </div>

                <div class="form-group text-left row">

                    <div class="col-md-6">
                        <label for= "txt_dni">Direccion (*): </label>
                        <input type="text" id="txt_direccion" name= "txt_direccion" class="form-control" placeholder="Direccion" maxlength="300" required autofocus>
                    </div>
                    <div class="col-md-6">
                        <label for= "txt_dni">Correo Electronico (*): </label>
                        <input type="text" id="txt_correo" name= "txt_correo" class="form-control" placeholder="Correo Electronico" maxlength="100" required autofocus>
                    </div>

                </div>

                <div class="form-group text-left row">

                    <div class="col-md-12">
                        <label for="inputPassword" class="">Parentesco (*): </label>
                        <select id="cmb_parentesco" name="cmb_parentesco" class="form-control">
                            <option selected value="Conyugue">Conyugue</option>
                            <option value="Madre">Madre</option>
                            <option value="Padre">Padre</option>
                            <option value="Hermano">Hermano</option>
                            <option value="Hijo">Hijo</option>
                            <option value="Familiar">Familiar</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                </div>
                
                <hr/>
                <a id="btn_ingresar" class="btn btn-lg btn-primary btn-block" href="#" onClick=\'registrarFamiliar();\'>Registrar</a>
            </form>';
    echo  $html;
} else if ($op == "validaExisteUsuario") {

    echo $objFamiliar->validaSiEsUsuario($dni, ' ');

} else if ($op == "actualizarFamiliar") {

    $nroRegistros = $objFamiliar->contarFamiliares($dni);
    $arrayFamiliar = $objFamiliar->getDDatosFamiliarDNI(limpiarCadena($dni));
    //var_dump($arrayFamiliar);

    if ($nroRegistros > 0 && is_array($arrayFamiliar) || is_object($arrayFamiliar)) {


        $combo = '<select id="cmb_parentesco" name="cmb_parentesco" class="form-control">';
        $combo .= ($arrayFamiliar['parentesco']== 'Conyugue') ? '<option value="Conyugue" selected>Conyugue</option>' : '<option value="Conyugue">Conyugue</option>';
        $combo .= ($arrayFamiliar['parentesco'] == 'Madre') ? '<option value="Madre" selected>Madre</option>' : '<option value="Madre">Madre</option>';
        $combo .= ($arrayFamiliar['parentesco'] == 'Padre') ? '<option value="Padre" selected>Padre</option>' : '<option value="Padre">Padre</option>';
        $combo .= ($arrayFamiliar['parentesco'] == 'Hermano') ? '<option value="Hermano" selected>Hermano</option>' : '<option value="Hermano">Hermano</option>';
        $combo .= ($arrayFamiliar['parentesco'] == 'Hijo') ? '<option value="Hijo" selected>Hijo</option>' : '<option value="Hijo">Hijo</option>';
        $combo .= ($arrayFamiliar['parentesco'] == 'Familiar') ? '<option value="Familiar" selected>Familiar</option>' : '<option value="Familiar">Familiar</option>';
        $combo .= ($arrayFamiliar['parentesco'] == 'Otro') ? '<option value="Otro" selected>Otro</option>' : '<option value="Otro">Otro</option>';
        $combo.='</select>';

        $html = '
                <form class="card shadow p-4">

                    <div class="form-group text-left row">

                        <div class="col-md-6">
                            <label for= "txt_dni">DNI (*): Número Nacional de Identidad</label>
                            <input type="number" id="txt_dni" name= "txt_dni" class="form-control" value="' . $arrayFamiliar['dni'] . '" placeholder="DNI" min="13000000" maxlength="150" onkeypress="return validarNumericos(event);" required disable>
                        </div>
                        <div class="col-md-6">
                            <label for= "txt_dni">Telefono (*): </label>
                            <input type="text" id="txt_telefono" name= "txt_telefono" class="form-control" value="' . $arrayFamiliar['telefono'] . '" placeholder="Telefono" maxlength="15" onkeypress="return validarNumericos(event);" required autofocus>
                        </div>

                    </div>

                    <div class="form-group text-left row">

                        <div class="col-md-6">
                            <label for= "txt_dni">Nombres (*): </label>
                            <input type="text" id="txt_nombres" name= "txt_nombres" class="form-control" value="' . $arrayFamiliar['nombres'] . '" placeholder="Nombres" maxlength="150" onkeypress="return validarTexto(event);" required autofocus>
                        </div>
                        <div class="col-md-6">
                            <label for= "txt_dni">Apellidos (*): </label>
                            <input type="text" id="txt_apellidos" name= "txt_apellidos" class="form-control" value="' . $arrayFamiliar['apellidos'] . '" placeholder="Apellidos" maxlength="150" onkeypress="return validarTexto(event);" required autofocus>
                        </div>

                    </div>

                    <div class="form-group text-left row">

                        <div class="col-md-6">
                            <label for= "txt_dni">Direccion (*): </label>
                            <input type="text" id="txt_direccion" name= "txt_direccion" class="form-control" value="' . $arrayFamiliar['direccion'] . '" placeholder="Direccion" maxlength="300" required autofocus>
                        </div>
                        <div class="col-md-6">
                            <label for= "txt_dni">Correo Electronico (*): </label>
                            <input type="text" id="txt_correo" name= "txt_correo" class="form-control" value="' . $arrayFamiliar['correo'] . '" placeholder="Correo Electronico" maxlength="100" required autofocus>
                        </div>

                    </div>

                    <div class="form-group text-left row">

                        <div class="col-md-12">
                            <label for="inputPassword" class="">Parentesco (*): </label>
                            '.$combo. '
                        </div>

                    </div>
                    
                    <hr/>
                    <a id="btn_ingresar" class="btn btn-lg btn-primary btn-block" href="#" onClick=\'registrarFamiliar("actualizar");\'>Actualizar</a>
                </form>';
        echo  $html;
    }else{
        echo 0;
    }

} else if ($op == "guardar") {

    echo $objFamiliar->guardarFamiliar(
        $_SESSION['id'],
        $parentesco,
        limpiarCadena($dni),
        limpiarCadena($nombres),
        limpiarCadena($apellidos),
        limpiarCadena($direccion),
        limpiarCadena($telefono),
        limpiarCadena($correo)
    );
} else if ($op == "actualizar") {

    //var_dump($_POST);
    echo $objFamiliar->actualizarFamiliar(
        $_SESSION['id'],
        $parentesco,
        limpiarCadena($dni),
        limpiarCadena($nombres),
        limpiarCadena($apellidos),
        limpiarCadena($direccion),
        limpiarCadena($telefono),
        limpiarCadena($correo)
    );

} else if ($op == "eliminarFamiliar") {

    echo $objFamiliar->eliminarFamiliar($dni);

} else {

    if (isset($_SESSION['email'])) {
        session_destroy();
    }
    echo header("location:../");
    return false;
}
