<?php
class Customer extends CRUD{
	private $name;
	private $email;
	private $address;
	private $zip;
	public function __construct($table = "customers"){
		parent::__construct($table);
	}
	public function getName(){
		return $this->name;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getAddress(){
		return $this->address;
	}
	public function getZip(){
		return $this->zip;
	}
	public function setName($name){
		$this->name = $name;
	}
	public function setEmail($email){
		$this->email = $email;
	}
	public function setAddress($address){
		$this->address = $address;
	}
	public function setZip($zip){
		$this->zip = $zip;
	}
	public function createCustomer(){
		$arr = array(
			"name" => $this->name,
			"email" => $this->email,
			"address" => $this->address,
			"zip" => $this->zip
		);
		$res = $this->read("id", "name = '" . $this->name . "' AND email = '" . $this->email . "' AND address = '" . $this->address . "' AND zip = '" . $this->zip . "'");
		if($res == false){
			$this->create($arr);
		}
	}
}
?>