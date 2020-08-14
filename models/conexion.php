<?php
class conexion{

    private $driver;
    private $host, $port, $user, $pass, $database, $charset, $con, $urlConf;
    
    public function __construct($urlConfig){
        //Constructor de la clase -> traemos los valores de conexion globales
		$this->urlConf = $urlConfig;
		//echo "URLConfig que llega a conexion: ".$this->urlConf."<br>";
		require_once($this->urlConf);
        $this->driver=constant('driver');
        $this->host=constant('host');
		$this->port=constant('port');
        $this->user=constant('user');
        $this->pass=constant('pass');
        $this->database=constant('database');
	}
	
	public function getURLConfigConexion(){
		return "<h1>".$this->urlConf."</h1>";
	}
    
	public function conectar(){

		try {
			if($this->driver=="mysql" || $this->driver==NULL){
				$this->con = new PDO("mysql:host=".$this->host.";dbname=".$this->database, $this->user, $this->pass);
				$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			
			if($this->driver=="postgres"){
				$this->con = new PDO("pgsql:host=".$this->host.";port=".$this->port.";dbname=".$this->database.";user=".$this->user.";password=".$this->pass);
				$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			
			return $this->con;
		}catch(PDOException $e) {	
			return $e->getMessage();
			die();
		}
		
    }	
	
	public function cerrarConexion(){
		$this->con = null;
		die();
	}
	
	

}
?>