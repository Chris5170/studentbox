<?php
session_start();
//unset($_SESSION["vendor"]);
require_once("../classes/dbp.php");
require_once("../classes/dbobj.php");
require_once("../classes/crud.php");
require_once("../classes/image.php");
require_once("../classes/service.php");
require_once("../classes/vendor.php");
require_once("../classes/customer.php");
if(isset($_SESSION["vendor"]) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["address"]) && isset($_POST["zip"]) && isset($_POST["payment"])){
	$savedVendor = unserialize($_SESSION["vendor"]);
	$vendor = new Vendor();
	if($savedVendor->getServices()){
		$customer = new Customer();
		$customer->setName($_POST["name"]);
		$customer->setEmail($_POST["email"]);
		$customer->setAddress($_POST["address"]);
		$customer->setZip($_POST["zip"]);
		foreach($savedVendor->getServices() as $savedService){
			$service = new Service($savedService->getId());
			$service->setDuration($savedService->getDuration());
			$service->setPeople($savedService->getPeople());
			$vendor->addService($service);
		}
		switch ($_POST["payment"]) {
			case 'paypal':
				$payment = true;
				break;

			case 'mobilepay':
				$payment = true;
				break;

			case 'betalingskort':
				$payment = true;
				break;
			
			default:
				$payment = false;
				break;
		}
		$vendor->setCustomer($customer);
		$vendor->setPayment($payment);
		$vendor->placeOrder();
		unset($_SESSION["vendor"]);
		header("location: ../success.php");
	}
}
else{
	header("location: ../index.php");
}
?>