<?php

$id=$_GET['id'];

$f=fopen("data/rank.txt","r");

while($line=fgets($f)) {
	$d=explode(" ",$line,2);
	if($d[0]==$id) {
		echo json_encode(array("playlist"=>$d[1]));
		break;
	}
}


?>
