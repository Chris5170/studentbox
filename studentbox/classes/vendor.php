<?php
class Vendor extends CRUD{
	private $orderId;
	private $services;
	private $customer;
	private $payment = false;
	public function __construct($services = false, $table = "orders"){
		parent::__construct($table);
		if($services !== false){
			if(is_array($services)){
				$this->services = $services;
			}
			else{
				$this->services[] = $services;
			}
		}
	}
	public function getServices(){
		if(isset($this->services)){
			return  $this->services;
		}
		else{
			return false;
		}
	}
	public function getCustomer(){
		if(isset($this->customer)){
			return  $this->customer;
		}
		else{
			return false;
		}
	}
	public function setCustomer($customer){
		$this->customer = $customer;
	}
	public function setPayment($payment){
		$this->payment = $payment;
	}
	public function addService($services){
		$this->services[] = $services;
	}
	public function placeOrder(){
		if($this->payment){
			$arr = array(
				"user_email" => $this->customer->getEmail()
			);
			$this->create($arr);
			$this->orderId = $this->getCon()->lastInsertId();
			$this->customer->createCustomer();
			$this->setTable("orders_has_services");
			foreach($this->services as $service){
				$arr = array(
					"orders_id" => $this->orderId,
					"services_id" => $service->getId(),
					"duration" => $service->getDuration(),
					"servings" => $service->getPeople()
				);
				$this->create($arr);
			}
			$this->setTable("orders");
		}
	}
}
?>