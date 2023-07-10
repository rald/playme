<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>PlayMe</title>
	</head>
	<body>

<center>

		<a href="player.php">Player</a><br><br>


<?php

$r=array_filter(explode("\n",file_get_contents("data/rank.txt")));

?>

<table>

<?php

for($i=0;$i<count($r);$i++) {

	$h=trim($r[$i]);

	$n="data/".$h.".txt";	

	$f=fopen($n,"r");
	$title=fgets($f);
	fclose($f);
	
?>

<tr>
	<td><?=($i+1).". "?></td>
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
