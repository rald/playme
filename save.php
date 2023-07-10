<?php

$d=json_decode(file_get_contents("php://input"),true);

$f=fopen("data/id.txt","r");
$id=(int)fgets($f);
fclose($f);

$fn=str_pad(dechex($id),4,"0",STR_PAD_LEFT);
$f=fopen("data/".$fn.".txt","w");
fwrite($f,$d["title"]."\n");
for($i=0;$i<count($d["urls"]);$i++) fwrite($f,$d["urls"][$i]."\n");
fclose($f);

$f=fopen("data/rank.txt","a");
fwrite($f,$fn."\n");
fclose($f);

$f=fopen("data/id.txt","w");
$id++;
fwrite($f,$id."\n");
fclose($f);

echo json_encode(array("status"=>"OK"));

?>
