<?php
class mdl_usuario{
	
    private $tabla, $con, $sqlBase, $objPersona, $urlConfig;
	public $id, $contrasena, $creado, $acceso, $isactive;
    
    public function __construct($url){

		require_once('mdl_sqlBase.php');
		require_once('mdl_persona.php');

		$this->urlConfig = $url;
		$this->tabla = 'usuarios';
		$this->objPersona = new mdl_persona($url);
		$this->sqlBase = new mdl_sqlBase($this->tabla, $this->urlConfig);
		$this->con=$this->sqlBase->retornarConexion();

    }

    function buscarUsuario($id){

		$sql="SELECT * FROM ".$this->tabla." WHERE id='".$id."'";	
		
		$result = mysqli_query($this->con, $sql);
		$numRows = mysqli_num_rows($result);
		if($numRows>0){
			if($row = mysqli_fetch_array($result)){ 
				
				$array["id"] = $row[1];
				$array["contrasena"] = $row[2];
				$array["is_active"] = $row[3];
				$array["contrasena_usuario"] = $row[4];
				$array["perfil_usuario"] = $row[5];
				$array["estado_usuario"] = $row[6];
				
				return $array;
			}
		}else{
			return 0;
			//return $sql;
		}
		
    }


	function getDDatosUserDNI($dni)
	{

		$sql = "SELECT * FROM personas WHERE dni='" . $dni . "'";

		$this->sql = $this->con->prepare($sql);
		$this->sql->execute();
		$numrows = $this->sql->rowCount();
		$arrayPeronas = array();
		if ($numrows > 0 && $numrows<2) {

			if ($row = $this->sql->fetch(PDO::FETCH_ASSOC)) {


					$arrayPeronas = [
						'id' => $row['id'],
						'dni' => $row['dni'],
						'nombres' => $row['nombres'],
						'apellidos' => $row['apellidos'],
						'direccion' => $row['direccion'],
						'telefono' => $row['telefono'],
						'correo' => $row['correo'],
						'creado_en' => $row['creado_en'],
					];
			}

			return $arrayPeronas;
		} else {
			return 0;
		}
	}


	public function contarUsuarios($dni){
		return $this->sqlBase->retornarNumeroRegistros('personas', 'dni', $dni);
	}

	public function validaLogin($email, $contrasena){


		$datosPersona = $this->objPersona->buscarPersona('', '', '', $email, " and tipoEntidad = 'Usuario' ");
		
		$idUsuario = $datosPersona[0]['id_tipoPersona'];
		$this->actualizarFechaLogin($idUsuario);

		$consulta = $this->con->prepare("SELECT * FROM " . $this->tabla . " WHERE id=:id AND contrasena=:contrasena AND is_active='1'");
		$consulta->bindParam(':id', $idUsuario);
		$consulta->bindParam(':contrasena', $contrasena);
		$consulta->execute();
		$numrows = $consulta->rowCount();

		//var_dump($datosPersona); // livabe@gmail.com
		//echo "idUser: ".$idUsuario ." - numRows:: ".$numrows."/ Table: ".$this->tabla ;

		if ($numrows > 0) {
			
			if($row = $consulta->fetch(PDO::FETCH_ASSOC)) {

				$array[] = array(
					'id' => $idUsuario,
					'nombres' => $datosPersona[0]['nombres'].' '. $datosPersona[0]['apellidos'],
					'email' => $email,
					'is_active' => $row['is_active']
				);
			}
			//var_dump($array);
			return $array;
		} else {
			$array[0] = 0;
			return $array;
			//var_dump($consulta);
		}

	}

	public function actualizarFechaLogin($idUser){

		$this->sql = "UPDATE usuarios SET ultimo_acceso='". date('Y-m-d H:m:s')."' WHERE id='". $idUser."'";
		$this->sqlBase->ejecutarSql($this->sql);

	}

	//######################################################
	//######### GUARDA USUARIO NUEVO EN BD
	//######################################################
	public function guardarUsuario($contrasena, $dni, $nombres, $apellidos, $direccion, $telefono, $correo)
	{


		$nroPeronasConDNI = $this->sqlBase->retornarNumeroRegistros('personas', 'dni', $dni);
		$nroPeronasConCorreo = $this->sqlBase->retornarNumeroRegistros('personas', 'correo', $correo);

		if ($nroPeronasConDNI >= 2 || $nroPeronasConCorreo >= 2) {
			return 3;
		} else {


			$this->sql = "INSERT INTO " . $this->tabla . "(`id`, `contrasena`, `is_active`, `creado_en`) 
        VALUES (NULL, '" . $contrasena . "', '1', '" . date('Y-m-d H:m:s') . "')";

			if ($this->sqlBase->ejecutarSql($this->sql) == 1) {

				$idUltimoUsuario = $this->sqlBase->calcularUltimoID('id');

				$this->sql = "INSERT INTO `personas` (`id`, `dni`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `creado_en`, `tipoEntidad`, `id_tipoPersona`) 
            VALUES (NULL, '" . $dni . "', '" . $nombres . "', '" . $apellidos . "', '" . $direccion . "', '" . $telefono . "', '" . $correo . "', '" . date('Y-m-d H:m:s') . "', 'Usuario', '" . $idUltimoUsuario . "')";

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
	
	//######################################################
	//######### GUARDA USUARIO NUEVO EN BD
	//######################################################
	public function actualizarUsuario($ced, $nom, $usu, $cla, $per, $est){

		$this->sql = "UPDATE ".$this->tab." SET nombre_usuario='".$nom."', usuario_usuario='".$usu."', contrasena_usuario='".$cla."', perfil_usuario='".$per."', estado_usuario='".$est."' WHERE cedula_usuario='".$ced."'";
		//echo $this->sql;
		if($this->sqlBase->ejecutarSql($this->sql)==1){
			return 1;
		}else{
			return 0;
		}

	}
	//######################################################
	//######### RETORNA EL LISTADO DE USUARIOS 
	//######################################################
	public function getUsuarios(){
		return $this->sqlBase->buscarTodos('nombre_usuario');
	}
	
	//######################################################
	//######### DICE SI LA CEDULA EXISTE
	//######################################################
	public function getExisteUsuario($campo, $valor){
		//return $this->sqlBase->buscarTodos('nombre_usuario');
		return count($this->sqlBase->buscarUno($campo, $valor));
	}
	//######################################################
	//######### BUSCA UN USUARIO POR CEDULA
	//######################################################
	public function getUsuario($cedula){
		//return $this->sqlBase->buscarTodos('nombre_usuario');
		return $this->sqlBase->buscarUno("cedula_usuario", $cedula);
	}
	//######################################################
	//######### CAMBIA ESTADO DE UN USUARIO
	//######################################################
	public function cambiarEstadoUsuario($cedula){
		require_once('../config.php');
		$arrayUsuario = $this->sqlBase->buscarUno("cedula_usuario", $cedula);
		
		//Valida que la cedula enviada no sea la del superAdmin
		if(constant('cedSuperAdmin')!=$cedula){
			
			if($arrayUsuario[0]['estado_usuario']=="0"){
				$this->sql = "UPDATE ".$this->tab." SET estado_usuario='1' WHERE cedula_usuario='".$cedula."'";
			}else{
				$this->sql = "UPDATE ".$this->tab." SET estado_usuario='0' WHERE cedula_usuario='".$cedula."'";
			}

			if($this->sqlBase->ejecutarSql($this->sql)==1){
				return 1;
			}else{
				return 0;
			}
			
		}else{
			return 3;
		}
		
		

	}
	//######################################################
	//######### VALIDA QUE EL USUARIO NO TENGA REGISTROS Y ELIMINA
	//######################################################
	public function eliminarUsuario($cedula){
		
		$clientesConUsuario = $this->sqlBase->retornarNumeroRegistros("cliente", "cobrador_cliente", $cedula);
		
		if($clientesConUsuario==0){
			//Eliminar
			return $this->sqlBase->eliminarRegistro("usuario", "cedula_usuario", $cedula);
		}else{
			//No se puede eliminar porque tiene clientes.
			return 3;
		}
		
	}
}
?>