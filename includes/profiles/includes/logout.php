<?php session_start(); ?>
<?php 
/* destroying the session and redirecting */
$_SESSION = array();
session_destroy();
header("Location: ../../index.php");
 ?>