<?php

$id=$_GET['id'];

$r=array_filter(explode("\n",file_get_contents("data/rank.txt")));

for($i=0;$i<count($r);$i++) {

	$d=explode(" ",$r[$i],2);

	if($d[0]==$id) {
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
