<?php
# Clase encargada de las consultas basicas a base de datos
# Instancia a la clase conexion que despues hace uso para 
# enviar la conexion
class mdl_sqlBase{
	
	private $con, $table, $numRegistros, $regLog, $sql, $result, $numRows, $urlConf, $conexion;
	
	public function __construct($tabla, $urlConfig){
		$this->table = $tabla;
		$this->urlConf = $urlConfig;
		
		require_once("conexion.php");
		$this->conexion = new conexion($this->urlConf);
		$this->con = $this->conexion->conectar();
		//$this->con->setAttribute( PDO::ATTR_EMULATE_PREPARES, TRUE);
	}
	public function getUrlConfig1(){
		return "<h1>Table: ".$this->table." - UrlConfig: ".$this->urlConf."</h1><br><h2>".$this->conexion->getURLConfigConexion()."</h2>";
	}
	// #####################################
	// #####################################
	public function retornarConexion(){
		return $this->con;
	}
	// #####################################
	// #####################################
	public function ejecutarSql($consulta){
		
		try {
			$this->sql = $this->con->prepare($consulta);
			if($this->sql->execute()){
				return 1;
			}else{
				return 3;
			}
			
			$this->con = null;
		}catch (PDOException $e) {
            //return $consulta;
			return print $e->getMessage();
			return 0;
        }
	}
	// #####################################
	// #####################################
	public function eliminarRegistro($table="", $campo, $valor){
		
		try {
			if($table!=""){
				$sql = "DELETE FROM ".$table." WHERE ".$campo."=".$valor;
				$this->sql = $this->con->prepare($sql);
			}else{
				$sql = "DELETE FROM ".$this->table." WHERE ".$campo."=".$valor;
				$this->sql = $this->con->prepare($sql);
			}
			//$this->sql->bindParam(':valor', $valor);
			if($this->sql->execute()){
				return 1;
			}else{
				return 0;
			}
			//return $sql;
			$this->con = null;
		}catch (PDOException $e) {
            //return print $e->getMessage();
			return 0;
        }
		
	}
	
	public function buscarUno($campo, $valor){

		try {
			$this->sql = $this->con->prepare("SELECT * FROM ".$this->table." WHERE ".$campo."=:valor");
			$this->sql->bindParam(':valor', $valor);
			$this->sql->execute();
			return $this->sql->fetchAll();
			$this->con = null;
		}catch (PDOException $e) {
            print $e->getMessage();
			//return 0;
        }
		
	}

	public function ejecutarSqlBuscarTodos($sqlBD){
		
		try {
			/*
			SELECT * 
			FROM `prestamo`
			INNER JOIN `cliente`
			ON `prestamo`.`cedula_cliente` = `cliente`.`cedula_cliente`
			ORDER BY cliente.nombre_cliente
			*/
			$this->sql = $this->con->prepare($sqlBD);
			$this->sql->execute();
			return $this->sql->fetchAll();
			$this->con = null;
			
		}catch (PDOException $e) {
            print $e->getMessage();
			//return 0;
		}
		
	}

	public function buscarTodos($ordenPor, $orden="ASC", $campo1="", $valor=""){
	
		try {

			if(!isset($ordenPor)){
				// Si no va el parametro OrdenarPor
				$sqlQuery = "SELECT * FROM ".$this->table;	
			}else if($ordenPor!='' && $campo1!='' && $valor!=''){
				// Retorne todos los creditos id = valor o otrocampo = valor
				$sqlQuery = "SELECT * FROM ".$this->table." WHERE ".$campo1."=".$valor." ORDER BY ".$ordenPor." ".$orden;
			}else{
				$sqlQuery = "SELECT * FROM ".$this->table." ORDER BY ".$ordenPor." ".$orden;
			}		
			//print $sqlQuery;
			$this->sql = $this->con->prepare($sqlQuery);
			$this->sql->execute();
			return $this->sql->fetchAll();
			$this->con = null;
			
		}catch (PDOException $e) {
            print $e->getMessage();
			//return 0;
        }
		
	}
	// #####################################
	// ACTUALIZA UN REGISTRO
	// #####################################
	public function actualizaRegistro($campo1, $valor1, $campo2, $valor2){

		try {
			$sqlQuery = "UPDATE ".$this->table." SET ".$campo1."=".$valor1." WHERE ".$campo2."=".$valor2;	
			$this->sql = $this->con->prepare($sqlQuery);
			if($this->sql->execute()){
				return 1;
			}else{
				return $sqlQuery;
			}
			$this->con = null;
		}catch (PDOException $e) {
            print $e->getMessage();
			//return 0;
        }
	
	}
	// #####################################
	// BUSCA UN REGISTRO
	// #####################################
	public function buscarRegistro($campo, $valor=''){

		try {
			$this->sql = $this->con->prepare("SELECT * FROM ".$this->table." WHERE ".$campo."=:valor");
			$this->sql->bindParam(':valor', $valor);
			$this->sql->execute();
			return $this->sql->fetchAll();
			$this->con = null;
		}catch (PDOException $e) {
            //print $e->getMessage();
			return 0;
        }
	
	}
	// #####################################
	// Selecciona el numero mayor de la tabla
	// #####################################
	function calcularMayor($campo, $tabla, $where=""){
		
		try {
			
			$sqlMax = "SELECT MAX(".$campo.") + 1 AS mayor FROM ".$tabla." ".$where;
			
			//return $sqlMax;
			
			$this->sql = $this->con->prepare($sqlMax);
			$this->sql->execute();
			$numrows = $this->sql->rowCount();
			if($numrows>0){
				while($row = $this->sql->fetch(PDO::FETCH_ASSOC)){   
						$siguienteId=$row['mayor'];
				}
			}
			
			//echo "#Registros: ".(count($row));
			//return $row;
			return $siguienteId;
			$this->con = null;
			
		}catch (PDOException $e) {
            return $e->getMessage();
			//return $sqlMax;
			//return 0;
        }
		
	}
	// #####################################
	//Selecciona el numero mayor de la tabla
	// #####################################
	function calcularUltimoID($campo){
		
		try {
			$this->sql = $this->con->prepare('SELECT MAX('.$campo.') AS maxId FROM '.$this->table);
			//$this->sql->bindParam(':campo', $campo);
			$this->sql->execute();
			$numrows = $this->sql->rowCount();
			if($numrows>0){
				while($row = $this->sql->fetch(PDO::FETCH_ASSOC)){   
						$siguienteId = $row['maxId'];
				}
			}
			return  $siguienteId;
			$this->con = null;
		}catch (PDOException $e) {
            //print $e->getMessage();
			return 0;
        }
		
	}
	//Retorna un campo enviando un valor, ejemplo nombre enviando la cedula
	function retornarSumaRegistros($tabla, $campo, $campo2, $valor){
				
		try {
			$sqlB = "SELECT sum(".$campo.") as suma FROM ".$tabla." WHERE ".$campo2."='".$valor."'";
			$this->sql = $this->con->prepare($sqlB);
			$this->sql->execute();
			$numrows = $this->sql->rowCount();
			if($numrows>0){
				while($row = $this->sql->fetch(PDO::FETCH_ASSOC)){   
						$sumRegistros = $row['suma'];
				}
			}
			//print $sqlB;
			return $sumRegistros;
			$this->con = null;
		}catch (PDOException $e) {
            print $e->getMessage();
			//return 0;
        }
	
	}
	function retornarNumeroRegistros($tabla, $campo, $valor){
		
		try {
			$sqlB = "SELECT count(0) as conteo FROM ".$tabla." WHERE ".$campo."='".$valor."'";
			$this->sql = $this->con->prepare($sqlB);
			$this->sql->execute();
			$numrows = $this->sql->rowCount();
			if($numrows>0){
				while($row = $this->sql->fetch(PDO::FETCH_ASSOC)){   
						$numRegistros = $row['conteo'];
				}
			}
			
			return $numRegistros;
			$this->con = null;
		}catch (PDOException $e) {
            print $e->getMessage();
			//return 0;
        }
	
	}
	############################################################
	# Retorna Nro de creditos activos de un cliente
	############################################################
	function nroCreditosPendientesPorCliente($cedula){
		
		try {
			$sqlB = "SELECT count(0) as conteo FROM prestamo WHERE cedula_cliente='".$cedula."' and estado_prestamo='1'";
			$this->sql = $this->con->prepare($sqlB);
			$this->sql->execute();
			$numrows = $this->sql->rowCount();
			if($numrows>0){
				while($row = $this->sql->fetch(PDO::FETCH_ASSOC)){   
						$numRegistros = $row['conteo'];
				}
			}
			
			return $numRegistros;
			$this->con = null;
		}catch (PDOException $e) {
            print $e->getMessage();
			//return 0;
        }
	
	}
	
	//Retorna un campo enviando un valor, ejemplo nombre enviando la cedula
	function retornarCampoEnviandoCampo($tabla, $campo1, $campo2, $campo, $valor){
		
		try {	
			$sqlB = "SELECT ".$campo1.", ".$campo2." FROM ".$tabla." WHERE ".$campo." = :valor";
			$this->sql = $this->con->prepare($sqlB);
			$this->sql->bindParam(':valor', $valor);
			$this->sql->execute();
			//echo "SQL: ".$sqlB."<br>";
			$numrows = $this->sql->rowCount();
			if($numrows>0){
				while($row = $this->sql->fetch(PDO::FETCH_ASSOC)){   
						//$arreglo[] = $row;
						$arreglo = array(
						$campo1 => $row[$campo1],
						$campo2 => $row[$campo2],
						);
				}
			}
			//print_r($arreglo);
			return $arreglo;
			$this->con = null;
		}catch (PDOException $e) {
			//echo $sql;
           print $e->getMessage();
		   //print $e;
		   //return 0;
        }
		
	}
	// #####################################
	// #####################################
	//Retorna un campo enviando un valor, ejemplo nombre enviando la cedula
	function retornarCampo($tabla, $campo, $valor, $campoRetorno, $where=''){
		
		try {

			$sqlE = "SELECT ".$campoRetorno." FROM ".$tabla." WHERE ".$campo." = ".$valor;

			if($where != ''){
				$sqlE.=$where;
			}

			$this->sql = $this->con->prepare($sqlE);
			$this->sql->execute();
			$numrows = $this->sql->rowCount();
			
			//echo $sqlE;
			
			if($numrows>0){
				
				while($row = $this->sql->fetch(PDO::FETCH_ASSOC)){   
						$campoRetorno = $row[$campoRetorno];
				}
			}
			return $campoRetorno;
			$this->con = null;
		}catch (PDOException $e) {
    		print $e->getMessage();
  			//return "Table: ".$tabla." - campo: ".$campo." - valor: ".$valor." - campoR: ".$campoRetorno;
		}
		
	}

	// #####################################
	// #####################################
	//Retorna un vector de un campo enviando un valor, ejemplo nombre enviando la cedula ('cliente', 'cobrador_cliente', $cedCobrador, 'cedula_cliente')
	function retornarVectoRegistros($tabla, $campo, $valor, $campoRetorno, $orderBy=""){		
		
		try {	
			$sqlB = "SELECT ".$campoRetorno." FROM ".$tabla." WHERE ".$campo." = :valor ".$orderBy;
			//echo "<br><h1>".$sqlB."</h1><br>";
			$this->sql = $this->con->prepare($sqlB);
			$this->sql->bindParam(':valor', $valor);
			$this->sql->execute();
			return $this->sql->fetchAll();
			$this->con = null;
		}catch (PDOException $e) {
			//echo "<br><h1>".$sqlB."</h1><br>";
        	print $e->getMessage();
		   //print $e;
		   //return 0;
        }
		
		
		
		
	}	
	
}
?>