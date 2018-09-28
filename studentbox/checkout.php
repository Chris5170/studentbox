<?php
session_start();
include 'head.php';
include 'header.php';
require_once("classes/dbp.php");
require_once("classes/dbobj.php");
require_once("classes/crud.php");
require_once("classes/image.php");
require_once("classes/service.php");
require_once("classes/vendor.php");
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
	$vendor = false;
}
$baskeEmpty = true;
?>

<main>
	<section class="center" id="products">
		<form action="php/checkout.php" method="POST">
			<input type="text" name="name" placeholder="Indtast dit navn" value="Chris">
			<input type="email" name="email" placeholder="Indtast din email" value="chris@mail.cc">
			<input type="text" name="address" placeholder="Indtast din addresse" value="envej 12">
			<input type="text" name="zip" placeholder="Indtast postnummer" value="6000">
			<label for="paypal">Paypal</label>
			<input id="paypal" type="radio" name="payment" value="paypal" checked>
			<label for="mobilepay">Mobilepay</label>
			<input id="mobilepay" type="radio" name="payment" value="mobilepay">
			<label for="betalingskort">Betalingskort</label>
			<input id="betalingskort" type="radio" name="payment" value="betalingskort">
			<input type="submit" value="Til betaling">
		</form>
	</section>
</main>

<?php
include 'footer.php';
?>