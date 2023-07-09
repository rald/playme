<?php

$id=$_GET['id'];

$f=fopen("data/".$id.".txt","r");

$title=trim(fgets($f));
$urls=array();

while($url=fgets($f)) {
	array_push($urls,trim($url));
}

echo json_encode(array("title"=>$title,"urls"=>$urls));
?>
