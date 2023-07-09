<?php

$d=(int)$_GET['id'];

$n1=hexdec($d);
$n2=hexdec($d);
if($n2-1>0) {
	$f1=str_pad(dechex($n1),4,"0",STR_PAD_LEFT);
	$f2=str_pad(dechex($n2-1),4,"0",STR_PAD_LEFT);
	rename("data/".$f1.".txt","data/xxxx.txt");
	rename("data/".$f2.".txt","data/".$f1.".txt");
	rename("data/xxxx.txt","data/".$f2.".txt");
}

header("location: index.php");

?>
