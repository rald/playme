<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>PlayMe</title>
	</head>
	<body>

<center>

<b>PlayMe</b><br><br>

<?php

$r=array_filter(explode("\n",file_get_contents("data/rank.txt")));

?>

<table>

<?php

for($i=0;$i<count($r);$i++) {

	$d=explode(" ",$r[$i],2);

	$h=$d[0];
	$p=pathinfo($d[1],PATHINFO_FILENAME);	
?>

<tr>
	<td><?=($i+1).". "?></td>
	<td><a href="player.php?id=<?=$h?>" style="text-decoration:none;"><b><?=$h?></b></a></td>
	<td><p style="width:200px;text-overflow:ellipsis;white-space:nowrap;overflow:hidden"><?=$p?></p></td>	
	<td><a href="clap.php?id=<?=$h?>">clap</a></td>	
	<td><a href="slap.php?id=<?=$h?>">slap</a></td>	
</tr>

<?php

}


?>

</table>

</center>

</body>

</html>
