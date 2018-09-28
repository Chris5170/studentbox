<?php
include 'head.php';
include 'header.php';
require_once("classes/dbp.php");
require_once("classes/dbobj.php");
require_once("classes/crud.php");
require_once("classes/image.php");
require_once("classes/service.php");
if(isset($_GET['product'])){
        $service = new Service($_GET['product']);

}
?>

<main>
	<section class="center" id="product">
		<div class="image_slider">
			<?php 
			$images = $service->getImages();
			foreach($images as $image){
				?>

				<img class="my_slides" src="<?php echo $image; ?>" alt="<?php echo $image->getAlt(); ?>">
				<?php
			}
			?>
		</div>
		<p class="product_desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		
		<form id="order" action="php/add_order.php" method="POST">
			<input id="radiotype5" type="radio" name="duration" value="5" checked>
			<input id="radiotype7" type="radio" name="duration" value="7">
			<div class="flex" id="type">
				<div class="radio selected" for="radiotype5">
					5 Dage
				</div>
				<div class="radio" for="radiotype7">
					7 Dage
				</div>
			</div>

			<input id="radioservings1" type="radio" name="servings" value="1" checked> 
			<input id="radioservings2" type="radio" name="servings" value="2">
			<input id="radioservings3" type="radio" name="servings" value="3">
			<input id="radioservings4" type="radio" name="servings" value="4">
			<input id="radioservings5" type="radio" name="servings" value="5">
			<div class="flex" id="servings">
				<div class="radio selected" for="radioservings1">
					1 person
				</div>
				<div class="radio" for="radioservings2">
					2 personer
				</div>
				<div class="radio" for="radioservings3">
					3 personer
				</div>
				<div class="radio" for="radioservings4">
					4 personer
				</div>
				<div class="radio" for="radioservings5">
					5 personer
				</div>
			</div>
			<input type="checkbox" name="tilvalg1" value="kod"> Ekstra kød
			<input type="checkbox" name="tilvalg2" value="gront"> Ekstra grønt
			<input type="checkbox" name="tilvalg3" value="sovs"> Ekstra sovs
			<div class="flex col" id="tilvalg">
				<div class="checkbox checked">
					<div>&#x2713</div>Ekstra kød
				</div>
				<div class="checkbox checked">
					<div>&#x2713</div>Ekstra grønt
				</div>	
				<div class="checkbox">
					<div>&#x2713</div>Ekstra sovs
				</div>		
			</div>
			<input type="hidden" name="id" value="<?php echo $service->getId(); ?>">
			<input type="submit" value="Gå til betaling">
		</form>

	</section>
</main>

<?php
include 'footer.php';
?>