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
		<?php
		if($vendor){
			if($vendor->getServices()){
				$baskeEmpty = false;
				$total = 0;
				echo "<ul>";
				foreach ($vendor->getServices() as $service) {
					$total += $service->getTotal();
					echo "<li>";
					echo $service->getName() . " til " . $service->getPeople() . " personer over " . $service->getDuration() . " dage, pris: " . $service->getTotal();
					echo "</li>";
				}
				echo "</ul>";
				echo "<p>Total u/moms: " . ($total * .8) . "</p>";
				echo "<p>Moms(25%): " . ($total * .2) . "</p>";
				echo "<p>Total m/moms: " . $total . "</p>";
			}
		}
		if($baskeEmpty){
			echo "Ingen services valgt...";
		}
		?>
		<ul>
			<li>
				<a href="udvalg.php">Shop videre</a>
			</li>
			<?php
			if($baskeEmpty !== true){
			?>
			<li>
				<a href="php/empty_basket.php">Tøm kurv</a>
			</li>
			<li>
				<a href="checkout.php">Til betaling</a>
			</li>
			<?php
			}
			?>
		</ul>
	</section>
</main>

<?php
include 'footer.php';
?>