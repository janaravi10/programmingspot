<?php 
ob_start();
$connection = mysqli_connect('localhost','root','','cms');
if(!$connection){
echo "cant connect ".mysqli_error($connection);
	}
 ?>

