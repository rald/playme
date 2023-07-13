<?php

include "luv.php";

class K {
	public $id,$karma,$url;

	function __construct($id,$karma,$url) {
		$this->id=$id;	
		$this->karma=$karma;	
		$this->url=$url;	
	}

}

if(
	isset($_GET["id"]) &&
	isset($_GET["karma"]) &&
	isset($_GET["code"])
) {

	$id=$_GET['id'];
	$karma=intval($_GET['karma']);
	$code=$_GET['code'];

	if(enluv($karma)==$code) {

		$r=array_filter(explode("\n",file_get_contents("data/rank.txt")));

		$s=[];

		for($i=0;$i<count($r);$i++) {

			$d=explode(" ",$r[$i],3);

			$d[1]=intval($d[1]);
			if($d[0]==$id) {
				$d[1]+=$karma;
			}

			array_push($s,new K($d[0],$d[1],$d[2]));

		}

		usort($s,fn($a,$b)=>$b->karma<=>$a->karma);

		$f=fopen("data/rank.txt","w");
		for($i=0;$i<count($s);$i++) {
			fwrite($f,$s[$i]->id." ".$s[$i]->karma." ".$s[$i]->url."\n");
		}		
		fclose($f);

	}

}

?>
