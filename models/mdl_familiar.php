<?php


class mdl_familiar{

    private $tabla, $con, $sqlBase, $urlConfig;
    public $id, $id_usuario, $parentesco;

    public function __construct($url)
    {
        //echo getcwd() . "\n";
        require_once('mdl_sqlBase.php');
        require_once('mdl_persona.php');

        $this->urlConfig = $url;
        $this->tabla = 'familiares';        
        $this->creado = date('Y-m-d H:m:s');

        $this->objPersona = new mdl_persona($url);
        $this->sqlBase = new mdl_sqlBase($this->tabla, $this->urlConfig);

        $this->con = $this->sqlBase->retornarConexion();
    }   

    function buscarFamiliar($UserId)
    {

            $sql = "SELECT * FROM " . $this->tabla . " WHERE id_usuario='" . $UserId . "'";
            //echo $sql;

            //$result = mysqli_query($this->con, $sql);
            $this->sql = $this->con->prepare($sql);
            $this->sql->execute();
            $numrows = $this->sql->rowCount();
            $arrayFamiliar = array();
            if ($numrows > 0) {

                while($row = $this->sql->fetch(PDO::FETCH_ASSOC)) { 

                    $arrayPeronas = $this->objPersona->buscarPersona('', '', $row["id"]);

                    foreach($arrayPeronas as $persona){

                        $arrayFamiliar[] = [
                            'id' => $persona['id'],
                            'dni' => $persona['dni'],
                            'nombres' => $persona['nombres'],
                            'apellidos' => $persona['apellidos'],
                            'direccion' => $persona['direccion'],
                            'telefono' => $persona['telefono'],
                            'correo' => $persona['correo'],
                            'creado_en' => $persona['creado_en'],
                            'parentesco' => $row["parentesco"]
                        ];

                    }

                }

                return $arrayFamiliar;

            } else {
                return 0;
            }



    }


    // VALIDA SI EL FAMILIAR TIENE CUENTA DE USUARIO
    public function validaSiEsUsuario($dniFamiliar, $where = " and tipoEntidad='Usuario' "){

        $sql = "SELECT count(id) as contador FROM personas WHERE dni='". $dniFamiliar. "'".$where;
        //echo "</br>".$sql."</br>";

        $this->sql = $this->con->prepare($sql);
        $this->sql->execute();
        $numrows = $this->sql->rowCount();
        $contadorUsuario = 0;

        if ($numrows > 0) {

            $row = $this->sql->fetch(PDO::FETCH_ASSOC);
            return $row['contador'];

        } else {
            return 0;
        }


    }

    // GUARDA FAMILIAR NUEVO
    public function guardarFamiliar($idUser, $parentesco, $dni, $nombres, $apellidos, $direccion, $telefono, $correo){


        $nroPeronasConDNI = $this->sqlBase->retornarNumeroRegistros('personas', 'dni', $dni);
        $nroPeronasConCorreo = $this->sqlBase->retornarNumeroRegistros('personas', 'correo', $correo);

        if($nroPeronasConDNI>=2 || $nroPeronasConCorreo>=2){
            return 3;
        }else{


            $this->sql = "INSERT INTO " . $this->tabla . "(`id`, `id_usuario`, `parentesco`, `creado_en`) 
        VALUES (NULL, '" . $idUser . "', '" . $parentesco . "', '" . date('Y-m-d H:m:s') . "')";

            if ($this->sqlBase->ejecutarSql($this->sql) == 1) {

                $idUltimoFamiliar = $this->sqlBase->calcularUltimoID('id');

                $this->sql = "INSERT INTO `personas` (`id`, `dni`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `creado_en`, `tipoEntidad`, `id_tipoPersona`) 
            VALUES (NULL, '" . $dni . "', '" . $nombres . "', '" . $apellidos . "', '" . $direccion . "', '" . $telefono . "', '" . $correo . "', '" . date('Y-m-d H:m:s') . "', 'Familiar', '" . $idUltimoFamiliar . "')";

                if ($this->sqlBase->ejecutarSql($this->sql) == 1) {
                    return 1;
                } else {
                    return 2;
                }
            } else {
                return 0;
            }

        }


    }

    public function actualizarFamiliar($idUser, $parentesco, $dni, $nombres, $apellidos, $direccion, $telefono, $correo)
    {


        $nroPeronasConDNIs = $this->sqlBase->retornarNumeroRegistros('personas', 'dni', $dni);


        if ($nroPeronasConDNIs < 1) {
            return 3;
        } else {


            $this->sql = "UPDATE personas SET `dni` = '" . $dni . "', `nombres` = '" . $nombres . "', `apellidos` = '" . $apellidos . "', 
            `direccion` = '" . $direccion . "', `telefono` = '" . $telefono . "', `correo` = '" . $correo . "' WHERE `dni` ='" . $dni . "'";

            if ($this->sqlBase->ejecutarSql($this->sql) == 1) {

                $idFamiliar = $this->sqlBase->retornarCampo('personas', 'dni', $dni, 'id_tipoPersona', " and tipoEntidad='Familiar'");

                $this->sql = "UPDATE familiares SET parentesco ='" . $parentesco . "' WHERE id='" . $idFamiliar . "'";

                if ($this->sqlBase->ejecutarSql($this->sql) == 1) {
                    return 1;
                } else {
                    return 2;
                }
            } else {
                return 0;
            }


        }
    }    

    public function contarFamiliares($dni)
    {
        return $this->sqlBase->retornarNumeroRegistros('personas', 'dni', $dni);
    }

    function getDDatosFamiliarDNI($dni)
    {

        $sql = "SELECT personas.id as personaId, personas.dni as dni, personas.nombres as nombres, personas.apellidos as apellidos, 
        personas.direccion as direccion, personas.telefono as telefono, personas.correo as correo, personas.creado_en as creado_en,
        familiares.id as familiarId, familiares.parentesco as parentesco
        FROM personas, familiares 
        WHERE dni='" . $dni . "' and personas.tipoEntidad='Familiar' and personas.id_tipoPersona = familiares.id";

        $this->sql = $this->con->prepare($sql);
        $this->sql->execute();
        $numrows = $this->sql->rowCount();
        $arrayPeronas = array();
        if ($numrows > 0 && $numrows < 2) {

            if ($row = $this->sql->fetch(PDO::FETCH_ASSOC)) {


                $arrayPeronas = [
                    'id' => $row['personaId'],
                    'dni' => $row['dni'],
                    'nombres' => $row['nombres'],
                    'apellidos' => $row['apellidos'],
                    'direccion' => $row['direccion'],
                    'telefono' => $row['telefono'],
                    'correo' => $row['correo'],
                    'creado_en' => $row['creado_en'],
                    'parentesco' => $row['parentesco']
                ];
            }

            return $arrayPeronas;
        } else {
            return 0;
        }
    }


    // ELIMINA FAMILIAR
    public function eliminarFamiliar($dni){

        $arrayPeronas = $this->objPersona->buscarPersona($dni);
        $dniFamiliar = $arrayPeronas[0]['id_tipoPersona'];
        //var_dump($arrayPeronas);

        if($this->sqlBase->eliminarRegistro('personas', "dni", $dni) && $this->sqlBase->eliminarRegistro('familiares', "id", $dniFamiliar)){
            return 1;
        }else{
            return 0;
        }


    }


}
