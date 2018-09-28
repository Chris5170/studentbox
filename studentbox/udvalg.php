<?php
include 'head.php';
include 'header.php';
require_once("classes/dbp.php");
require_once("classes/dbobj.php");
require_once("classes/crud.php");
require_once("classes/image.php");
require_once("classes/service.php");
$con = new CRUD("services");
$res = $con->read("id");
if($res){
    while($service = $res->fetchObject()){
        $services[] = new Service($service->id);
    }
}
?>

<main>
	<section class="flex center" id="products">
		<?php
		foreach($services as $service){
			?>
				<article class="product_item">
					<img src="<?php echo $service->getImage(0); ?>" alt="<?php echo $service->getImage(0)->getAlt(); ?>">
					<h2><?php echo $service->getName(); ?></h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua.</p>
					<a href="produkt.php?product=<?php echo $service->getId(); ?>">Vælg boks</a>
				</article>
			<?php
		}
		?>
	</section>
</main>

<?php
include 'footer.php';
?>