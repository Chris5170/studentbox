<?php
require_once("../classes/dbp.php");
require_once("../classes/dbobj.php");
require_once("../classes/crud.php");
require_once("../classes/image.php");
$name = $_POST['name'];
$alt = $_POST['alt'];
$file = $_FILES['image'];
$image = new Image();
//$image->setPath("img/services/");
$image->setRoot("../");
$image->setName($name);
$image->setAlt($alt);
$image->setFile($file);
$image->createImage();
header("location: ../admin/images.php");
?>