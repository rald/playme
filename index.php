<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>PlayMe</title>
	</head>
	<body>

<center>

<b>PlayMe</b><br><br>

<?php

class K {
	public $id,$karma,$url;

	function __construct($id,$karma,$url) {
		$this->id=$id;	
		$this->karma=$karma;	
		$this->url=$url;	
	}

}


$r=array_filter(explode("\n",file_get_contents("data/rank.txt")));

?>

<table>

<?php

$s=[];

for($i=0;$i<count($r);$i++) {
	$d=explode(" ",$r[$i],3);
	$h=$d[0];
	$k=intval($d[1]);
	$p=pathinfo($d[2],PATHINFO_FILENAME);

	array_push($s,new K($h,$k,$p));
}

usort($s,fn($a,$b)=>$b->karma<=>$a->karma);

for($i=0;$i<count($s);$i++) {

?>

<tr>
	<td><?=($i+1).". "?></td>
	<td><a href="player.php?id=<?=$s[$i]->id?>" style="text-decoration:none;"><b><?=$s[$i]->id?></b></a></td>
	<td><p style="width:200px;text-overflow:ellipsis;white-space:nowrap;overflow:hidden"><?=$s[$i]->url?></p></td>	
	<td align="right"><font color="<?=($k<=0?'red':'blue')?>"><?=$s[$i]->karma?></font></td>
</tr>

<?php

}


?>

</table>

</center>

</body>

</html>
