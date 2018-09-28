<?php
require_once("../classes/dbp.php");
require_once("../classes/dbobj.php");
require_once("../classes/crud.php");
require_once("../classes/image.php");
require_once("../classes/service.php");
$con = new CRUD("categories");
$res = $con->read("name");
if($res){
    while($cat = $res->fetchObject()){
        $categories[] = $cat;
    }
}
$con->setTable("images");
$res = $con->read("id");
if($res){
    while($image = $res->fetchObject()){
        $images[] = new Image($image->id);
    }
}
$con->setTable("services");
$res = $con->read("id");
if($res){
    while($service = $res->fetchObject()){
        $services[] = new Service($service->id);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    	<form action="../php/create_service.php" method="POST">
    		<input type="text" name="name" placeholder="input name for service..">
    		<input type="number" step="0.01" min="0" name="price" placeholder="Input a price...">
            <?php
            if(isset($categories)){
                echo "<select name='category'>";
                foreach($categories as $cat){
                    echo "<option value='" . $cat->name . "'>" . $cat->name . "</option>";
                }
                echo "</select>";
            }
            if(isset($images)){
                foreach ($images as $image) {
                    $image->setRoot('../');
                    echo "<input type='checkbox' name='images[]' value='" . $image->getId() . "'>";
                    echo "<img src='" . $image . "' alt='" . $image->getAlt() . "' style='max-height:150px'>";
                }
            }
            ?>
    		<input type="submit" value="create service">
    	</form> 
        <?php
        if(isset($services)){
            foreach ($services as $service) {
                echo $service->getName() . ", " . $service->getPrice() . ", " . $service->getCategory() . "<br>";
                foreach ($service->getImages() as $image) {
                    $image->setRoot('../');
                    echo "<img src='" . $image . "' alt='" . $image->getAlt() . "' style='max-height:150px'><br>";
                }
            }
        }
        ?>  
    </body>
</html>