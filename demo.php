<?php 
$number = 0;
function shownum(){
	global $number;
	echo "<h1>hello world ".$number."</h1>";
	$number++;
}
shownum();
 ?>