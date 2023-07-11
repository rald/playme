<?php

$d=json_decode(file_get_contents("php://input"),true);

$f=fopen("data/id.txt","r");
$id=(int)fgets($f);
fclose($f);

$fn=str_pad(dechex($id),4,"0",STR_PAD_LEFT);

$f=fopen("data/rank.txt","a");
fwrite($f,$fn." ".$d['playlist']."\n");
fclose($f);

$f=fopen("data/id.txt","w");
$id++;
fwrite($f,$id."\n");
fclose($f);

echo json_encode(array("status"=>"OK"));

?>
