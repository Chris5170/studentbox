<?php
class DbP{
	private static $instance;
	private $default;
	private $props = array();

	private function __construct(){
		$default = array(
			"host" => "127.0.0.1",
			"user" => "root",
			"pwd" => "",
			"db" => "studentbox",
			"charset" => "utf8"
		);
		$this->setProperty($default);
		$this->default = $default;
	}
	public static function getInstance(){
		if(empty(self::$instance)){
			self::$instance = new DbP();

		}
		return self::$instance;
	}
	public function setProperty($arrorkey, $value = null){
		if(is_array($arrorkey) && $value == null){
			foreach($arrorkey as $key => $value){
				$this->props[$key] = $value;
			}
		}
		else{
			$this->props[$arrorkey] = $value;
		}
	}
	public function getProperty($key){
		if(isset($this->props[$key])){
			return $this->props[$key];
		}
		else{
			return false;
		}
	}
	public function toDefault(){
		unset($this->props);
		$this->setProperty($this->default);
	}
}
?>