<?php
require_once("../classes/dbp.php");
require_once("../classes/dbobj.php");
require_once("../classes/crud.php");
require_once("../classes/image.php");
$con = new CRUD("images");
$res = $con->read("id");
if($res){
    while($obj = $res->fetchObject()){
        $images[] = new Image($obj->id);
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
    	<form action="../php/upload_image.php" method="POST" enctype="multipart/form-data">
    		<input type="text" name="name" placeholder="input name for image..">
    		<input type="text" name="alt" placeholder="Input alt text..">
    		<input type="file" name="image">
    		<input type="submit" value="upload image">
    	</form>
        <?php
        if(isset($images)){
            foreach($images as $image){
                $image->setRoot("../");
                echo "<p>" . $image->getName() . "</p>";
                echo "<img src='" . $image . "' alt='" . $image->getAlt() . "'>";
            }
        }
        ?>
    </body>
</html>