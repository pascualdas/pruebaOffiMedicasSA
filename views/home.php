<?php
include("models/mdl_familiar.php");
$objFamiliar = new mdl_familiar('config.php');

$familiaresArray[] = array();
$familiaresArray =  $objFamiliar->buscarFamiliar($_SESSION['id']);

//var_dump($familiaresArray);

?>

<div class="card text-left" style="margin-top: 12%;">
    <div class="card-header text-left">
        <h2 class="float-left"><i class="fa fa-users"></i>LISTADO DE FAMILIARES</h2>
        <a href="#" onclick="agregarFamiliar()" title="Agregar Familiar" class="btn btn-outline-success float-right">
            <i class="fas fa-restroom"></i> &nbsp;
            Agregar Familiar
        </a>
    </div>
    <div class="card-body  divFull">

        <table class="table table-hover">
            <thead>
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

                //var_dump($familiaresArray);
                //echo count($familiaresArray);


                if (is_array($familiaresArray) || is_object($familiaresArray)) {

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
                                        <a href="#" class="btn btn-outline-success" onclick="editarFamiliar(' . $familiar['dni'] . ');" disabled> <i class="fas fa-edit"></i> Editar </a>
                                        <a href="#" onclick="eliminarFamiliar(' . $familiar['dni'] . ');" class="btn btn-outline-primary"> <i class="fas fa-trash-alt"></i> Eliminar</a>
                                    </td>
                                </tr>';
                        } else {

                            $html .= '   <td>
                                        <a href="#" class="btn btn-outline-success" onclick="editarFamiliar(' . $familiar['dni'] . ');" disabled> <i class="fas fa-edit"></i> Editar </a>
                                        <a href="#" class="btn btn-outline-secondary" onclick="eliminarFamiliarFail();" disabled> <i class="fas fa-trash-alt"></i> Eliminar </a>
                                    </td>
                                </tr>';
                        }
                    }
                } else {
                    $html .= '<tr>
                                <td colspan="7" aling="center">No tiene familiares registrados.</td>
                     </tr>';
                }



                echo $html;

                ?>
            </tbody>
            </thead>


        </table>

    </div>

</div>