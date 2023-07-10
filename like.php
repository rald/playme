<?php

$d=$_GET['id'];

$r=explode("\n",file_get_contents("data/rank.txt"));

for($i=0;$i<count($r);$i++) {
	if($r[$i]==$d) {
		if($i>0) { 
			$t=$r[$i-1];
			$r[$i-1]=$r[$i];
			$r[$i]=$t;
			file_put_contents("data/rank.txt",implode("\n",$r));
		}
		break;
	}
}

header("location: index.php");

?>
