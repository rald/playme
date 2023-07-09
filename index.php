<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>PlayMe</title>
	</head>
	<body>

<center>

		<a href="player.php">Player</a><br><br>


<?php

$f=fopen("data/id.txt","r");
$id=(int)fgets($f);
fclose($f);

?>

<table>

<?php

for($i=1;$i<$id;$i++) {

	$h=str_pad(dechex($i),4,"0",STR_PAD_LEFT);
	$n="data/".$h.".txt";	

	$f=fopen($n,"r");
	$title=fgets($f);
	fclose($f);
	
?>

<tr>
	<td><?=$h?></td>
	<td><a href="player.php?id=<?=$h?>"><?=$title?></a></td>
	<td><a href="like.php?id=<?=$h?>">like</a></td>	
	<td><a href="hate.php?id=<?=$h?>">hate</a></td>	
</tr>

<?php

}

?>

</table>

</center>

</body>

</html>
