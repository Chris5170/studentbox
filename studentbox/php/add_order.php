<?php
session_start();
//unset($_SESSION["vendor"]);
require_once("../classes/dbp.php");
require_once("../classes/dbobj.php");
require_once("../classes/crud.php");
require_once("../classes/image.php");
require_once("../classes/service.php");
require_once("../classes/vendor.php");
$serviceId = $_POST['id'];
$duration = $_POST['duration'];
$servings = $_POST['servings'];
if(isset($_SESSION["vendor"])){
	$savedVendor = unserialize($_SESSION["vendor"]);
	$vendor = new Vendor();
	if($savedVendor->getServices()){
		foreach($savedVendor->getServices() as $savedService){
			$service = new Service($savedService->getId());
			$service->setDuration($savedService->getDuration());
			$service->setPeople($savedService->getPeople());
			$vendor->addService($service);
		}
	}
}
else{
	$vendor = new Vendor();
}
$service = new Service($serviceId);
$service->setDuration($duration);
$service->setPeople($servings);
$vendor->addService($service);
$_SESSION["vendor"] = serialize($vendor);
header("location: ../kurv.php");
?>