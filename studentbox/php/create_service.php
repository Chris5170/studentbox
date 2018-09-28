<?php
require_once("../classes/dbp.php");
require_once("../classes/dbobj.php");
require_once("../classes/crud.php");
require_once("../classes/service.php");
require_once("../classes/image.php");
$name = $_POST['name'];
$price = $_POST['price'];
$category = $_POST['category'];
$service = new Service();
$service->setName($name);
$service->setPrice($price);
$service->setCategory($category);
if(isset($_POST["images"])){
	foreach($_POST["images"] as $imageId){
		$service->addImage($imageId);
	}
}
$service->createService();
header("location: ../admin/services.php");
?>