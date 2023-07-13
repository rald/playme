<?php

function enluv($n) {
	$c="iloveu";
	$b=strlen($c);
	$v="";
	$s="p"; 
	if($n<0) { $n=-$n; $s="n"; }
	do {
		$v=$c[$n%$b].$v;
		$n=floor($n/$b);
	} while($n);
	return $s.$v;
}



function deluv($n) {
	$c="iloveu";
	$b=strlen($c);
	$j=1;
	$v=0;
	$s=1; 
	$i=strlen($n)-1;

	if($n[0]=="n") $s=-1;
	else if($n[0]=="p") $s=1;
	else return false;
	
	while($i>=1) {
		$h=$n[$i--];
		$p=strpos($c,$h);
		if($p===false) return false;
		$v+=$p*$j;
		$j*=$b;
	};
	return $s*$v;
}

?>
