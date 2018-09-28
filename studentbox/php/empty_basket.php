<?php
session_start();
unset($_SESSION["vendor"]);
header("location: ../kurv.php");
?>