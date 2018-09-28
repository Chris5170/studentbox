<?php
class DbC{
	private static $instance;
	private $dbc;
	private $con;

	private function __construct(){
		$this->dbc = DbP::getInstance();
		$this->try_connecting();
	}
	public static function getInstance(){
		if(empty(self::$instance)){
			self::$instance = new DbC();

		}
		return self::$instance;
	}
	private function try_connecting(){
		try {
			$dsn = "mysql:host=" . $this->dbc->getProperty("host") . ";dbname=". $this->dbc->getProperty("db");
		    $this->con = new PDO($dsn, $this->dbc->getProperty("user"), $this->dbc->getProperty("pwd"));
		    $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    printf("<p>Connect failed for following reason: <br/>%s</p>\n",
		        $e->getMessage());
		}
	}
	public function getCon(){
		return $this->con;
	}
}
?>