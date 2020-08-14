<?php

class mdl_persona{

    private $tabla, $con, $sqlBase, $urlConfig;
    public $id, $dni, $nombres, $apellidos, $direccion, $telefono, $correo, $creado, $tipoEntidad, $idTipoPersona;

    public function __construct($url)
    {
        require_once('mdl_sqlBase.php');
        $this->urlConfig = $url;
        $this->tabla = 'personas';
        $this->creado = date('Y-m-d H:m:s');
        $this->sqlBase = new mdl_sqlBase($this->tabla, $this->urlConfig);
        $this->con = $this->sqlBase->retornarConexion();
    }   

    // Valida seteo de datos
    protected function validarEntradas(){

        if(isset($this->dni) && isset($this->nombres) && isset($this->apellidos) && isset($this->direccion) && isset($this->telefono) && isset($this->correo) && isset($this->creado) && isset($this->tipoEntidad) && isset($this->idTipoPersona)){
            return true;
        }else{
            return false;
        }
        
    }

    // 
    function buscarPersona($dni='', $idUsuario='', $idFamiliar='', $email = '', $where='')
    {
        if($dni == '' && $email == '' && $idUsuario == '' && $idFamiliar == ''){

            return $this->sqlBase->buscarTodos('nombres');
        
        }else{

            if($dni!=''){
                $sql = "SELECT * FROM " . $this->tabla . " WHERE dni='" . $dni . "'";
            }else if($idUsuario != ''){
                $sql = "SELECT * FROM " . $this->tabla . " WHERE id_tipoPersona='" . $idUsuario . "' and tipoEntidad='Usuario'";
            } else if ($idFamiliar != '') {
                $sql = "SELECT * FROM " . $this->tabla . " WHERE id_tipoPersona='" . $idFamiliar . "' and tipoEntidad='Familiar'";
            }else{
                $sql = "SELECT * FROM " . $this->tabla . " WHERE correo='" . $email . "'";
            }

            if($where!=''){
                $sql.= $where;
            }

            $sql.=" ORDER BY nombres";
            
            //echo $sql."</br>";

            $this->sql = $this->con->prepare($sql);
            $this->sql->execute();
            $numrows = $this->sql->rowCount();
            $arrayPersonas = array();

            if ($numrows > 0) {

                while($row = $this->sql->fetch(PDO::FETCH_ASSOC)) {

                    $arrayPersonas[] = $row;
                    // $array["dni"] = $row["id"];
                    // $array["nombres"] = $row["nombres"];
                    // $array["apellidos"] = $row["apellidos"];
                    // $array["direccion"] = $row["direccion"];
                    // $array["telefono"] = $row["telefono"];
                    // $array["correo"] = $row["correo"];
                    // $array["creado_en"] = $row["creado_en"];
                    // $array["tipoEntidad"] = $row["tipoEntidad"];
                    // $array["id_tipoPersona"] = $row["id_tipoPersona"];
                }

                return $arrayPersonas;

            } else {
                return 0;
            }

        }

    }

    public function guardarPersona(){

        if($this->validarEntradas){

                $this->sql = "INSERT INTO " . $this->tabla . " (`id`, `dni`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `creado_en`, `tipoEntidad`, `id_tipoPersona`) 
            VALUES (NULL, '" . $this->dni . "', '" . $this->nombres . "', '" . $this->apellidos . "', '" . $this->direccion . "', '" . $this->telefono . "', '" . $this->correo . "', '" . $this->creado . "', '" . $this->tipoEntidad . "', '" . $this->idTipoPersona . "');";

                if ($this->sqlBase->ejecutarSql($this->sql) == 1) {
                    return 1;
                } else {
                    return 0;
                }

        }else{
            return 2;
        }
    }

    // Actualizar Persona
    public function actualizarPersona(){ 

        if ($this->validarEntradas) {

            $this->sql = "UPDATE ".$this->tabla."  SET nombres = '" . $this->nombres . "', apellidos = '" . $this->apellidos . "', direccion = '" . $this->direccion . "', telefono = '" . $this->telefono . "', 
            correo = '" . $this->correo . "', tipoEntidad = '" . $this->tipoEntidad . "', id_tipoPersona = '" . $this->id_tipoPersona . "'
            WHERE dni = '".$this->dni."'";

            if ($this->sqlBase->ejecutarSql($this->sql) == 1) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 2;
        }

    }

    // Elimina Persona
    public function eliminarPerona($dni){

        return $this->sqlBase->eliminarRegistro($this->tabla, "dni", $dni);

    }


}

?>